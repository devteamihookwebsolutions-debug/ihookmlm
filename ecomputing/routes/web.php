<?php

use Ecomputing\App\Http\Controllers\Wordpress\ConnectMLMController;
use Ecomputing\App\Http\Controllers\Wordpress\CountryListController;
use Ecomputing\App\Http\Controllers\Wordpress\DiscountGroupController;
use Ecomputing\App\Http\Controllers\Wordpress\EwalletGatewayController;
use Ecomputing\App\Http\Controllers\Wordpress\FindSponsorController;
use Ecomputing\App\Http\Controllers\Wordpress\GenerationBonusController;
use Ecomputing\App\Http\Controllers\Wordpress\PartyPlanController;
use Ecomputing\App\Http\Controllers\Wordpress\PointValueController;
use Ecomputing\App\Http\Controllers\Wordpress\ProductLevelCommissionController;
use Ecomputing\App\Http\Controllers\Wordpress\RegisterController;
use Ecomputing\App\Http\Controllers\Wordpress\RetailBonusController;
use Ecomputing\App\Http\Controllers\Wordpress\StateListController;
use Illuminate\Support\Facades\Route;

// All routes under the prefix 'ecomputing'
Route::prefix('ecomputing')->group(function () {

    // ---------------------- Ewallet ----------------------
    Route::get('checkwalletbalance', [EwalletGatewayController::class, 'checkWalletBalance']);

    // ---------------------- PV --------------------------
    Route::get('sendpv', [PointValueController::class, 'sendProductPV']);
    Route::get('getpv', [PointValueController::class, 'getProductPV']);

    // ---------------------- Product Level Commission ---
    Route::get('sendproductlevelcommission', [ProductLevelCommissionController::class, 'sendProductLevelCommission']);

    // ---------------------- Discount Group -------------
    Route::get('checkgroupuser', [DiscountGroupController::class, 'checkDiscountGroupUser']);
    Route::get('getgroup', [DiscountGroupController::class, 'getDiscountGroup']);

    // ---------------------- Generation Bonus -----------
    Route::get('sendgenerationbonus', [GenerationBonusController::class, 'sendGenerationBonus']);

    // ---------------------- Retail Bonus ---------------
    Route::get('getusertype', [RetailBonusController::class, 'getUserType']);
    Route::get('getretailbonus', [RetailBonusController::class, 'getRetailBonus']);

    // ---------------------- Register -------------------
    Route::get('wpregister', [RegisterController::class, 'showRegister']);

    // ---------------------- Country List ---------------
    Route::get('getcountryforwp', [CountryListController::class, 'getCountryDetails']);

    // ---------------------- State List -----------------
    Route::get('getstatelistforwp', [StateListController::class, 'getStateList']);

    // ---------------------- Find Sponsor --------------
    Route::get('getsposnors', [FindSponsorController::class, 'getSponsorDetails']);
    Route::get('getdistribtr', [FindSponsorController::class, 'getDistributors']);
    Route::get('getdistribtrbyzip', [FindSponsorController::class, 'getDistributorsByZip']);
    Route::get('getmemname', [FindSponsorController::class, 'getMembersName']);
    Route::get('getdistribtrspnsr', [FindSponsorController::class, 'getDistribtrSponsor']);

    // ---------------------- Party Plan -----------------
    Route::get('getidbypartyid', [PartyPlanController::class, 'getPartyPlanDetails']);

    // ---------------------- Connect MLM ----------------
    Route::get('wptable', [InstallConnectMLMController::class, 'wpTable']);
    Route::get('wporders', [ConnectMLMController::class, 'wpGetOrders']);
    Route::get('wpproduct', [ConnectMLMController::class, 'wpGetProduct']);
    Route::get('wpuser', [ConnectMLMController::class, 'wpGetUser']);
    Route::post('wpuserupdate', [ConnectMLMController::class, 'wpUserUpdate']);
    Route::post('wptrashpost', [ConnectMLMController::class, 'wpTrashPost']);
    Route::post('wpproductaddupdate', [ConnectMLMController::class, 'wpProductAddUpdate']);
    Route::post('wprefundorders', [ConnectMLMController::class, 'wpRefundOrders']);
    Route::post('wpmlmorder', [ConnectMLMController::class, 'wpUpdateOrderVolume']);

    // ---------------------- Shopify Hooks ----------------
    Route::post('symlmcreateuser', [ConnectMLMController::class, 'syUserInsert']);
    Route::post('symlmupdateuser', [ConnectMLMController::class, 'syUserUpdate']);
    Route::post('symlmcreateorder', [ConnectMLMController::class, 'syOrderInsert']);
    Route::post('symlmcreateproduct', [ConnectMLMController::class, 'syProductInsert']);
    Route::post('symlmorderfulfillment', [ConnectMLMController::class, 'syOrderFulfillment']);
    Route::post('symlmupdateorder', [ConnectMLMController::class, 'syOrderUpdate']);
    Route::post('symlmupdateproduct', [ConnectMLMController::class, 'syProductUpdate']);
    Route::post('symlmdeleteproduct', [ConnectMLMController::class, 'syProductDelete']);
    Route::post('symlmordercancel', [ConnectMLMController::class, 'syOrderCancel']);

    // ---------------------- Lead Pages -----------------
    Route::get('leadspagelink', [LeadPagesController::class, 'getLeadPageLink']);
    Route::get('partyleadspagelink', [LeadPagesController::class, 'getPartyLeadPageLink']);

    // ---------------------- Email Tracking ------------
    Route::get('email', [EmailTrackingController::class, 'updateEmailStatus']);

    // ---------------------- Promotional Banner ---------
    Route::get('getbannerpath', [BannerController::class, 'getBannerPath']);

    // ---------------------- Referral Tracking ----------
    Route::get('referraltrack', [ReferralTrackingController::class, 'getReferralTracking']);
    Route::get('tracktest', [TrackController::class, 'trackTest']);

    // ---------------------- Referral Header Banner ----
    Route::get('referralheader', [ReferralHeaderBannerController::class, 'getReferralHeader']);

});
