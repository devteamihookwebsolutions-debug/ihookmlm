<?php

namespace User\App\Http\Controllers\Network;

use Admin\App\Model\Middleware\MCryptoGraphy;
use Admin\App\Models\Middleware\MMatrixDetails;
use Admin\App\Models\Middleware\MMatrixMemberLink;
use Admin\App\Models\Middleware\MPaymentGatewayDetails;
use Admin\App\Models\Middleware\MURLCrypt;
use Admin\App\Model\Genealogy\MBinaryCollapseGenealogy;
use Admin\App\Model\Genealogy\MCollapseGenealogy;
use User\App\Models\Network\MCardDetails;
use User\App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CardDetailsControlller extends Controller
{
    public function showCardDetails()
    {
        try {
            session()->forget('recruit');
            session()->forget('network');
            session()->forget('package');
            session()->forget('register');
            $output['carddetails'] = MCardDetails::getStripeCartDetails();

            $where       = "members_id = " . session('default.customer_id');
            $striptsubid = MMatrixMemberLink::getPartMatrixLinkDetails('stripe_subid', $where);
            if (count($striptsubid) > 1) {
                foreach ($striptsubid as $key => $value) {
                    if ($value['stripe_subid'] != '') {
                        $stript_subid = $value['stripe_subid'];
                    }
                }
            } else {
                $stript_subid = $striptsubid[0]['stripe_subid'];
            }

            $output['striptsubid'] = $stript_subid;

            return view('network/showcarddetails', $output);
            session()->forget('success_message');
            session()->forget('error_message');
        } catch (\Exception $e) {
            session()->put('error_message', $e->getMessage());
            return redirect(env('FCPATH') . "/mycard");
        }
    }

    public function addCardDetails()
    {
        try {
            $where       = "members_id = " . session('default.customer_id');
            $striptsubid = MMatrixMemberLink::getMatrixLinkDetails($where);

            if (count($striptsubid) > 1) {
                foreach ($striptsubid as $key => $value) {
                    if ($value['stripe_subid'] != '' && $value['members_subscription_status'] != '2') {
                        $stript_subid = $value['stripe_subid'];
                    }
                }
            } elseif ($striptsubid[0]['members_subscription_status'] != '2') {
                $stript_subid = $striptsubid[0]['stripe_subid'];
            }

            $output['striptsubid'] = $stript_subid;
            $where                 = 'WHERE paymentsettings_default_name="stripe"';
            $stripedetails         = MPaymentGatewayDetails::getPaymentGatewayDetails($where);
            $publickey             = $stripedetails['paymentsettings_accname'];
            $output['publickey']   =MCryptoGraphy::decryptionData($publickey);

            return view('network/addcarddetails', $output);
            session()->forget('success_message');
            session()->forget('error_message');
        } catch (\Exception $e) {
            session()->put('error_message', $e->getMessage());
            return redirect(env('FCPATH') . "/mycard");
        }
    }

    /**
     * This public function is used to show update user car details
     * @return HTML data
     */
    public function updateCardDetails()
    {
        try {
            MCardDetails::updateCardDetails();
        } catch (\Exception $e) {
            session()->put('error_message', $e->getMessage());
            return redirect(env('FCPATH') . "/mycard");
        }
    }

    /**
     * This public function is used to show subscriptionlist
     * @return HTML data
     */
    public function showActiveSubscription()
    {
        try {
            $output['activesubscription'] = MCardDetails::showActiveSubscription();

            return view('network/activesubscription', $output);
            session()->forget('success_message');
            session()->forget('error_message');
        } catch (\Exception $e) {
            session()->put('error_message', $e->getMessage());
            return redirect(env('FCPATH') . "/activesubscription");
        }
    }

    /**
     * This public function is used to delete subscriptionlist
     * @return HTML data
     */
    public function cancelSubScription()
    {
        try {
            MCardDetails::cancelSubScription();
        } catch (\Exception $e) {
            session()->put('error_message', $e->getMessage());
            return redirect(env('FCPATH') . "/mycard");
        }
    }

    public function deleteCardDetails()
    {
        try {
            MCardDetails::deleteCardDetails();
        } catch (\Exception $e) {
            session()->put('error_message', $e->getMessage());
            return redirect(env('FCPATH') . "/mycard");
        }
    }
}
