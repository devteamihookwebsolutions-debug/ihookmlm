<?php

namespace Admin\App\Models\MatrixConfig;

use Admin\App\Models\Middleware\MMatrixConfiguration;
use Admin\App\Models\Middleware\MPaymentGatewayDetails;
use Illuminate\Support\Facades\Storage;
use Admin\App\Models\Middleware\MMatrixDetails;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Admin\App\Models\Member\MatrixConfiguration;
use Admin\App\Models\Member\MemberLinks;
use Admin\App\Models\Member\Member;
use Admin\App\Models\Member\Matrix;
use Admin\App\Models\Member\Package;
use Admin\App\Models\Member\PaymentHistory;
use Admin\App\Models\Member\History;
use Admin\App\Models\Member\PackageLevelCommission;
use Admin\App\Models\Member\LevelCommission;
use Illuminate\Support\Facades\Auth;
use DateTime;

class MSetMatrixConfiguration
{
    public static function insertMatrixConfiguration(Request $request, $matrix_id)
    {
        $adminId = Session::get('admin_id');
        $createdBy = $adminId ?? 1;

        $input = $request->all();

        $fieldsCount = count($input);

        if ($fieldsCount === 0) {
            session()->flash('error_message', __('No data provided'));
            return redirect(config('app.ADMINPATH') . '/plans');
        }

        // Define keys to exclude from processing
        $excludedKeys = [
            'matrix_id', 'matrix_type_id', 'package_id', 'generalsettings', 'planscaling',
            'entrycriteria', 'commission_settings', 'bonus', 'exit_criteria',
            'totalcycleafterlevelrecords', 'do', 'submit', 'action', 'sub1', 'sub2',
            'onetime_image_hidden', 'members_paid_account_type', 'members_account_type',
            'matrix_status'
        ];

        try {
            foreach ($input as $key => $value) {
                // Skip only if the value is empty or null
                if ((is_string($value) && trim($value) === '') || $value === null) {
                    continue;
                }

                // Rename default_sponsor1 key if present
                if ($key === 'default_sponsor1') {
                    $key = 'default_sponsor';
                }

                // Handle onetime_image upload if present
                if ($key === 'onetime_image') {
                    if ($request->hasFile('onetime_image') && $request->file('onetime_image')->isValid()) {
                        $file = $request->file('onetime_image');
                        $extension = strtolower($file->getClientOriginalExtension());

                        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
                            continue;
                        }

                        $uploadDir = public_path('uploads/plans/ontimeImg');
                        if (!file_exists($uploadDir)) {
                            mkdir($uploadDir, 0755, true);
                        }

                        $fileName = 'onetime_' . time() . '_' . rand(1000, 9999) . '.' . $extension;
                        $file->move($uploadDir, $fileName);

                        $value = 'uploads/plans/ontimeImg/' . $fileName;
                    } else {
                        $value = $request->input('onetime_image_hidden');
                    }
                }

                if ($request->has('members_paid_account_type') && in_array($key, ['registration_fee', 'registration_pv'])) {
                    continue;
                }

                // Save or update matrix configuration
                $config = MatrixConfiguration::where('matrix_id', $matrix_id)
                    ->where('matrix_key', $key)
                    ->first();

                if ($config) {
                    MatrixConfiguration::where('matrix_configuration_id', $config->matrix_configuration_id)
                        ->update(['matrix_value' => $value ?? '']);
                } else {
                    $matrix_config = new MatrixConfiguration();
                    $matrix_config->matrix_key = $key;
                    $matrix_config->matrix_value = $value;
                    $matrix_config->matrix_id = $matrix_id;
                    $matrix_config->created_on = now();
                    $matrix_config->created_by = $createdBy;
                    $matrix_config->save();

                    \Log::info("Created new MatrixConfiguration", ['key' => $key, 'value' => $value]);
                }

                // Handle default_sponsor_name special logic
                if ($key === 'default_sponsor_name') {
                    \Log::info("Processing default_sponsor logic", ['value' => $value]);

                    MemberLinks::where('matrix_id', $matrix_id)->update(['default_sponsor' => 0]);

                    $member = Member::where('members_email', $value . '@gmail.com')
                        ->orWhere('members_username', $value)
                        ->first();

                    if (!$member) {
                        $matrixdetails = MMatrixDetails::getMatrixDetails($matrix_id);
                        $matrix_type_id = $matrixdetails['matrix_type_id'] ?? null;

                        $member = new Member();
                        $member->members_username = $value;
                        $member->members_password = Hash::make($value);
                        $member->members_email = $value . '@gmail.com';
                        $member->members_firstname = $value;
                        $member->members_lastname = $value;
                        $member->members_status = 1;
                        $member->members_verified = 1;
                        $member->members_verify_time = now();
                        $member->members_verification_code = substr(md5(rand(0, 100000)), 0, 5);
                        $member->members_doj = now();
                        $member->members_image = 'uploads/members/avatar.png';
                        $member->members_thumb_image = 'uploads/members/thumb/avatar.png';
                        $member->save();

                        $link = new MemberLinks();
                        $link->members_id = $member->members_id;
                        $link->matrix_id = $matrix_id;
                        $link->direct_id = 1;
                        $link->members_account_status = 1;
                        $link->members_status = 1;
                        $link->matrix_doj = now();
                        $link->members_subscription_status = 1;
                        $link->default_sponsor = 1;
                        $link->root = 0;
                        $link->save();
                    } else {
                        $link = MemberLinks::where('matrix_id', $matrix_id)
                            ->where('members_id', $member->members_id)
                            ->first();

                        if ($link) {
                            MemberLinks::where('link_id', $link->link_id)
                                ->update(['default_sponsor' => 1]);
                        } else {
                            $link = new MemberLinks();
                            $link->members_id = $member->members_id;
                            $link->matrix_id = $matrix_id;
                            $link->direct_id = 1;
                            $link->members_account_status = 1;
                            $link->members_status = 1;
                            $link->matrix_doj = now();
                            $link->members_subscription_status = 1;
                            $link->root = 0;
                            $link->default_sponsor = 1;
                            $link->save();
                        }
                    }
                }
            }

            $paidAccountType = $request->has('members_paid_account_type') ? 1 : 0;

            $paidConfig = MatrixConfiguration::where('matrix_id', $matrix_id)
                ->where('matrix_key', 'members_paid_account_type')
                ->first();
                // dd($paidConfig);

            if ($paidConfig) {
                $paidConfig->update(['matrix_value' => $paidAccountType]);
            } else {
                MatrixConfiguration::create([
                    'matrix_id'       => $matrix_id,
                    'matrix_key'      => 'members_paid_account_type',
                    'matrix_value'    => $paidAccountType,
                    'created_on'      => now(),
                    'created_by'      => $createdBy,
                ]);
            }
                $toggleFields = ['register_status', 'active_status', 'matrix_status','registration','register_fee_status','joining_commission_status',
                'joining_commission_type','instantbinary_commission_status','instantbinary_commission_type','dailybinary_commission_status',
                 'dailybinary_commission_type','weeklybinary_commission_status','monthlybinary_commission_status',
                'monthlybinary_commission_type','direct_referrel_commission_type','direct_referrel_commission_status',
                'level_commisison_status'];

                foreach ($toggleFields as $field) {
                    $value = $request->input($field, 0);

                    MatrixConfiguration::updateOrCreate(
                        [
                            'matrix_id'  => $matrix_id,
                            'matrix_key' => $field
                        ],
                        [
                            'matrix_value' => $value,
                            'created_by'   => $createdBy,
                            'created_on'   => now()
                        ]
                    );
                }


            $defaultSponsorConfig = MatrixConfiguration::where('matrix_id', $matrix_id)
                ->where('matrix_key', 'default_sponsor')
                ->first();

            if ($defaultSponsorConfig) {
                $id = $defaultSponsorConfig->matrix_configuration_id;
                MatrixConfiguration::where('matrix_configuration_id', $id)->update(['matrix_value' => $member->members_id]);
            } else {
                $config = new MatrixConfiguration();
                $config->matrix_id = $matrix_id;
                $config->matrix_key = 'default_sponsor';
                $config->matrix_value = $member->members_id;
                $config->save();
            }

            if (empty($request->post('members_paid_account_type')) && trim($request->post('members_account_type')) != '3') {
                Package::where('matrix_id', $matrix_id)->delete();
                PackageLevelCommission::where('matrix_id', $matrix_id)->delete();
            }

            if ($request->has('members_paid_account_type')) {
                LevelCommission::where('matrix_id', $matrix_id)->delete();
            }

            return redirect(config('app.ADMINPATH') . '/plans')->with('success', 'Plan configuration has been updated successfully');
        } catch (Exception $e) {
            \Log::error("Error in insertMatrixConfiguration", ['error' => $e->getMessage()]);
            session()->flash('error_message', __('An error occurred while updating the plan configuration.'));
            return redirect(config('app.ADMINPATH') . '/plans');
        }
    }
}
