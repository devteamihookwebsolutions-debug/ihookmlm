<?php
/**
 * This class contains public static functions related to rank .
 *
 * @package         MRank
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://promlmsoftware.com
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
*****************************************************************************/
?>
<?php

namespace User\App\Models\Scheduler\Rank;

use Admin\App\Models\Middleware\MCryptoConverter;
use Admin\App\Models\Middleware\MRankDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use User\App\Models\Scheduler\Rank\Rank_Impl;

class MRank
{
    public static function updateMembersRank()
    {
        Log::info('Rank upgrade cron started');
        Log::info('Rank cron: updateMembersRank started');

        $prefix = config('services.ihook.prefix', 'ihook');
        $dashboard_type = config('settings.dashboard_type', 1);

        // Crypto rates if needed
        $cryptoRates = [];
        if ($dashboard_type == 2) {
            $coins = ['bitcoin', 'ethereum', 'ripple', 'litecoin'];
            foreach ($coins as $coin) {
                $rate = MCryptoConverter::cryptoConverter($coin);
                $cryptoRates[$coin] = $rate ? floatval(str_replace(',', '', $rate)) : 0;
            }
        }

        // Lock cron
        $locked = DB::table('cronjobs')
            ->where('name', 'rank')
            ->where('action', 0)
            ->update(['action' => 1]);

        if (!$locked) {
            Log::info('Rank cron already running');
            return;
        }

        // Get members to process
        $members = DB::table("{$prefix}_matrix_members_link_table")
            ->select('members_id', 'matrix_id', 'rankid', 'higher_rank')
            ->where('members_account_status', 1)
            ->where('rankcron', 0)
            ->limit(600)
            ->get();

        Log::info('Found ' . $members->count() . ' members to process for rank upgrade');

        if ($members->isEmpty()) {
            // Reset all flags for next day
            DB::table("{$prefix}_matrix_members_link_table")
                ->where('members_account_status', 1)
                ->update(['rankcron' => 0]);

            DB::table('cronjobs')->where('name', 'rank')->update(['action' => 0]);
            Log::info('No pending members - rankcron flags reset');
            return;
        }

        foreach ($members as $member) {
            $memberId    = $member->members_id;
            $matrixId    = $member->matrix_id;
            $currentRank = $member->rankid ?? 0;
            $higherRank  = $member->higher_rank ?? $currentRank;
            $nextRank    = $currentRank + 1;

            Log::info("Processing member {$memberId} (matrix {$matrixId}) - current rank: {$currentRank}, checking for rank {$nextRank}");


            $potentialRank = $currentRank + 1;
            $highestAchievedRank = $currentRank;
            $achievedRanks = [];

            while (true) {
                $qualifiedRank = Rank_Impl::upgradeRank($memberId, $matrixId, $potentialRank);

                if ($qualifiedRank > 0) {
                    $achievedRanks[] = $potentialRank;
                    $highestAchievedRank = $potentialRank;
                    Log::info("Member {$memberId} qualifies for rank {$potentialRank} - checking next...");
                    $potentialRank++;
                } else {
                    Log::info("Member {$memberId} does NOT qualify for rank {$potentialRank} - stopping at {$highestAchievedRank}");
                    break;
                }
            }

            if (!empty($achievedRanks)) {
                $newHigherRank = max($highestAchievedRank, $higherRank);

                // Update member's current and higher rank
                DB::table("{$prefix}_matrix_members_link_table")
                    ->where('members_id', $memberId)
                    ->where('matrix_id', $matrixId)
                    ->update([
                        'rankid'             => $highestAchievedRank,
                        'higher_rank'        => $newHigherRank,
                        'rank_achieved_date' => Carbon::now(),
                        'rankcron'           => 1,
                    ]);

                Log::info("Member {$memberId} UPGRADED to rank {$highestAchievedRank} (higher: {$newHigherRank}), achieved ranks: " . implode(',', $achievedRanks));

                // Insert rank history for the final achieved rank
                DB::table("{$prefix}_members_rank_history_table")->insert([
                    'members_id'         => $memberId,
                    'deleted_members_id' => 0,
                    'rankid'             => $highestAchievedRank,
                    'updated_on'         => Carbon::now(),
                    'status'             => 1,
                    'rank_type'          => 1,
                ]);

                // Award bonuses for EACH newly achieved rank
                foreach ($achievedRanks as $achievedRank) {
                    // Get all bonus types for this rank
                    $bonusSettings = DB::table("{$prefix}_ranksetting")
                        ->where('rank_id', $achievedRank)
                        ->where('matrix_id', $matrixId)
                        ->whereIn('rank_key', ['bonus', 'directbonus', 'networkbonus', 'maxbonus'])
                        ->pluck('rank_value', 'rank_key');

                    $walletType = DB::table("{$prefix}_ranksetting")
                        ->where('rank_id', $achievedRank)
                        ->where('matrix_id', $matrixId)
                        ->where('rank_key', 'wallet')
                        ->value('rank_value') ?? 1;

                    foreach (['bonus', 'directbonus', 'networkbonus', 'maxbonus'] as $bonusType) {
                        $amount = (float) ($bonusSettings[$bonusType] ?? 0);

                        if ($amount <= 0) {
                            continue;
                        }

                        $descriptionMap = [
                            'bonus' => "Rank {$achievedRank} Achievement Bonus",
                            'directbonus' => "Rank {$achievedRank} Direct Bonus",
                            'networkbonus' => "Rank {$achievedRank} Network Bonus",
                            'maxbonus' => "Rank {$achievedRank} Matching Bonus",
                        ];

                        $historyTypeMap = [
                            'bonus' => 'rankbonus',
                            'directbonus' => 'rank_direct_bonus',
                            'networkbonus' => 'rank_network_bonus',
                            'maxbonus' => 'rank_max_bonus',
                        ];

                        $cryptoQty = 0;
                        $currencyId = 0;

                        if ($dashboard_type == 2) {
                            $cryptoId = DB::table("{$prefix}_ranksetting")
                                ->where('rank_id', $achievedRank)
                                ->where('matrix_id', $matrixId)
                                ->where('rank_key', 'cryptocurrency')
                                ->value('rank_value');

                            if ($cryptoId) {
                                $cryptoName = DB::table("{$prefix}_crypto_currency_and_token")
                                    ->where('crypto_currency_id', $cryptoId)
                                    ->value('crypto_default_name');

                                $rate = $cryptoRates[strtolower($cryptoName)] ?? 0;
                                $cryptoQty = $rate > 0 ? round($amount / $rate, 8) : 0;
                                $currencyId = $cryptoId;
                            }
                        }

                        DB::table("{$prefix}_history_table")->insert([
                            'history_member_id'     => $memberId,
                            'history_amount'        => $amount,
                            'history_type'          => $historyTypeMap[$bonusType],
                            'history_description'   => $descriptionMap[$bonusType],
                            'history_datetime'      => Carbon::now(),
                            'history_wallet_type'   => $walletType,
                            'crypto_qty'            => $cryptoQty,
                            'currency_id'           => $currencyId,
                        ]);

                        Log::info("Awarded {$bonusType} of {$amount} to member {$memberId} for achieving rank {$achievedRank}");
                    }
                }
            } else {
                Log::info("Member {$memberId} NOT qualified for any higher rank starting from {$potentialRank}");
            }

            // Always mark as processed
            DB::table("{$prefix}_matrix_members_link_table")
                ->where('members_id', $memberId)
                ->where('matrix_id', $matrixId)
                ->update(['rankcron' => 1]);
        }

        // Unlock cron
        DB::table('cronjobs')->where('name', 'rank')->update(['action' => 0]);
        Log::info('Rank upgrade cron completed successfully');
    }

    public static function createpdfold()
    {

        $members_id = 1;
        $sql = "SELECT * FROM ". $_ENV['IHOOK_PREFIX'] ."members_table where members_id='". $members_id ."'";
        $obj = new Bin_Query();
        $obj->executeQuery($sql);
        $records = $obj->records[0];
        $members_email = $records['members_email'];
        $members_username = $records['members_username'];
        $members_fullname = $records['members_firstname'] .' '. $records['members_lastname'];
        $members_address = $records['members_address'];
        $members_state = $records['members_state'];
        $members_country = $records['members_country'];
        $members_city = $records['members_city'];
        $members_phone = $records['members_phone'];
        $members_zip = $records['members_zip'];
        $company_name = $records['members_company_name'];
        $tax_id = $records['tax_id'];

        $date = date('Y-m-d');
        $company_address = 'MLM  <br>
                test 5<br>
                company, 16-400<br>
                test address';
        $sql1 = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "history_table WHERE history_id = '" . $members_id. "' ";
        $obj1 = new Bin_Query();
        $obj1->executeQuery($sql1);
        $records1   = $obj1->records;
        $tax_id = $records[0]['history_transaction_id'];
        $history_wallet_type = $records[0]['history_wallet_type'];
        if ($history_wallet_type == 1) {
            $payment_method = "E-Wallet";
        } else {
            $payment_method = "C-Wallet";
        }

        if (count((array)$records) > 0) {
            $output .= '<tr>
            <td>'. $members_username .'</td>
            <td>'. $members_fullname .'</td>
            <td>'. $records1[0]['history_datetime'] .'</td>
            <td>'. $records1[0]['history_description'] .' </td>
            <td style="text-align: center;">$'. $records1[0]['history_amount'] .' </td>
            </tr>';
        }
        $message = '<!-- DC ready -->
        <style type="text/css">
           @page{margin: 30px 0px;}
           body, html{margin:0px; padding:0px; font-family:"Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;}
           .clearfix::after{ display:block; clear:both; content:""; }
           .wfte_invoice-main{ color:#202020; font-size:14px; font-weight:400; box-sizing:border-box; width:100%; padding:0px 0px 30px 0px; margin: 30px 0px; background:#fff; height:auto;line-height: 20px; }
           .wfte_invoice-main *{ box-sizing:border-box;}
           .template_footer{color:#202020; font-size:12px; font-weight:400; box-sizing:border-box; padding:30px 0px; background:#fff; height:auto;}
           .template_footer *{ box-sizing:border-box;}
           .wfte_row{ width:100%; display:block; }
           .wfte_sub_row{ width:100%; display:block; }
           .wfte_col-1{ width:100%; display:block;}
           .wfte_col-2{ width:50%; display:block;}
           .wfte_col-3{ width:33%; display:block;}
           .wfte_col-4{ width:25%; display:block;}
           .wfte_col-6{ width:30%; display:block;}
           .wfte_col-7{ width:69%; display:block;}
           .wfte_padding_left_right{ padding:0px 30px; }
           .wfte_hr{ height:1px; font-size:0px; padding:0px; background:#cccccc; margin-bottom: 20px;}
           .wfte_company_logo_img_box{ margin-bottom:10px; }
           .wfte_company_logo_img{ width:150px; max-width:100%; }
           .wfte_doc_title{ color:#23a8f9; font-size:30px; font-weight:bold; height:auto; width:auto; float:left; line-height:22px;}
           .wfte_company_name{ font-size:18px; font-weight:bold; }
           .wfte_company_logo_extra_details{ font-size:12px; margin-top:3px;}
           .wfte_invoice_data{ line-height:20px; font-size:14px; }
           .wfte_shipping_address{ width:95%;}
           .wfte_billing_address{ width:95%; }
           .wfte_address-field-header{ font-weight:bold; font-size:14px; color:#000; padding:3px; padding-left:0px;}
           .wfte_addrss_field_main{ padding-top:15px;}
           .wfte_product_table{ width:100%; border-collapse:collapse; margin:0px; }
           .wfte_payment_summary_table_body .wfte_right_column{ text-align:left; }
           .wfte_payment_summary_table{ margin-bottom:10px; }
           .wfte_table_head_color{ color:#2e2e2e; }
           .wfte_product_table_head{}
           .wfte_product_table_head th{ height:36px; padding:0px 5px; font-size:.75rem; text-align:start; line-height:10px; border-bottom:solid 1px #7b7b7b; border-top:solid 1px #7b7b7b; font-family:"Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;}
           .wfte_product_table_body td, .wfte_payment_summary_table_body td{ font-size:12px; line-height:15px;}
           .wfte_product_table_body td{ padding:10px 5px; border-bottom:solid 1px #dddee0;}
           .wfte_product_table .wfte_right_column{ width:15%;}
           .wfte_payment_summary_table .wfte_left_column{ width:60%; }
           .wfte_product_table_body .product_td b{ font-weight:normal; }
           .wfte_product_table_head_product{width: 30%;}
           .wfte_payment_summary_table_body td{ padding:5px 5px; border:none;}
           .wfte_product_table_payment_total td{ font-size:13px; color:#000; height:28px; border-bottom:solid 1px #cccccc; border-top:solid 1px #cccccc;}
           .wfte_product_table_payment_total td:nth-child(3){ font-weight:bold; }
           .product_td b{line-height: 15px;}
           .quantity_td{ text-align: center !important; }
           /* for mPdf */
           .wfte_invoice_data{ border:solid 0px #fff; }
           .wfte_invoice_data td, .wfte_extra_fields td{ font-size:12px; padding:0px; font-family:"Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif; line-height:14px;}
           .wfte_invoice_data tr td:nth-child(2), .wfte_extra_fields tr td:nth-child(2){ font-weight:bold; }
           .wfte_signature{ width:100%; height:auto; min-height:60px; padding:5px 0px;}
           .wfte_signature_label{ font-size:12px; }
           .wfte_image_signature_box{ display:inline-block;}
           .wfte_return_policy{width:100%; height:auto; border-bottom:solid 1px #dfd5d5; padding:5px 0px; margin-top:5px; }
           .wfte_footer{width:100%; height:auto; padding:5px 0px; margin-top:5px;font-size: 12px;}
           .wfte_received_seal{ position:absolute; z-index:10; margin-top:110px; margin-left:0px; width:130px; border-radius:5px; font-size:22px; height:40px; line-height:28px; border:solid 5px #00ccc5; color:#00ccc5; font-weight:900; text-align:center; transform:rotate(-45deg); opacity:.5; }
           .float_left{ float:left; }
           .float_right{ float:right; }
           .wfte_product_table_category_row td{ padding:10px 5px;}
           .invoice_table {
           width: 100%;
           }
           .invoice_table th {
           font-size: 14px;
           border-top: 2px solid #d3d0d0;
           text-align: left;
           padding: 8px;
           border-bottom: 2px solid #d3d0d0;
           }
           .invoice_table_body td {
           font-size: 14px;
           padding: 10px;
           border-bottom: 1px solid #d3d0d0;
           }
           .invoice_table td {
           padding: 8px;
           font-size: 14px;
           }
           .table-price {
           text-align: center !important;
           }
           .invoice_table_body_final td {
           border-top: 1px solid #d3d0d0;
           border-bottom: 1px solid #d3d0d0;
           }
           table tr.invoice_table_body td:nth-child(2) {
           width: 200px;
           }
           table tr.invoice_table_body td:nth-child(3) {
           text-align: center;
           }
           table tr.invoice_table_head th:nth-child(3) {
           text-align: center;
           }
           .invoice_main {
           width: 53%
           }
           @media only screen and (max-width: 1800px) {
           .invoice_main {
           width: 65%
           }
           }
           @media only screen and (max-width: 1440px) {
           .invoice_main {
           width: 80%
           }
           }
           @media only screen and (max-width: 1200px) {
           .invoice_main {
           width: 100%
           }
           }
        </style>
        <div class="wfte_invoice-main invoice_main" data-wfte-id="1" >
           <div class="wfte_row wfte_padding_left_right clearfix" data-wfte-id="2">
              <div class="wfte_col-7 float_left" data-wfte-id="3">
                 <div class="wfte_doc_title wfte_template_element wfte_text_center" data-hover-id="doc_title" style="color: #000; text-align: left;" data-wfte-id="4">INVOICE</div>
              </div>
              <div class="wfte_col-6 float_right" data-wfte-id="5">
                 <div class="wfte_barcode wfte_template_element" data-hover-id="barcode" data-wfte-id="6">


                    <img src="https://emrolife.com/wp-content/plugins/wt-woocommerce-packing-list/admin/modules/dc/assets/images/qrcode-sample.png" class="wfte_img_qrcode wfte_hidden wfte_hidden wfte_hidden" data-wfte-id="7">
                    <img src="https://emrolife.com/wp-content/plugins/wt-woocommerce-packing-list/admin/modules/dc/assets/images/barcode_dummy.png" class="wfte_img_barcode" style="" data-wfte-id="8">



                 </div>
              </div>
           </div>
           <div class="clearfix" data-wfte-id="9"></div>
           <div class="clearfix" data-wfte-id="10"></div>
           <div class="wfte_row wfte_padding_left_right clearfix" style="margin-top: 10px;" data-wfte-id="11">
              <div class="wfte_col-7 float_left" data-wfte-id="12">
                 <div class="wfte_company_logo wfte_template_element" data-hover-id="company_logo" data-wfte-id="13">
                    <div class="wfte_company_logo_img_box" data-wfte-id="14">
                       <img src="'.$_ENV['CDNCLOUDEXTURL'].'/'.$_SESSION['site_settings']['site_logo'].'" class="wfte_company_logo_img" data-wfte-id="15">
                    </div>
                 </div>
              </div>
              <div class="wfte_col-6 float_right" data-wfte-id="18">
                 <div class="wfte_from_address wfte_template_element wfte_text_left" data-hover-id="from_address" style="color: rgb(32, 32, 32);" data-wfte-id="19">
                    <div class="wfte_from_address_val" data-wfte-id="20">
                       '. $company_address .'
                    </div>
                 </div>
              </div>
           </div>
           <div class="clearfix" data-wfte-id="21"></div>
           <div class="wfte_row wfte_padding_left_right clearfix" style="padding-top: 15px;" data-wfte-id="22">
              <div class="wfte_col-1 float_left wfte_text_left" data-wfte-id="23">
              </div>
           </div>
           <div class="clearfix" data-wfte-id="24"></div>
           <div class="wfte_row wfte_padding_left_right clearfix" data-wfte-id="25">
              <div class="wfte_col-7 float_left" data-wfte-id="26">
                 <div class="wfte_sub_row clearfix" data-wfte-id="27">
                    <div class="wfte_col-2 float_left wfte_text_left" data-wfte-id="28">
                       <div class="wfte_billing_address wfte_template_element" data-hover-id="billing_address" data-wfte-id="29">
                          <div class="wfte_address-field-header wfte_billing_address_label" data-wfte-id="30">Billing Address:</div>
                          <div class="wfte_billing_address_val" data-wfte-id="31">
                            '. $members_fullname .' <br>
                             '. $members_address .' <br>
                             '. $members_city .' <br>
                             '. $members_state .', '. $members_zip .' <br>
                             '. $members_country .' <br>
                             Email: '.$members_email.' <br>
                             Phone: '. $members_phone .' <br>
                          </div>
                       </div>
                    </div>
                    <div class="wfte_col-2 float_right wfte_text_left" data-wfte-id="39">
                       <div class="wfte_shipping_address wfte_template_element" data-hover-id="shipping_address" data-wfte-id="40">
                          <div class="wfte_address-field-header wfte_shipping_address_label" data-wfte-id="41">Shipping Address:</div>
                          <div class="wfte_shipping_address_val" data-wfte-id="42">
                             '. $members_fullname .' <br>
                             '. $members_address .' <br>
                             '. $members_city .' <br>
                             '. $members_state .', '. $members_zip .' <br>
                             '. $members_country .'
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
              <div class="wfte_col-6 float_right wfte_text_left" data-wfte-id="43">
                 <div class="wfte_invoice_data" data-wfte-id="44">
                    <div class="wfte_invoice_date wfte_template_element" data-invoice_date-format="m-d-Y" data-hover-id="invoice_date" data-wfte-id="45">
                       <span class="wfte_invoice_date_label" data-wfte-id="46">Invoice Date: <b>'.$date.'</b> <br>
                       Order Date: <b>'.$date.'</b></br>Company Name : <b>'. $company_name .'</b><br>Tax ID : <b>'. $tax_id .'</b></span>
                    </div>
                 </div>
              </div>
           </div>
           <div class="clearfix" data-wfte-id="58"></div>
           <div class="wfte_row wfte_padding_left_right clearfix" style="padding-top: 15px;" data-wfte-id="64">
              <div class="wfte_col-2 float_left wfte_text_left" data-wfte-id="65">
              </div>
           </div>
           <div class="clearfix" data-wfte-id="66"></div>
           <div class="wfte_row wfte_padding_left_right clearfix" data-wfte-id="67">
              <div class="wfte_col-1" data-wfte-id="68">
                 <table class="invoice_table">
                    <tr class="invoice_table_head">
                       <th>S NO</th>
                       <th>USERNAME</th>
                       <th>DATE</th>
                       <th>DISCRIPTION</th>
                       <th class="table-price">TOTAL AMOUNT</th>
                    </tr>
                    '. $output .'
                    <tr class="invoice_table_body_final">
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td>Total<span style="float: right;
                          width: 59%;">&nbsp;<b>'. $records1[0]['history_amount'] .'</b></span></td>
                    </tr>
                 </table>
              </div>
           </div>
           <div class="clearfix" data-wfte-id="102"></div>
           <div class="wfte_row wfte_padding_left_right clearfix" style="margin-top: 15px;" data-wfte-id="103">
              <div class="wfte_col-2 float_left wfte_text_left" data-wfte-id="104">
              </div>
           </div>
           <div class="clearfix" data-wfte-id="105"></div>
           <div class="wfte_row wfte_padding_left_right clearfix" data-wfte-id="106">
              <div class="wfte_col-1 float_left" data-wfte-id="107">
                 <div class="wfte_invoice_data" data-wfte-id="108">
                    <div class="wfte_product_table_payment_method" data-wfte-id="109">
                       <span class="wfte_product_table_payment_method_label" style="font-weight:normal;" data-wfte-id="110">Payment Mode: '. $payment_method .'</span>
                    </div>
                 </div>
              </div>
           </div>
           <div class="clearfix" data-wfte-id="112"></div>
        </div>';
        //print_r($message); exit;

        return $message;
        //  echo"<pre>";print_r($output);exit;
    }

    public static function createpdf()
    {
        $id = 26;
        $id1 = 1;
        //  $members_id = $_SESSION['default']['customer_id'];

        $memberdetails                      = MMembersDetails::getUserDetails($id);

        $username                           = $memberdetails['members_username'];
        $members_firstname                           = $memberdetails['members_firstname'];
        $members_lastname                           = $memberdetails['members_lastname'];

        $user_address                       = $memberdetails['members_address'];
        $members_city                       = $memberdetails['members_city'];
        $members_zip                       = $memberdetails['members_zip'];
        $email                            = $memberdetails['members_email'];
        $members_phone                    = $memberdetails['members_phone'];
        $firma_name                    = $memberdetails['firma_name'];
        $firma_ust_id                    = $memberdetails['firma_ust_id'];
        $vat_id                    = $memberdetails['vat_id'];
        $members_company_name   = $memberdetails['members_company_name'];


        $sql = "SELECT * FROM promlm_paymenthistory_table WHERE paymenthistory_id = '" . $id1 . "' ";
        $obj = new Bin_Query();
        $obj->executeQuery($sql);
        $records   = $obj->records;

        //echo "<pre>"; print_r($records); exit;
        $date = date('Y-m-d');

        $site_currency = $_SESSION['site_settings']['site_currency'];
        $paymenthistory_amount = $records[0]['paymenthistory_amount'];
        $paymenthistory_plan_id = $records[0]['paymenthistory_plan_id'];
        $paymenthistory_date = $records[0]['paymenthistory_date'];
        $paymenthistory_trans_id = $records[0]['paymenthistory_trans_id'];

        $memberdetails                      = MPackageDetails::getPackageDetails($paymenthistory_plan_id);
        //  echo "<pre>"; print_r($memberdetails); exit;
        $packagename = $memberdetails['package_name'];
        //  $package_price = $memberdetails['package_price'];
        $output = '<style type="text/css"> @page{margin: 30px 0px;} body, html{margin:0px; padding:0px; font-family:"Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;} .clearfix::after{ display:block; clear:both; content:""; } .wfte_invoice-main{ color:#575962; font-size:14px; font-weight:400; box-sizing:border-box; width:100%; padding:0px 0px 30px 0px; margin: 30px 0px; background:#fff; height:auto;line-height: 20px; } .wfte_invoice-main *{ box-sizing:border-box;} .template_footer{color:#575962; font-size:12px; font-weight:400; box-sizing:border-box; padding:30px 0px; background:#fff; height:auto;} .template_footer *{ box-sizing:border-box;} .wfte_row{ width:100%; display:block; } .wfte_sub_row{ width:100%; display:block; } .wfte_col-1{ width:100%; display:block;} .wfte_col-2{ width:50%; display:block;} .wfte_col-3{ width:33%; display:block;} .wfte_col-4{ width:25%; display:block;} .wfte_col-6{ width:30%; display:block;} .wfte_col-7{ width:69%; display:block;} .wfte_padding_left_right{ padding:0px 30px; } .wfte_hr{ height:1px; font-size:0px; padding:0px; background:#cccccc; margin-bottom: 20px;} .wfte_company_logo_img_box{ margin-bottom:10px; } .wfte_company_logo_img{ width:210px; max-width:100%; } .wfte_doc_title{ color:#23a8f9; font-size:30px; font-weight:bold; height:auto; width:auto; float:left; line-height:22px;} .wfte_company_name{ font-size:18px; font-weight:bold; } .wfte_company_logo_extra_details{ font-size:12px; margin-top:3px;} .wfte_invoice_data{ line-height:20px; font-size:14px; } .wfte_shipping_address{ width:95%;} .wfte_billing_address{ width:95%; } .wfte_address-field-header{ font-weight:bold; font-size:14px; color:#000; padding:3px; padding-left:0px;} .wfte_addrss_field_main{ padding-top:15px;} .wfte_product_table{ width:100%; border-collapse:collapse; margin:0px; } .wfte_payment_summary_table_body .wfte_right_column{ text-align:left; } .wfte_payment_summary_table{ margin-bottom:10px; } .wfte_table_head_color{ color:#2e2e2e; } .wfte_product_table_head{} .wfte_product_table_head th{ height:36px; padding:0px 5px; font-size:.75rem; text-align:start; line-height:10px; border-bottom:solid 1px #7b7b7b; border-top:solid 1px #7b7b7b; font-family:"Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;} .wfte_product_table_body td, .wfte_payment_summary_table_body td{ font-size:12px; line-height:15px;} .wfte_product_table_body td{ padding:10px 5px; border-bottom:solid 1px #dddee0;} .wfte_product_table .wfte_right_column{ width:15%;} .wfte_payment_summary_table .wfte_left_column{ width:60%; } .wfte_product_table_body .product_td b{ font-weight:normal; } .wfte_product_table_head_product{width: 30%;} .wfte_payment_summary_table_body td{ padding:5px 5px; border:none;} .wfte_product_table_payment_total td{ font-size:13px; color:#000; height:28px; border-bottom:solid 1px #cccccc; border-top:solid 1px #cccccc;} .wfte_product_table_payment_total td:nth-child(3){ font-weight:bold; } .product_td b{line-height: 15px;} .quantity_td{ text-align: center !important; } /* for mPdf */ .wfte_invoice_data{ border:solid 0px #fff; } .wfte_invoice_data td, .wfte_extra_fields td{ font-size:12px; padding:0px; font-family:"Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif; line-height:14px;} .wfte_invoice_data tr td:nth-child(2), .wfte_extra_fields tr td:nth-child(2){ font-weight:bold; } .wfte_signature{ width:100%; height:auto; min-height:60px; padding:5px 0px;} .wfte_signature_label{ font-size:12px; } .wfte_image_signature_box{ display:inline-block;} .wfte_return_policy{width:100%; height:auto; border-bottom:solid 1px #dfd5d5; padding:5px 0px; margin-top:5px; } .wfte_footer{width:100%; height:auto; padding:5px 0px; margin-top:5px;font-size: 12px;} .wfte_received_seal{ position:absolute; z-index:10; margin-top:110px; margin-left:0px; width:130px; border-radius:5px; font-size:22px; height:40px; line-height:28px; border:solid 5px #00ccc5; color:#00ccc5; font-weight:900; text-align:center; transform:rotate(-45deg); opacity:.5; } .float_left{ float:left; } .float_right{ float:right; } .wfte_product_table_category_row td{ padding:10px 5px;} .invoice_table { width: 100%; border-collapse: collapse; border-spacing: 0; margin-bottom: 20px; } .invoice_table th { font-size: 14px; border-top: 2px solid #d3d0d0; text-align: left; padding: 8px; border-bottom: 2px solid #d3d0d0; font-weight: 400; } .invoice_table_body td { font-size: 14px; padding: 10px; border-bottom: 1px solid #d3d0d0; } .invoice_table td { padding: 8px; font-size: 14px; } .table-price { text-align: center !important; } .invoice_table_body_final td { border-top: 1px solid #d3d0d0; border-bottom: 1px solid #d3d0d0; } table tr.invoice_table_body td:nth-child(2) { width: 200px; } table tr.invoice_table_body td:nth-child(3) { text-align: center; } table tr.invoice_table_head th:nth-child(3) { text-align: center; } .invoice_main { width: 53%; margin: 0 auto; border: 1px solid #ddd; margin-top: 25px; } .btn.btn-primary { color: #fff; } .btn { padding: 0.65rem 1.95rem; } .m-5 { margin: 3rem !important; } .btn { display: inline-block; font-weight: 400; text-align: center; white-space: nowrap; vertical-align: middle; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; border: 1px solid transparent; padding: 0.45rem 1.15rem; font-size: 1rem; line-height: 1.25; border-radius: 0.25rem; margin-left: 25px !important; } .wfte_from_address_val p { margin: 0; text-align: right; } table .no { color: #FFF; font-size: 1.6em; background: #57B223; text-align: center; } table .desc { text-align: left; } table .unit { background: #DDD; text-align: right !important; } table .total { background: #57B223; color: #FFF; text-align: right; } table td, table th { padding: 10px 15px; } table td h3 { color: #57B223; font-size: 1.2em; margin: 0 0 0.2em; } table td h3, table th { font-weight: 400; } table tfoot tr:last-child td { color: #57B223; font-size: 1.4em; border-top: 1px solid #57B223; text-align: right; } table td.total, table td.unit, table tfoot td { font-size: 1.2em; } #client, #notices { padding-left: 6px; border-left: 6px solid #0087C3; } #client .to { color: #777; } #company, #invoice, table td { text-align: right; } #invoice h1 { font-size: 1.5em; } #invoice h1 { color: #0087C3; font-size: 1.5em; line-height: 1em; margin: 0 0 10px; } #invoice h1, h2.name, table td h3, table th { font-weight: 400; } #invoice .date { font-size: 1.1em; color: #777; } h3, .h3 { font-size: 1.75rem; margin-bottom: 0.5rem; font-family: inherit; font-weight: 500; line-height: 1.2; color: inherit; } @media only screen and (max-width: 1800px) { .invoice_main { width: 65% } } @media only screen and (max-width: 1440px) { .invoice_main { width: 80% } } @media only screen and (max-width: 1200px) { .invoice_main { width: 100% } } </style> <div class="wfte_invoice-main invoice_main" data-wfte-id="1" > <div class="wfte_row wfte_padding_left_right clearfix" data-wfte-id="2"> <div class="wfte_col-7 float_left" data-wfte-id="3"> <!-- <div class="wfte_doc_title wfte_template_element wfte_text_center" data-hover-id="doc_title" style="color: #000; text-align: left;" data-wfte-id="4">INVOICE</div> --> </div> </div> <div class="clearfix" data-wfte-id="9"></div> <div class="clearfix" data-wfte-id="10"></div> <div class="wfte_row wfte_padding_left_right clearfix" style="margin-top: 10px;" data-wfte-id="11"> <div class="wfte_col-7 float_left" data-wfte-id="12"> <div class="wfte_company_logo wfte_template_element" data-hover-id="company_logo" data-wfte-id="13"> </div> </div> <div class="wfte_col-6 float_right" data-wfte-id="18"> <div class="wfte_from_address wfte_template_element wfte_text_left" data-hover-id="from_address" style="color: rgb(32, 32, 32);" data-wfte-id="19"> <div class="wfte_from_address_val" data-wfte-id="20"> <h2 style="margin: 0;font-weight: 400;text-align: right;">MLM</h2> </div> </div> </div> <div class="wfte_col-7 float_left" data-wfte-id="12"> <div class="wfte_company_logo wfte_template_element" data-hover-id="company_logo" data-wfte-id="13"> <div class="wfte_company_logo_img_box" data-wfte-id="14"> <img src="'.$_ENV['CDNCLOUDEXTURL'].'/'.$_SESSION['site_settings']['site_logo'].'" class="wfte_company_logo_img" data-wfte-id="15"> </div> </div> </div> <div class="wfte_col-6 float_right" data-wfte-id="18"> <div class="wfte_from_address wfte_template_element wfte_text_left" data-hover-id="from_address" style="color: rgb(32, 32, 32);" data-wfte-id="19"> <div class="wfte_from_address_val" data-wfte-id="20"> <p>MLM Core,</p> <p>test test 561 S402D,</p> <p>4050-325 test</p> <p>TEST</p> </div> </div> </div> </div> <div class="clearfix" data-wfte-id="21"></div> <div class="wfte_row wfte_padding_left_right clearfix" style="padding-top: 15px;" data-wfte-id="22"> <div class="wfte_col-1 float_left wfte_text_left" data-wfte-id="23"> </div> </div> <div class="clearfix" data-wfte-id="24"></div> <div class="wfte_row wfte_padding_left_right clearfix" style=" border-top: 1px solid #AAA; margin: 0px 30px; width: 95%;" data-wfte-id="22"> </div> <div class="wfte_row wfte_padding_left_right clearfix" data-wfte-id="22"> <div id="client"> <h3>'. $members_firstname .' '. $members_lastname .'<br>'. $companyname .'<br>'. $user_address .',<br>'. $members_city .' '. $members_zip .'</h3> <br> <div class="to"></div> <div id="invoice"> <div class="address" style="float: left;color: #0c0c0c;font-size: 1.5em; line-height: 1em; margin: 0 0 10px; ">Date : '. $paymenthistory_date .'</div> <h1>invoice no '. $paymenthistory_trans_id .'</h1> <div class="date"></div> </div> </div> </div> <div class="clearfix" data-wfte-id="66"></div> <div class="wfte_row wfte_padding_left_right clearfix" data-wfte-id="67"> <div class="wfte_col-1" data-wfte-id="68"> <table class="invoice_table"> <tr class="invoice_table_head"> <th class="no">#</th> <th class="desc">Package Name</th> <th class="unit">Package Purchased Date</th> <th class="total">TOTAL</th> </tr> <tr class="invoice_table_body_final"> <td class="no">01</td> <td class="desc"> <h3>'. $packagename .'</h3> </td> <td class="unit">'. $paymenthistory_date .'</td> <td class="total">'. $site_currency .' '. $paymenthistory_amount .'</td> </tr> <tfoot style=" border-bottom: 1px solid #57b223; margin-top: 0%;"> <tr> </tr> <tr> <td colspan="3"></td> <td>'. $site_currency .' '. $paymenthistory_amount .'</td> </tr> </tfoot> </table> </div> </div> <div class="clearfix" data-wfte-id="102"></div> <div class="wfte_row wfte_padding_left_right clearfix" style="margin-top: 15px;" data-wfte-id="103"> <div class="wfte_col-2 float_left wfte_text_left" data-wfte-id="104"> </div> </div> <div class="clearfix" data-wfte-id="105"></div> <div class="wfte_row wfte_padding_left_right clearfix" style="padding-top: 15px;" data-wfte-id="22"> <div class="wfte_col-1 float_left wfte_text_left" data-wfte-id="23"> </div> </div> <div class="clearfix" data-wfte-id="24"></div> <div class="wfte_row wfte_padding_left_right clearfix" data-wfte-id="25"> <div class="wfte_col-7 float_left" data-wfte-id="26"> <div class="wfte_sub_row clearfix" data-wfte-id="27"> <div class="wfte_col-2 float_left wfte_text_left" data-wfte-id="28"> <div class="wfte_billing_address wfte_template_element" data-hover-id="billing_address" data-wfte-id="29"> <div class="wfte_billing_address_val" data-wfte-id="31"> MLM Core, <br> TEST 561 S402D <br> TEST - TEST<br> </div> </div> </div> <div class="wfte_col-2 float_right wfte_text_left" data-wfte-id="39"> <div class="wfte_shipping_address wfte_template_element" data-hover-id="shipping_address" data-wfte-id="40"> <div class="wfte_shipping_address_val" data-wfte-id="42"> INFO@MLM.CORE <br> CEO:MLM CORE <br> Reg-Nr:xxx xx1 xx2 <br> VAT-ID:XXXXXXXXX82 </div> </div> </div> </div> </div> <div class="wfte_col-6 float_right wfte_text_left" data-wfte-id="43"> <div class="wfte_invoice_data" data-wfte-id="44"> <div class="wfte_invoice_date wfte_template_element" data-invoice_date-format="m-d-Y" data-hover-id="invoice_date" data-wfte-id="45"> <span class="wfte_invoice_date_label" data-wfte-id="46">Bank of Portugal <br> IBAN: XX50-XXXX-0000-XXXXXXXXX90-05</br>BIC : XXXXXXXXLPH<br></span> </div> </div> </div> </div> <div class="clearfix" data-wfte-id="58"></div> <div class="wfte_row wfte_padding_left_right clearfix" style="padding-top: 15px;" data-wfte-id="64"> <div class="wfte_col-2 float_left wfte_text_left" data-wfte-id="65"> </div> </div> <div class="clearfix" data-wfte-id="112"></div> </div>';
        //print_r($output); exit;

        return $output;

    }

    public static function binresponse()
    {


        $callbackResponse = file_get_contents('php://input');

        $callbackResponse = json_encode($callbackResponse);

        $history = new Bin_Query();
        $sql_history    = "INSERT INTO binace_webhookresp (webhook_response,post_response)
                        VALUES ('". $callbackResponse . "','1')";

        if ($history->updateQuery($sql_history)) {

            $sql_bn = "SELECT * FROM binace_webhookresp ORDER BY id DESC limit 0,1";
            $obj_bn    = new Bin_Query();
            $obj_bn->executeQuery($sql_bn);
            $records_bn = $obj_bn->records;

            $hookresp    = $records_bn[0]['webhook_response'];

            $str1  = '"{"';
            $str2  = '"}"';

            $replc_1 = str_replace($str1, '{"', $hookresp);

            $replc_1 = str_replace($str2, '"}', $replc_1);

            $hookresp_decodde = json_decode($replc_1);

            $bizId = $hookresp_decodde->bizId;
            $bizId = trim($bizId);
            $bizStatus = $hookresp_decodde->bizStatus;
            $bizStatus = trim($bizStatus);

            if ($bizStatus == 'PAY_SUCCESS') {

                $lastpackpurchase = "SELECT * FROM  " . $_ENV['IHOOK_PREFIX'] . "paymenthistory_table
                WHERE prepayId='" . $bizId . "' and paymenthistory_status = 'notpaid' ORDER BY paymenthistory_id DESC limit 0,1";
                $last_paymentobj  = new Bin_Query();
                $last_paymentobj->executeQuery($lastpackpurchase);
                $last_paymentrecord = $last_paymentobj->records;

                $members_id = $last_paymentrecord[0]['paymenthistory_member_id'];

                $total = count($last_paymentrecord);

                // $members_id = 58;

                if ($total != '0') {

                    $sql = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "matrix_members_link_table WHERE members_id ='" . $members_id . "' ";
                    $obj    = new Bin_Query();
                    $obj->executeQuery($sql);
                    $records = $obj->records;

                    $members_id = $records[0]['members_id'];
                    $matrix_id = $records[0]['matrix_id'];
                    $package_id = $records[0]['members_subscription_plan'];
                    $direct_id = $records[0]['direct_id'];

                    $planqry = "UPDATE " . $_ENV['IHOOK_PREFIX'] . "paymenthistory_table
            SET paymenthistory_status='paid'
            WHERE paymenthistory_member_id='" . $members_id . "'";
                    $planobj = new Bin_Query();
                    $planobj->updateQuery($planqry);

                    $members_param        = 'members_username,members_doj,members_firstname,members_lastname,members_address,members_city,members_state,members_zip,members_phone,members_email,members_country';
                    $members_details      = MMembersDetails::getPartMembersDetails($members_param, $members_id);
                    $members_username     = $members_details['members_username'];
                    $username     = $members_details['members_username'];
                    $first_name   = $members_details['members_firstname'];
                    $last_name   = $members_details['members_lastname'];
                    $members_address   = $members_details['members_address'];
                    $members_city   = $members_details['members_city'];
                    $members_state   = $members_details['members_state'];
                    $members_zip   = $members_details['members_zip'];
                    $members_country   = $members_details['members_country'];
                    $members_phone   = $members_details['members_phone'];
                    $email   = $members_details['members_email'];


                    $entry_criteria = 3;
                    $matrix_type_id = 1;

                    $where                          = 'WHERE package_id="' . $package_id . '" AND matrix_id="' . $matrix_id . '"';
                    $packagedetails                  = MPackageDetails::getParamPackageDetails('package_price', $where);
                    $package_price      = $packagedetails['package_price'];
                    MPackageRegisterSuccess::packageRegisterSuccess($members_id, $direct_id, $matrix_id, $entry_criteria, $package_price, $package_id, $members_username, $matrix_type_id);


                    /*$where                          = 'WHERE package_id="' . $package_id . '" AND matrix_id="' . $matrix_id . '"';
                    $packagedetails                  = MPackageDetails::getParamPackageDetails('package_pv',$where);
                    $package_pv      = $packagedetails['package_pv'];
                    if($package_pv!='0'){
                        MSentPVSuccess::sentPV($members_id, $package_pv, $matrix_id, $package_id);
                    }
  */
                    $where                          = 'WHERE package_id="' . $package_id . '" AND matrix_id="' . $matrix_id . '"';
                    $packagedetails                  = MPackageDetails::getParamPackageDetails('package_price', $where);
                    $package_price      = $packagedetails['package_price'];

                    MSentDirectCommissionSuccess::bonustoadminpool($package_price, $members_id);

                    self::rankcheck($members_id);

                    $key_where = "WHERE sitesettings_name ='woocommerce_key' ";
                    $sitesettings = MSiteDetails::getSiteSettingsDetails($key_where);
                    $woocommerce_key = trim($sitesettings[0]['sitesettings_value']);

                    $secret_where = "WHERE sitesettings_name ='woocommerce_secret' ";
                    $sitesettings = MSiteDetails::getSiteSettingsDetails($secret_where);
                    $woocommerce_secret = trim($sitesettings[0]['sitesettings_value']);


                    $payment_mode = 'Credit Card (Stripe)';
                    $payment_method = 'stripe';

                    if ($package_id == 1) {
                        $product_id = '49168';
                        $amt_gls = '0.00';
                    } elseif ($package_id == 2) {
                        $product_id = '49170';
                        $amt_gls = '0.00';
                    } elseif ($package_id == 3) {
                        $product_id = '49172';
                        $amt_gls = '0.00';
                    } elseif ($package_id == 4) {
                        $product_id = '49174';
                        $amt_gls = '0.00';
                    } elseif ($package_id == 5) {
                        $product_id = '49176';
                        $amt_gls = '0.00';
                    }

                    $additionashipping = ',"shipping_lines": [{"method_id": "free_shipping","method_title": "Home delivery with GLS Courier Service","total":"0.00"}]';

                    $datafields2 = '{"payment_method": "'.$payment_method.'", "payment_method_title": "'.$payment_mode.'", "status": "processing", "set_paid": true , "billing": { "username": "'.$username.'",   "first_name": "'.$first_name.'",    "last_name": "'.$last_name.'",    "address_1": "'.$members_address.'",    "address_2": "",    "city": "'.$members_city.'",    "state": "'.$members_state.'",    "postcode": "'.$members_zip.'",    "country": "'.$members_country.'",    "email": "'.$email.'",    "phone": "'.$members_phone.'" }, "shipping": { "username": "'.$username.'",    "first_name": "'.$first_name.'",    "last_name": "'.$last_name.'",    "address_1": "'.$members_address.'",    "address_2": "",    "city": "'.$members_city.'",    "state": "'.$members_state.'",    "postcode": "'.$members_zip.'",    "country": "'.$members_country.'",    "email": "'.$email.'",    "phone": "'.$members_phone.'"  },"line_items": [{"product_id": '.$product_id.', "quantity": 1 }]}';
                    //"coupon_lines": [{"code": "npcs_bronze"}]

                    $curl2 = curl_init();
                    curl_setopt_array($curl2, array(CURLOPT_URL => "https://softlearners.net/wp-json/wc/v3/orders?consumer_key=" . $woocommerce_key . "&consumer_secret=" . $woocommerce_secret . "", CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => "", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 30, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => "POST", CURLOPT_POSTFIELDS => $datafields2, CURLOPT_HTTPHEADER => array("cache-control: no-cache", "content-type: application/json",),));

                    $response2 = curl_exec($curl2);
                    $responsearray2 = json_decode($response2);
                    $wp_customer_id = $responsearray2->id;


                }


            }


        }

        return true;


    }


    public static function transaction1()
    {


        $user_id = $_SESSION['default']['customer_id'];
        $sql = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "history_table WHERE history_member_id='" . $user_id . "'";// exit;
        $obj = new Bin_Query();
        $obj->executeQuery($sql);
        $transactionrecords      = $obj->records;
        $output = '';
        $sno = 0;
        // echo"<pre>";  print_r($transactionrecords);exit;
        for ($i = 0; $i < count((array)$transactionrecords); $i++) {
            $sno = $sno + 1;
            $date   = MFormatDate::formatingDate($transactionrecords[$i]['history_datetime']);
            $status = $status_list[rand(0, 2)];
            $id     = ($i + 1);
            if ($transactionrecords[$i]['history_type'] == 'withdraw_pending') {
                $payment_status = '<span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300"> PENDING</span>';
            } else {
                $payment_status = '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300"> COMPLETED </span>';
            }
            if (trim($transactionrecords[$i]['history_type']) == 'pv') {
                $site_currency  = '';
                $history_amount = number_format($transactionrecords[$i]['history_amount'], 0);
                $history_type   = strtoupper($transactionrecords[$i]['history_type']);
            } else {
                $site_currency  = $_SESSION['site_settings']['site_currency'];
                $history_amount = MFormatNumber::formatingNumberCurrency($transactionrecords[$i]['history_amount'] * $_SESSION['matrix']['currency_conversion_rate']);
                $history_type   = ucfirst($transactionrecords[$i]['history_type']);
            }
            // print_r($history_type); exit;
            $view = '<a aria-label="link" href="' . $_ENV['FCPATH'] . '/transactionhistory/invoice/'. $transactionrecords[$i]['history_id'] . '">view</a>';
            $output .= '<tr>
            <td>' . $date . '</td>
            <td>' . $transactionrecords[$i]['history_description'] . '</td>
            <td>' . $history_type . '</td>
            <td>' . $site_currency .$history_amount . '</td>
            <td>' . $view . '</td>
            <td>' . $payment_status . '</td>
            </tr>';
            // print_r($output); exit;
        }
        return $output;
        // print_r($output); exit;
    }

    public static function rewardsoverview()
    {
        //   Model\Scheduler\Rank\MRank::rewardsoverview();
        $user_id = $_SESSION['default']['customer_id'];


        $get = $_GET['sub1'];

        //  $get=4;
        // echo"<pre>";print_r($_GET);
        $today = date('y-m-d 00:00:00');
        if ($get == 1) {
            $where = 'AND  history_datetime>="'.$today.'"';
        } elseif ($get == 2) {
            $week = date('y-m-d 00:00:00', strtotime("-7 days"));
            $where = 'AND  history_datetime>="'.$week.'"';
        } elseif ($get == 3) {
            $month = date('y-m-d 00:00:00', strtotime("-30 days"));
            $where = 'AND  history_datetime>="'.$month.'"';
        } elseif ($get == 4) {
            $year = date('y-m-d 00:00:00', strtotime("-365 days"));
            $where = 'AND  history_datetime>="'.$year.'"';
        } else {
            $where = ' ';
        }
        $sql = "SELECT * FROM " . $_ENV['IHOOK_PREFIX'] . "history_table WHERE history_member_id='".$user_id."' AND history_type NOT IN ('withdraw_pending','withdrawal')" .$where;
        //echo $sql ;exit;
        $obj = new Bin_Query();
        $obj->executeQuery($sql);
        $records = $obj->records;
        $sno = 0;
        $output = '';
        if (count((array)$records) > 0) {
            for ($i = 0; $i < count((array)$records); $i++) {
                $history_type   = $records[$i]['history_type'];
                $history_amount   = $records[$i]['history_amount'];
                $sno = $sno + 1;
                $date   = MFormatDate::formatingDate($records[$i]['history_datetime']);
                $output .= '<tr>
         <td>' . $sno . '</td>
         <td>' . $date . '</td>
          <td>' . $history_type . '</td>
          <td>' . $records[$i]['history_description'] . '</td>
         <td>' . $site_currency .$history_amount . '</td>
         </tr>';
            }

        }
        // echo"<pre>";print_r($output);exit;
        return $output;
    }


    public static function topsellers()
    {
        $sql_product = "SELECT  b.meta_value AS product_id, SUM(c.meta_value)/2 AS quantity, a.order_id,a.order_item_name,ROUND(SUM(d.meta_value),0) AS total
      FROM " . $_ENV['STORE_PREFIX'] . "woocommerce_order_items AS a
         LEFT JOIN   " . $_ENV['STORE_PREFIX'] . "woocommerce_order_itemmeta AS b ON  b.meta_key='_product_id' AND b.order_item_id=a.order_item_id
         LEFT JOIN   " . $_ENV['STORE_PREFIX'] . "woocommerce_order_itemmeta AS c ON  c.meta_key='_qty' AND c.order_item_id=b.order_item_id
         LEFT JOIN   " . $_ENV['STORE_PREFIX'] . "woocommerce_order_itemmeta AS d ON  d.meta_key IN('_line_total','_line_tax')
         AND d.order_item_id=c.order_item_id
         WHERE a.order_item_type='line_item'  GROUP BY b.meta_value ORDER BY SUM(c.meta_value) DESC LIMIT 4";
        $obj_product = new Bin_Query();
        $obj_product->executeQuery($sql_product);
        $product = $obj_product->records;
        for ($i = 0; $i < count((array)$product) ; $i++) {
            $key_where = "WHERE sitesettings_name ='woocommerce_key' ";
            $sitesettings = MSiteDetails::getSiteSettingsDetails($key_where);
            $woocommerce_key = $sitesettings[0]['sitesettings_value'];
            $secret_where = "WHERE sitesettings_name ='woocommerce_secret' ";
            $sitesettings = MSiteDetails::getSiteSettingsDetails($secret_where);
            $woocommerce_secret = $sitesettings[0]['sitesettings_value'];
            $key_where = "WHERE sitesettings_name ='woocommerce_path' ";
            $sitesettings = MSiteDetails::getSiteSettingsDetails($key_where);
            $path = $sitesettings[0]['sitesettings_value'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $path.'/wp-json/wc/v3/products/'.trim($product[$i]['product_id']).'?consumer_key='.$woocommerce_key.'&consumer_secret='.$woocommerce_secret);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            $result = curl_exec($ch);
            curl_close($ch);
            $records = json_decode($result);
            // echo"<pre>"; print_r($records); exit;
            if ($records->images[0]->src != '') {
                $productimage = $records->images[0]->src;
            } else {
                $productimage = $_ENV['UI_ASSET_URL']."/assets/img/empty_product.png";
            }
            $price = $records->price;
            $description = $records->description;
            $name = $records->name;

            $output .= '<div class="col-lg-3">
           <div class="product-details text-center">
               <img src="'.$productimage.'" alt="" class="img-fluid w-200px mb-3">
               <div class="product-title  fs-3">
               '.$name.'
               </div>
               <div class="product-price fs-2 text-primary-color fw-bold">
               '.$price.'
               </div>
               <div class="product-description m-h fs-7">
               '.$description.'
               </div>
           </div>
       </div>';

        }
        return $output;
    }

    public static function completedschedule()
    {
        /* $sql="SELECT * FROM ".$_ENV['IHOOK_PREFIX']."events WHERE event_date >= CURDATE() ORDER BY event_date ASC LIMIT 4";
         $obj=new Bin_Query();
         $obj->executeQuery($sql);
         $records=$obj->records;*/


        $members_id = $_SESSION['default']['customer_id'];

        $membersdetails = MMembersDetails::getUserDetails($members_id);
        $matrix_link_where = "members_id=".$members_id;
        $membermatrix = MMatrixMemberLink::getMatrixLinkDetails($matrix_link_where);
        $where .= " OR (a.event_type='private'  AND a.members_type = 1)";
        //Active Users
        if ($membersdetails['members_verified'] == 1 and $membersdetails['members_status'] == 1) {
            $where .= " OR (a.event_type='private' AND a.members_type = 2)";
        }
        //Suspended Users
        if ($membersdetails['members_verified'] == 1 and $membersdetails['members_status'] == 0) {
            $where .= " OR (a.event_type='private' AND a.members_type = 3)";
        }
        //Only Subscribe Users
        if ($membermatrix[0]['members_subscription_plan'] != 0) {
            $where .= " OR (a.event_type='private'  AND a.members_type = 4)";
        }
        //Premium Users
        if ($membermatrix[0]['members_account_status'] != 0) {
            $where .= " OR (a.event_type='private'  AND a.members_type = 5)";
        }
        // Free Users
        if ($membermatrix[0]['members_account_status'] == 0) {
            $where .= " OR (a.event_type='private' AND a.members_type = 6)";
        }
        //Unverified Users
        if ($membersdetails['members_verified'] == 0) {
            $where .= " OR (a.event_type='private'  AND a.members_type = 7)";
        }
        // Unverified Users
        if ($user_type == 7) {
            $sql = 'SELECT members_id,members_email FROM `' . $_ENV['IHOOK_PREFIX'] . 'members_table` WHERE members_verified="0"';
        }

        $id = $_GET['sub1'];
        if ($id == 1) {//upcomming
            $sql = "SELECT a.* FROM " . $_ENV['IHOOK_PREFIX'] . "events AS a LEFT JOIN " . $_ENV['IHOOK_PREFIX'] . "members_table AS b ON b.members_id = a.members_id LEFT JOIN " . $_ENV['IHOOK_PREFIX'] . "matrix_members_link_table AS c ON c.members_id = a.members_id WHERE (FIND_IN_SET('".$members_id."',a.members_list) AND a.event_type='private' AND  date(a.event_date) >= CURDATE()) OR (a.event_type='public' AND  date(a.event_date) >= CURDATE())".$where."   ORDER BY a.event_date ASC LIMIT 4";
        } elseif ($id == 2) { //completed
            $sql = "SELECT a.* FROM " . $_ENV['IHOOK_PREFIX'] . "events AS a LEFT JOIN " . $_ENV['IHOOK_PREFIX'] . "members_table AS b ON b.members_id = a.members_id LEFT JOIN " . $_ENV['IHOOK_PREFIX'] . "matrix_members_link_table AS c ON c.members_id = a.members_id WHERE (FIND_IN_SET('".$members_id."',a.members_list) AND a.event_type='private' AND  date(a.event_date) <= CURDATE()) OR (a.event_type='public' AND  date(a.event_date) <= CURDATE())".$where."   ORDER BY a.event_date ASC LIMIT 4";
        } else { //today
            $sql = "SELECT a.* FROM " . $_ENV['IHOOK_PREFIX'] . "events AS a LEFT JOIN " . $_ENV['IHOOK_PREFIX'] . "members_table AS b ON b.members_id = a.members_id LEFT JOIN " . $_ENV['IHOOK_PREFIX'] . "matrix_members_link_table AS c ON c.members_id = a.members_id WHERE (FIND_IN_SET('".$members_id."',a.members_list) AND a.event_type='private' AND  date(a.event_date) = CURDATE()) OR (a.event_type='public' AND  date(a.event_date) = CURDATE())".$where."   ORDER BY a.event_date ASC LIMIT 4";
        }
        // echo $sql ;exit;
        $obj = new Bin_Query();

        $obj->executeQuery($sql);
        $records = $obj->records;
        //  echo"<pre>";print_r($records);exit;
        $where = "where sitesettings_name='accountmail' AND sitesettings_description='zoom'";
        $sitedetails = MSiteDetails::getSiteSettingsDetails($where);
        $accountmail = $sitedetails[0]['sitesettings_value'];

        $where = "where sitesettings_name='account_id' AND sitesettings_description='zoom'";
        $sitedetails = MSiteDetails::getSiteSettingsDetails($where);
        $account_id = $sitedetails[0]['sitesettings_value'];

        $secretwhere = "where sitesettings_name='clientsecret' AND sitesettings_description='zoom'";
        $sitedetailssecret = MSiteDetails::getSiteSettingsDetails($secretwhere);
        $clientsecret = $sitedetailssecret[0]['sitesettings_value'];

        $secretwhere = "where sitesettings_name='clientid' AND sitesettings_description='zoom'";
        $sitedetailssecret = MSiteDetails::getSiteSettingsDetails($secretwhere);
        $clientid = $sitedetailssecret[0]['sitesettings_value'];


        // Token Creation

        $auth = base64_encode("$clientid:$clientsecret");

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://zoom.us/oauth/token',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'grant_type=account_credentials&account_id='. $account_id,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic ' .$auth
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $decode_response = json_decode($response);
        $authToken = $decode_response->access_token;


        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.zoom.us/v2/users/".$accountmail."/meetings",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
           "Authorization: Bearer ".$authToken
        ),
        ));
        $response1 = curl_exec($curl);
        //  echo"<pre>";print_r($response1);exit;
        curl_close($curl);
        $records1 = json_decode($response1);
        $records1 = $records1->meetings;
        for ($i = 0; $i < count((array)$records1); $i++) {
            //$formatdate = MFormatDate::formatingDate($records1[$i]->start_time);
            $date = date_create($records1[$i]->start_time);
            $formatdate =  date_format($date, "Y-m-d H:i:s");
            $title = 'Zoom Meeting : '.$records1[$i]->topic;
            $records2[] = array(
             'title' => $title,
             'event_date' => $formatdate,
             'start' => $formatdate,
             'id' => $records1[$i]->id,
             'event_type' => 'zoom'
             );
        }
        if (!empty($records)) {
            if (!empty($records1)) {
                $records = array_merge($records, $records2);
            }
        } else {
            $records = $records2;
        }

        for ($i = 0; $i < 4; $i++) {
            if (!empty($records[$i]['event_title'])) {
                $title = $records[$i]['event_title'];
                $content = $records[$i]['event_content'];
                $date = MFormatDate::formatingDate($records[$i]['event_date']);
                $duration = self::getEventsDuration($date);
                $profile = MAmazonCloudFront::getCloudFrontUrl($records[$i]['event_profile']);
                if ($profile == '') {
                    $profile = $_ENV['UI_ASSET_URL'].'/assets/img/no-thumbnail.png';
                }

                $output .= '    <div class="d-flex align-items-center justify-content-between mb-3 border-bottom">
               <div class="lft d-flex flex-column">
                  <img src="'.$profile.'" alt="" class="w-100px img-fluid mb-3">
                  <div class="text-gray fs-6">
                 '. $title.'
                  </div>
                  <div class="event-date fs-2 text-white fw-bold mb-3">
                  '.$date.'
                  </div>
               </div>
            </div>';
            }

        }

        if ($output == '') {
            $output = ' <div class="d-flex align-items-center justify-content-between mb-3 border-bottom">
         <div class="lft d-flex flex-column">
            <div class="text-gray fs-6">
               No Events scheduled
            </div>
            <div class="event-date fs-2 text-white fw-bold mb-3">
               ***
            </div>
         </div>
      </div>';
        }


        return $output;
    }
    public static function getEventsDuration($date)
    {
        $currentdate = date("Y-m-d h:i:sa");

        // Declare and define two dates
        $date1 = strtotime($currentdate);
        $date2 = strtotime($date);
        // Formulate the Difference between two dates
        $diff = abs($date2 - $date1);
        // To get the year divide the resultant date into
        // total seconds in a year (365*60*60*24)
        $years = floor($diff / (365 * 60 * 60 * 24));
        // To get the month, subtract it with years and
        // divide the resultant date into
        // total seconds in a month (30*60*60*24)
        $months = floor(($diff - $years * 365 * 60 * 60 * 24)
                                    / (30 * 60 * 60 * 24));
        // To get the day, subtract it with years and
        // months and divide the resultant date into
        // total seconds in a days (60*60*24)
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 -
                    $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        // To get the hour, subtract it with years,
        // months & seconds and divide the resultant
        // date into total seconds in a hours (60*60)
        $hours = floor(($diff - $years * 365 * 60 * 60 * 24
            - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24)
                                        / (60 * 60));
        // To get the minutes, subtract it with years,
        // months, seconds and hours and divide the
        // resultant date into total seconds i.e. 60
        $minutes = floor(($diff - $years * 365 * 60 * 60 * 24
                - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
                                - $hours * 60 * 60) / 60);
        // To get the minutes, subtract it with years,
        // months, seconds, hours and minutes
        $seconds = floor(($diff - $years * 365 * 60 * 60 * 24
                - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
                        - $hours * 60 * 60 - $minutes * 60));
        if ($years != 0) {
            $yearsval = $years." Years";
        }
        if ($months != 0) {
            $monthsval = $months." Months";
        }
        if ($days != 0) {
            $daysval = $days." Days";
        }
        if ($hours != 0) {
            $hoursval = $hours." Hours";
        }
        if ($minutes != 0) {
            $minutesval = $minutes." Minutes";
        }
        if ($seconds != 0) {
            $secondsval = $seconds." Seconds";
        }

        $returnvalue = $yearsval.' '.$monthsval.' '.$daysval.' '.$hoursval.' '.$minutesval;
        return $returnvalue;

    }

    public static function loginbackurl()
    {
        // $url=$_SERVER['HTTP_REFERER'];
        // echo $url ;exit;
        $url = $_SERVER['REQUEST_URI'];
        $str = ltrim($url, '/user');
        echo $str ;
        exit;
    }

    public static function getresponce()
    {
        if ($json = json_decode(file_get_contents("php://input"), true)) {
            print_r($json);
            $data = $json;
        } else {
            print_r($_POST);
            $data = $_POST;
        }
        $obj1 = new Bin_Query();
        $sql1    = "INSERT INTO promlm_testdata (data)VALUES ('" . $data . "')";
        $obj1->updateQuery($sql1);

        return true;
    }

    public static function squareup()
    {

        header('Content-Type: application/json');
        ob_start();
        $json           = file_get_contents('php://input');

        $sql = "INSERT INTO ". $_ENV['IHOOK_PREFIX']. "stripehook_resp(respo,created_on,flag)VALUES('".$json."',NOW(),'1')";
        $obj = new Bin_Query();
        $obj->updateQuery($sql);
        return true;
    }
}
?>
