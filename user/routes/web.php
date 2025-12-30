<?php

use Admin\App\Http\Controllers\Rank\RankController;
use User\App\Http\Controllers\AuthorizeNet\AuthorizeNetController;
use User\App\Http\Controllers\Paypal\PayPalController;
use User\App\Http\Controllers\Autologin\MemberAutoLoginController;
use User\App\Http\Controllers\Epin\EpinHistoryController;
use User\App\Http\Controllers\Epin\GenerateEpinController;
use User\App\Http\Controllers\Network\CardDetailsControlller;
use User\App\Http\Controllers\Package\PackageController;
use User\App\Http\Controllers\Profile\ProfileController;
use User\App\Http\Controllers\Register\RegisterController;
use User\App\Http\Controllers\Genealogy\CollapseGenealogyController;
use User\App\Http\Controllers\Genealogy\GenealogyController;
use User\App\Http\Controllers\Genealogy\GenealogySidebarController;
use User\App\Http\Controllers\Genealogy\GraphicalGenealogyController;
use User\App\Http\Controllers\Genealogy\TabularGenealogyController;
use User\App\Http\Controllers\Reports\CashwalletHistoryController;
use User\App\Http\Controllers\Reports\DownlineLevelSalesCotroller;
use User\App\Http\Controllers\Reports\EwalletHistoryController;
use User\App\Http\Controllers\Reports\PackageHistoryController;
use User\App\Http\Controllers\Reports\PVDetailsController;
use User\App\Http\Controllers\Reports\TransactionHistoryController;
use User\App\Http\Controllers\Reports\WithdrawalHistoryController;
use User\App\Http\Controllers\Stripe\StripeController;
use User\App\Http\Controllers\UserDashboard\UserDashboardController;
use User\App\Http\Controllers\Network\NetworkController;
use User\App\Http\Controllers\Network\MatrixMoreInfoController;
use User\App\Http\Controllers\Network\DownlineLevelController;
use User\App\Http\Controllers\Network\WaitingRoomController;

use Illuminate\Support\Facades\Route;

Route::prefix('user')->name('user.')->group(function () {

    // Public routes (no login required)
    Route::get('login', [RegisterController::class, 'index'])->name('login');
    Route::post('post_login', [RegisterController::class, 'postLogin'])->name('login.post');
    Route::get('registration', [RegisterController::class, 'registration'])->name('registration');
    Route::post('post_registration', [RegisterController::class, 'postRegistration'])->name('register.post');
    Route::post('registration/email_already_exists', [RegisterController::class, 'checkEmail'])->name('email.check');
    Route::post('registration/username_already_exists', [RegisterController::class, 'checkUsername'])->name('username.check');
    Route::post('registration/fetch_states', [RegisterController::class, 'fetchState'])->name('fetchState');
    Route::post('registration/get_states/{id}', [RegisterController::class, 'getState'])->name('getState');
    Route::post('registration/setSponsorDetails', [RegisterController::class, 'setSponsorDetails'])->name('setSponsorDetails');

    Route::get('thankyou', [RegisterController::class, 'thankyou'])->name('thankyou');
    Route::get('dashboard', [RegisterController::class, 'dashboard'])->name('dashboard');
    Route::match(['get', 'post'], 'logout', [RegisterController::class, 'logout'])->name('logout');
    Route::post('package', [PackageController::class, 'packageDetails'])->name('package');
    Route::post('/verify-epin', [RegisterController::class, 'verifyEpin'])->name('verifyEpin');
    // Auto login
    Route::post('autologin/opt', [MemberAutoLoginController::class, 'generateToken'])->name('autologin.token');
    Route::get('autologin/auto/{token}/{member_id}', [MemberAutoLoginController::class, 'autoLogin'])->name('autologin.auto');
    // user profile routes
    Route::get('/profile/myprofile', [ProfileController::class, 'show']);
    Route::post('/profile/personal', [ProfileController::class, 'updatePersonal']);
    Route::post('/profile/contact', [ProfileController::class, 'updateContact']);
    Route::post('/profile/password', [ProfileController::class, 'updatePassword']);
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar']);
    Route::post('/profile/2fa', [ProfileController::class, 'toggle2FA']);
    Route::post('/profile/check-transaction-password', [ProfileController::class, 'checkTransactionPassword']);
    Route::post('/transaction-password', [ProfileController::class, 'updateTransactionPassword'])
          ->name('profile.update.transaction.password');

    // Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/gettotalcommisions', [UserDashboardController::class, 'getTotalCommissions'])->name('dashboard.gettotalcommisions');
    Route::get('/dashboard/getordersdetails', [UserDashboardController::class, 'getOrdersDetails'])->name('dashboard.getordersdetails');
    Route::get('/dashboard/getpackagepurchased', [UserDashboardController::class, 'getPackagePurchased'])->name('dashboard.getpackagepurchased');
    Route::get('/dashboard/getdirectdownlinesdetails', [UserDashboardController::class, 'getDirectDownlinesDetails'])->name('dashboard.getdirectdownlinesdetails');
    Route::get('/dashboard/get-rank-from-link-table', [UserDashboardController::class, 'getMemberRankFromLinkTable'])->name('dashboard.get-rank-from-link-table');
    Route::get('/dashboard/dashboard_block2', [UserDashboardController::class, 'getBlock2'])->name('dashboard.block2');
    Route::get('/dashboard/dashboard_block3', [UserDashboardController::class, 'getBlock3'])->name('dashboard.block3');
    Route::get('/dashboard/getwalletamountdetails', [UserDashboardController::class, 'getWalletAmountDetails'])->name('dashboard.getwalletamountdetails');
    Route::get('/dashboard/getpvstatsdetails', [UserDashboardController::class, 'getPvStatsDetails'])->name('dashboard.getpvstatsdetails');
    Route::get('/dashboard/getactivememberstatsdetails', [UserDashboardController::class, 'getActiveMemberStatsDetails'])->name('dashboard.getactivememberstatsdetails');
    Route::get('/dashboard/getorderstats', [UserDashboardController::class, 'getOrderStats'])->name('dashboard.getorderstats');
    Route::get('/dashboard/getgpvstatsdetails', [UserDashboardController::class, 'getGpvStatsDetails'])->name('dashboard.getgpvstatsdetails');
    Route::get('/dashboard/getpaidaccountstatsdetails', [UserDashboardController::class, 'getPaidAccountStatsDetails'])->name('dashboard.getpaidaccountstatsdetails');
    Route::get('/dashboard/activities', [UserDashboardController::class, 'getActivities'])->name('dashboard.activities');
    Route::get('/dashboard/get-overview-data', [UserDashboardController::class, 'getOverviewData'])->name('dashboard.get-overview-data');
    Route::get('/dashboard/get-rank-details-requirements/{rankId}', [UserDashboardController::class, 'getRankDetailsRequirements'])->name('dashboard.get-rank-details-requirements');
    Route::get('/dashboard/get-rank-percentage', [UserDashboardController::class, 'getRankPercentage'])->name('dashboard.get-rank-percentage');

    Route::get('/genealogy/viewtree/{encrypted}', [GenealogyController::class, 'viewGenealogyTree'])
        ->name('genealogy.viewtree');

    // THESE TWO MUST BE UNDER /user PREFIX
    Route::post('/genealogy/getmembers', [GenealogyController::class, 'getMembers'])
        ->name('genealogy.getmembers');

    Route::post('/genealogy/search/{encrypted}', [GenealogyController::class, 'searchMember'])
        ->name('genealogy.search');

    Route::get('/genealogy/tabularview/{encrypted}', [TabularGenealogyController::class, 'view'])
        ->name('genealogy.tabularview');

    Route::get('/genealogy/gettabularview/{encrypted}', [TabularGenealogyController::class, 'getTabularGenealogyDetails'])
        ->name('genealogy.gettabularview');

    Route::get('/grpgenealogy/viewtree/{encrypted}', [GraphicalGenealogyController::class, 'viewTree'])
        ->name('grpgenealogy.viewtree');

    Route::get('/countgenealogy/viewtree/{encrypted}', [GraphicalGenealogyController::class, 'viewTree'])
        ->name('countgenealogy.viewtree');

    Route::get('/rankgenealogy/viewtree/{encrypted}', [GraphicalGenealogyController::class, 'viewTree'])
        ->name('rankgenealogy.viewtree');

    Route::get('/directdownlinegenealogy/viewtree/{encrypted}', [GraphicalGenealogyController::class, 'viewTree'])
        ->name('directdownlinegenealogy.viewtree');

    Route::get('/advancedgenealogy/viewtree/{encrypted}', [GraphicalGenealogyController::class, 'viewTree'])
         ->name('advancedgenealogy.viewtree');

    // Update template route
    Route::post('/grpgenealogy/updatetemplate', [GraphicalGenealogyController::class, 'updateTemplate'])
        ->name('grpgenealogy.updatetemplate');

    Route::get('/collapsegenealogy/viewtree/{encrypted}', [CollapseGenealogyController::class, 'viewTree'])
        ->name('collapsegenealogy.viewtree');

    Route::get('/genealogy/sidebar', [GenealogySidebarController::class, 'sidebar'])
        ->name('genealogy.sidebar');

    // Card Details
    Route::get('/mycard', [CardDetailsControlller::class, 'showCardDetails'])->name('mycard');
    Route::get('/addcard', [CardDetailsControlller::class, 'addCardDetails'])->name('addcard');
    Route::post('/updatecard', [CardDetailsControlller::class, 'updateCardDetails'])->name('updatecard');
    Route::get('/activesubscription', [CardDetailsControlller::class, 'showActiveSubscription'])->name('activesubscription');
    Route::get('/cancelsubscription/{sub1?}', [CardDetailsControlller::class, 'cancelSubScription'])->name('cancelsubscription');
    Route::get('/deletecard', [CardDetailsControlller::class, 'deleteCardDetails'])->name('deletecard');

    Route::get('/network/view/{token?}/{member_id?}/{matrix_id?}', [NetworkController::class, 'showNetwork'])
        ->name('network.view');

    Route::post('/matrixmoreinfo', [MatrixMoreInfoController::class, 'showMatrixMoreInformation'])->name('matrixmoreinfo');

    // Downline Level
    Route::get('/network/level/{matrix_id}/{level}', [DownlineLevelController::class, 'getDownlineLevel'])
        ->name('network.level');

    // Waiting Room
    Route::get('/waitingroom', [WaitingRoomController::class, 'showWaitingList'])->name('waitingroom');
    Route::get('/waitingposition', [WaitingRoomController::class, 'showWaitingPosition'])->name('waitingposition');
    Route::get('/getmemberlist/{sub1?}/{sub2?}', [WaitingRoomController::class, 'getMemberList'])->name('getmemberlist');
    Route::post('/waitinglistaction', [WaitingRoomController::class, 'waitingListAction'])->name('waitinglistaction');

    Route::prefix('epinrequest')->name('epinrequest.')->group(function () {

            Route::get('/create', [GenerateEpinController::class, 'showRequestEpin'])
                ->name('create');

            Route::post('/store', [GenerateEpinController::class, 'storeRequestEpin'])
                ->name('store');

            Route::post('/validatecreate', [GenerateEpinController::class, 'validateCreateRequestEpin'])
                ->name('validatecreate');

            Route::get('/getmatrixamount/{id}', [GenerateEpinController::class, 'getMatrixAmount'])
                ->name('get-matrix-amount');
    });


        Route::prefix('epin')->name('epin.')->group(function () {
            Route::get('/history', [EpinHistoryController::class, 'showEpinHistory'])
                ->name('history');

            Route::get('/getpackageamount/{packageId}/{typeId}', [GenerateEpinController::class, 'getPackageAmount'])
                ->name('getpackageamount');

        });
            //Reports
        Route::get('ewallethistory', [EwalletHistoryController::class, 'ewalletHistory'])
                ->name('ewallet.history');


        Route::post('ewallethistory', [EwalletHistoryController::class, 'ewalletHistory'])
            ->name('ewallet.history.filter');

            //cashwallet
        Route::get('cwallethistory', [CashwalletHistoryController::class, 'cashWalletHistory'])
                ->name('cwallet.history');

        Route::post('cwallethistory', [CashwalletHistoryController::class, 'cashWalletHistory'])
            ->name('cwallet.history.filter');

        Route::get('leadcontact', [CashwalletHistoryController::class, 'leadContact'])
                ->name('leadcontact.history');
            //withdrawalhistory
        Route::get('withdrawalhistory', [WithdrawalHistoryController::class, 'withdrawalhistory'])
                ->name('withdrawal.history');

        Route::post('withdrawalhistory', [WithdrawalHistoryController::class, 'withdrawalhistory'])
            ->name('withdrawal.history.filter');

      //Transtractional history
        Route::get('transtractionalhistory', [TransactionHistoryController::class, 'showTransactionHistory'])
            ->name('transtractional.history');

        Route::post('transtractionalhistory', [TransactionHistoryController::class, 'showTransactionHistory'])
        ->name('transtractional.history.filter');

        Route::get('commission-invoice', [TransactionHistoryController::class, 'viewCommissionInvoice'])->name('commission.invoice');

        //PV History details
        Route::get('pvhistory', [PVDetailsController::class, 'showPVDetails'])
            ->name('pvhistory.history');

        // Route::get('getGPVHistory', [PVDetailsController::class, 'getGPVHistory'])
        //     ->name('getGPVHistory');

    Route::post('pvhistory', [PVDetailsController::class, 'showPVDetails'])
        ->name('pvhistory.history.filter');
    //packagehistory

    Route::get('packagehistory', [PackageHistoryController::class, 'showPackageHistory'])
        ->name('packagehistory');

    Route::post('packagehistory', [PackageHistoryController::class, 'showPackageHistory'])
        ->name('package.history.filter');

        //invoice
    Route::get('package/invoice/{id}', [PackageHistoryController::class, 'viewPackageInvoice']
        )->name('package.invoice');

    //downlinesales report
    Route::get('downlinesales', [DownlineLevelSalesCotroller::class, 'showDownlineSalesReport'])
        ->name('downlinesaleshistory');
    Route::post('downlinesales', [DownlineLevelSalesCotroller::class, 'showDownlineSalesReport'])
        ->name('downlinesales.filter');
    // PayPal Routes
    Route::get('/paypal/pay', [PayPalController::class, 'pay'])->name('paypal.pay');
    Route::post('/paypal/pay', [PayPalController::class, 'pay']);
    Route::get('/paypal/success', [PayPalController::class, 'success'])->name('paypal.success');
    Route::get('/paypal/error', [PayPalController::class, 'error'])->name('paypal.error');

    // Stripe Routes
    Route::post('/stripe/pay', [StripeController::class, 'pay'])->name('stripe.pay');
    Route::get('/stripe/success', [StripeController::class, 'success'])->name('stripe.success');
    Route::get('/stripe/cancel', [StripeController::class, 'cancel'])->name('stripe.cancel');

    Route::post('/authorizenet/pay', [AuthorizeNetController::class, 'pay'])->name('authorizenet.pay');

    // Optional: Cancel subscription routes (for logged-in users)
    Route::post('/authorizenet/cancel-subscription', [AuthorizeNetController::class, 'cancelSubscription'])
        ->name('authorizenet.cancel')
        ->middleware('auth');

    Route::post('/stripe/cancel-subscription', [StripeController::class, 'cancelSubscription'])
        ->name('stripe.cancel.subscription')
        ->middleware('auth');

    // user profile update routes
    Route::post('/epinrequest/verify-transaction-password', [GenerateEpinController::class, 'verifyTransactionPassword'])
        ->name('epinrequest.verify-transaction-password');

    Route::post('/setrank', [RankController::class, 'updateMembersRank'])->name('setrank');
    Route::get('/rank/createpdf', [RankController::class, 'createpdf']);
    Route::get('/rank/binresponse', [RankController::class, 'binresponse']);
    Route::get('/rank/transaction1', [RankController::class, 'transaction1']);
    Route::get('/rank/rewardsoverview1', [RankController::class, 'rewardsoverview1']);
    Route::get('/rank/rewardsoverview', [RankController::class, 'rewardsoverview']);
    Route::get('/rank/topsellers', [RankController::class, 'topsellers']);
    Route::get('/rank/completedschedule', [RankController::class, 'completedschedule']);
    Route::get('/rank/loginbackurl', [RankController::class, 'loginbackurl']);
    Route::get('/rank/getresponce', [RankController::class, 'getresponce']);
    Route::get('/rank/squareup', [RankController::class, 'squareup']);

});


