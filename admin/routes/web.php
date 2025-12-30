<?php

use Admin\App\Http\Controllers\Bonus\BonusController;
use Admin\App\Http\Controllers\Bonus\MatchingBonusController;
use Admin\App\Http\Controllers\CustomerBonus\CustomerBonusController;
use Admin\App\Http\Controllers\Epin\EpinManagementController;
use Admin\App\Http\Controllers\Epin\SendEpinsController;
use Admin\App\Http\Controllers\Ewallet\EwalletGatewaySettingsController;
use Admin\App\Http\Controllers\Factories\BannerSettingsController;
use Admin\App\Http\Controllers\Factories\PaymentSettingsController;
use Admin\App\Http\Controllers\Factories\RegisterSettingsController;
use Admin\App\Http\Controllers\Genealogy\CollapseGenealogyController;
use Admin\App\Http\Controllers\Genealogy\GenealogyController;
use Admin\App\Http\Controllers\Genealogy\GraphicalGenealogyController;
use Admin\App\Http\Controllers\Genealogy\GraphicalGenealogyTemplateController;
use Admin\App\Http\Controllers\LeadPage\LeadContactsController;
use Admin\App\Http\Controllers\Logs\LogManagementController;
use Admin\App\Http\Controllers\Masters\CityController;
use Admin\App\Http\Controllers\Masters\CountryMasterController;
use Admin\App\Http\Controllers\Masters\StateController;
use Admin\App\Http\Controllers\AuthController;
use Admin\App\Http\Controllers\MatrixConfig\LevelCommissionController;
use Admin\App\Http\Controllers\MatrixConfig\MatrixConfigurationController;
use Admin\App\Http\Controllers\MatrixConfig\MatrixController;
use Admin\App\Http\Controllers\MatrixConfig\MatrixPackageController;
use Admin\App\Http\Controllers\MatrixConfig\PackageLevelCommissionController;
use Admin\App\Http\Controllers\MemberArea\MemberAreaSummaryController;
use Admin\App\Http\Controllers\PremiumLearning\PremiumCoursePaymentController;
use Admin\App\Http\Controllers\PremiumLearning\PremiumCoursesController;
use Admin\App\Http\Controllers\PremiumLearning\PremiumLearningLessonController;
use Admin\App\Http\Controllers\PremiumLearning\PremiumLearningLessonUpdateController;
use Admin\App\Http\Controllers\RoleManagement\RoleManagementController;
use Admin\App\Http\Controllers\SystemModule\SystemManagementController;
use Admin\App\Http\Controllers\MemberArea\TransactionController;
use Admin\App\Http\Controllers\MemberArea\WalletController;
use Admin\App\Http\Controllers\Settings\SiteSettingsController;
use Admin\App\Http\Controllers\Bonus\GenerationBonusController;
use Admin\App\Http\Controllers\Reports\CommissionReportsController;
use Admin\App\Http\Controllers\Reports\UserCommissionController;
use Admin\App\Http\Controllers\Reports\PVReportsController;
use Admin\App\Http\Controllers\Reports\GPVReportsController;
use Admin\App\Http\Controllers\Reports\RankReportController;
use Admin\App\Http\Controllers\Reports\AdminEarningReportsController;
use Admin\App\Http\Controllers\Reports\BonusAchievedController;
use Admin\App\Http\Controllers\Reports\PackageReportsController;
use Admin\App\Http\Controllers\Ewallet\EwalletPaymentsController;
use Admin\App\Http\Controllers\Funds\CFundTransferController;
use Admin\App\Http\Controllers\Bonus\SendBonusController;
use Admin\App\Http\Controllers\Funds\CDeductFundsController;
use Admin\App\Http\Controllers\Terminology\TerminologyController;
use Admin\App\Http\Controllers\UserManager\DistributesInsertUserController;
use Admin\App\Http\Controllers\Withdrawal\PayoutsController;
use Illuminate\Support\Facades\Route;
use Admin\App\Http\Controllers\Rank\RankController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Admin\App\Http\Controllers\Genealogy\TabularGenealogyController;
use Admin\App\Http\Controllers\Factories\UserDashboardController;
use Admin\App\Http\Controllers\Features\FeaturesController;

// Reusable auth check (Closure)
$middleware = function ($request, $next) {
    if (!Session::has('admin_id')) {
        return redirect()->route('admin.login');
    }
    return $next($request);
};

// PUBLIC: Login (no protection)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('post_login', [AuthController::class, 'postLogin'])->name('login.post');
});

// PROTECTED: All Admin Routes
Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

        // Distributors
        // Route::match(['get', 'post'], 'userManager', [DistributesInsertUserController::class, 'index'])->name('distributors.index');
        // Route::get('userManager', [DistributesInsertUserController::class, 'index'])
        //     ->name('distributors.index');

        //   Route::post('userManager/fetch', [DistributesInsertUserController::class, 'fetch']);
        Route::get('userManager', [DistributesInsertUserController::class, 'index'])->name('distributors.index');
        Route::post('userManager/fetch', [DistributesInsertUserController::class, 'fetch']);

        Route::get('userManager/addUser', [DistributesInsertUserController::class, 'adddistrbutors'])->name('adddistributors');
        Route::post('adddistributors/email_already_exists', [DistributesInsertUserController::class, 'checkEmail'])->name('emailcheck');
        Route::post('adddistributors/username_already_exists', [DistributesInsertUserController::class, 'checkUsername'])->name('checkUsername');
        Route::post('adddistributors/fetchState', [DistributesInsertUserController::class, 'fetchState'])->name('fetchState');
        Route::post('userManager/adduser', [DistributesInsertUserController::class, 'insertUser'])->name('addUser.create');

        // Reports
        Route::get('commission', [CommissionReportsController::class, 'index'])->name('commissionreports');
        Route::get('getCommissionData', [CommissionReportsController::class, 'getCommissionData'])->name('getCommissionData');
        Route::get('usercommission', [UserCommissionController::class, 'userCommissionReports'])->name('usercommissionreports');
        Route::get('getUserCommissionData', [UserCommissionController::class, 'getUserCommissionReports'])->name('getUserCommissionData');
        Route::get('cpvreport', [PVReportsController::class, 'showPVReports'])->name('cpvreport');
        Route::get('cpvreportData', [PVReportsController::class, 'getPVReports'])->name('cpvreportData');
        Route::get('gpvreports', [GPVReportsController::class, 'showGPVReports'])->name('gpvreports');
        Route::get('gpvreportData', [GPVReportsController::class, 'getGPVReports'])->name('gpvreportData');
        Route::get('rankreports', [RankReportController::class, 'rankbonus'])->name('rankreports');
        Route::get('rankreportsData', [RankReportController::class, 'getRankBonus'])->name('getRankBonusData');
        Route::get('bonus', [BonusAchievedController::class, 'bonusAchieved'])->name('bonusachievedreports');
        Route::get('getBonusData', [BonusAchievedController::class, 'getBonusAchieved'])->name('getBonusData');
        Route::get('packagereports', [PackageReportsController::class, 'showPackageReports'])->name('packagereports');
        Route::get('PackagegetData', [PackageReportsController::class, 'getPackageReports'])->name('PackagegetData');
        Route::get('adminEarnings', [AdminEarningReportsController::class, 'adminEarnings'])->name('adminearnings');
        Route::get('adminEarningsData', [AdminEarningReportsController::class, 'adminEarningsRecords'])->name('adminEarningsRecords');
        Route::get('adminearndetails/getdetails/{id}', [AdminEarningReportsController::class, 'adminEarningsDetails'])->name('adminEarningsdetailsdata');
        Route::get('withdrawal', [PayoutsController::class, 'showWithdrawal'])->name('withdrawal');
        Route::get('/payouts/changewithdrawalstatus/{id}/{mid}', [PayoutsController::class, 'changeWithdrawalStatus'])
            ->name('payouts.changeWithdrawalStatus');
        Route::get('/payouts/cancelwithdrawalstatus/{id}/{mid}', [PayoutsController::class, 'cancelWithdrawalStatus'])
            ->name('payouts.cancelWithdrawalStatus');
        // Ewallet
        Route::get('ewallet', [EwalletPaymentsController::class, 'showEwallet'])->name('ewalletmanagement');
        Route::get('ewalletGetData', [EwalletPaymentsController::class, 'showEwalletManagement'])->name('ewalletGetData');
        Route::post('ewallet/activate', [EwalletPaymentsController::class, 'activateEwalletPayment'])->name('ewalletactivate');

        // Funds
        Route::get('fundtransfer', [CFundTransferController::class, 'showFunds'])->name('fundtransfer');
        Route::get('fundtransferdata', [CFundTransferController::class, 'showFundTransfers'])->name('fundtransferdata');

        // Send Bonus
        Route::get('sendbonus', [SendBonusController::class, 'showSendBonus'])->name('sendbonus');
        Route::get('getmembers', [SendBonusController::class, 'getMembers']);
        Route::post('updatebonus', [SendBonusController::class, 'updateSendBonus'])->name('updatebonus');
        Route::post('usernamecheck', [SendBonusController::class, 'bonususernamechck'])->name('usernamecheck');

        // Deduct Bonus
        Route::get('detectfunds', [CDeductFundsController::class, 'showDetect'])->name('detectfunds');
        Route::get('getmembers', [CDeductFundsController::class, 'getMembers']);
        Route::post('updateDetect', [CDeductFundsController::class, 'updateDetect'])->name('updateDetect');

        // Logout
        Route::match(['get', 'post'], 'logout', [AuthController::class, 'logout'])->name('logout');
    });
// plan add routes
Route::prefix('admin')->group(function () {
    Route::get('matrix', [MatrixController::class, 'index'])->name('matrixconfig.matrix');
    Route::get('matrix/add', [MatrixController::class, 'create'])->name('matrix.create');
    Route::get('plans/create/{step?}', [MatrixController::class, 'create'])->name('admin.plans.create'); // New route
    Route::post('matrix/validateadd', [MatrixController::class, 'store'])->name('matrix.store');
    Route::post('matrix/check-matrix-name', [MatrixController::class, 'checkMatrixName'])->name('matrix.checkMatrixName');
    Route::post('matrix/validatesetconfig/{matrix_id}', [MatrixController::class, 'validateSetConfig'])->name('matrix.validatesetconfig');
    Route::get('plans', [MatrixController::class, 'index'])->name('admin.plans');
     Route::get('/plans/success', [MatrixController::class, 'success'])->name('admin.plans.success');

    // Admin Master group routes
    Route::resource('countries', CountryMasterController::class);
    Route::resource('states', StateController::class)->names('admin.states');
    Route::resource('cities', CityController::class);

    // admin settings routes
    Route::get('/site-settings', [SiteSettingsController::class, 'index'])->name('site-settings.index');
    Route::post('/site-settings', [SiteSettingsController::class, 'store'])->name('site-settings.store');

    // rank settings
    Route::get('/ranksetting', [RankController::class, 'index'])->name('ranksetting');
    Route::get('/ranksetting/add', [RankController::class, 'create'])->name('ranksetting.add');
    Route::post('/updateranksetting', [RankController::class, 'store'])->name('updateranksetting');
    Route::get('/ranksetting/edit/{rank_id}', [RankController::class, 'edit'])->name('ranksetting.edit');
    Route::post('/ranksetting/update', [RankController::class, 'update'])->name('ranksetting.update');
    Route::delete('/ranksetting/delete/{rank_id}', [RankController::class, 'destroy'])->name('ranksetting.delete');

    // bonus routes
    Route::get('/showbonuslist', [BonusController::class, 'index'])->name('bonus.list');
    Route::get('/addbonus', [BonusController::class, 'add'])->name('bonus.add');
    Route::post('/addnewbonus', [BonusController::class, 'store'])->name('bonus.store');
    Route::get('/getpackages/get/{id}', [BonusController::class, 'getPackages'])->name('get.packages');
    Route::get('/getranks/get/{id}', [BonusController::class, 'getRanks'])->name('get.ranks');
    Route::get('/bonus/{id}', [BonusController::class, 'show'])->name('bonus.show');

    // generation bonus
    Route::get('/generationbonus', [GenerationBonusController::class, 'index'])->name('generationbonus.index');
    Route::get('/generationbonus/addgen/{matrix_id?}', [GenerationBonusController::class, 'create'])->name('generationbonus.create');
    Route::post('/generationbonus/addnewbonus', [GenerationBonusController::class, 'store'])->name('generationbonus.store');
    Route::get('/generationbonus/editgen/{matrix_id}', [GenerationBonusController::class, 'edit'])->name('generationbonus.edit');
    Route::post('/generationbonus/updategenerbonus/{matrix_id}', [GenerationBonusController::class, 'update'])->name('generationbonus.update');
    Route::delete('/generationbonus/{id}', [GenerationBonusController::class, 'destroy'])->name('generationbonus.destroy');
    Route::post('/generationbonus/getrankgen', [GenerationBonusController::class, 'getRanks'])->name('generationbonus.getranks');

    // In routes/web.php or a similar route file
    Route::get('/matchbonus', [MatchingBonusController::class, 'index'])->name('matchbonus.index');
    Route::get('/matchbonus/add/{matrix_id?}', [MatchingBonusController::class, 'create'])->name('matchbonus.create');
    Route::post('/matchbonus/insert', [MatchingBonusController::class, 'store'])->name('matchbonus.store');
    Route::get('/matchbonus/edit/{id}', [MatchingBonusController::class, 'edit'])->name('matchbonus.edit');
    Route::put('/matchbonus/update/{id}', [MatchingBonusController::class, 'update'])->name('matchbonus.update');
    Route::post('/matchbonus/delete', [MatchingBonusController::class, 'destroy'])->name('matchbonus.destroy');
    Route::post('/matchbonus/getrankgen', [MatchingBonusController::class, 'getRankName'])->name('matchbonus.getrankgen');
    Route::post('/matchbonus/checkname', [MatchingBonusController::class, 'checkMatchingBonusName'])->name('matchbonus.checkname');

    // Customer Bonus Routes
    Route::get('/customerbonus', [CustomerBonusController::class, 'showCustomerBonus'])->name('customerbonus.show');
    Route::post('/customerbonus/update', [CustomerBonusController::class, 'updateCustomerBonus'])->name('customerbonus.update');

    // Distribution user details
    Route::get('distributors/{id}', [MemberAreaSummaryController::class, 'show'])
        ->name('distributors.show');
    Route::post('updatecontactdetails', [MemberAreaSummaryController::class, 'updateContactDetails'])
        ->name('distributors.updatecontactdetails');
    Route::post('updatebillingdetails', [MemberAreaSummaryController::class, 'updateBillingDetails'])
        ->name('distributors.updatebillingdetails');
    Route::post('savepassworddetail', [MemberAreaSummaryController::class, 'savePasswordDetail'])
        ->name('distributors.savepassworddetail');
    Route::post('memberarea/contactus/{members_id}', [MemberAreaSummaryController::class, 'contactUs'])
        ->name('distributors.contactus');
    Route::get('distributors/composenew/{id}', [MemberAreaSummaryController::class, 'composeNew'])
        ->name('distributors.composenew');
    Route::post('distributors/updatewebsitedetails', [MemberAreaSummaryController::class, 'updateWebsiteDetails'])
        ->name('distributors.updatewebsitedetails');
    Route::post('distributors/updatesocialdetails', [MemberAreaSummaryController::class, 'updateSocialMediaDetails'])
        ->name('distributors.updatesocialdetails');
    Route::post('/distributors/update-personal-info', [MemberAreaSummaryController::class, 'updatePersonalInfo'])
        ->name('distributors.updatepersonalinfo');
    Route::get('memberchangeactive/active/{id}', [MemberAreaSummaryController::class, 'activateMember'])
        ->name('member.activate');
    Route::get('memberchangesuspend/suspend/{id}', [MemberAreaSummaryController::class, 'suspendMember'])
        ->name('member.suspend');
    Route::get('personalpurchase/show/{id}', [MemberAreaSummaryController::class, 'personalPurchases'])
     ->name('personalpurchase.show');
    Route::get('commission/invoice/{id}', [MemberAreaSummaryController::class, 'commissionInvoice'])
         ->name('commission.invoice');
    Route::get('commission/packages/{id}', [MemberAreaSummaryController::class, 'packageHistory'])
         ->name('commission.packages');
    Route::get('commission/pdf/{id}', [MemberAreaSummaryController::class, 'commissionPdf'])
         ->name('commission.pdf');
    Route::get('package/pdf/{id}', [MemberAreaSummaryController::class, 'packagePdf'])
         ->name('package.pdf');
    Route::get('showmemberparties/show/{memberId}', [MemberAreaSummaryController::class, 'showMemberParties'])
     ->name('showmemberparties');
    Route::get('getuserform/edituser/{id}', [MemberAreaSummaryController::class, 'getEditForm'])
        ->name('editform');
    Route::post('UpdateUserForm/update/{id}', [MemberAreaSummaryController::class, 'UpdateUserForm'])
        ->name('UpdateUserForm');
    Route::get('userdetailsplan/show/{id}', [MemberAreaSummaryController::class, 'planDetails'])
        ->name('user.plan-details');
        Route::post('userdetailsplan/approve-payment', [MemberAreaSummaryController::class, 'approvePendingPayment'])
    ->name('user.approve-payment');
    Route::get('paymentinfo/{id}', [MemberAreaSummaryController::class, 'getPaymentInfo'])
     ->name('paymentinfo');
    Route::get('userprocessedearning/get/{id}', [MemberAreaSummaryController::class, 'getProcessedEarnings'])
     ->name('user.processed-earnings');
    Route::get('usercommissiondetails/get/{id}', [MemberAreaSummaryController::class, 'getCommissionReport'])
     ->name('user.commission-report');
    Route::get('userewallethistory/get/{id}', [WalletController::class, 'showUserEwallet'])
      ->name('userewallethistory.get');
    Route::get('userpayoutdetails/get/{id}', [WalletController::class, 'payoutHistory'])
        ->name('userpayoutdetails.get');
    Route::get('memberareatransaction/show/{id}', [TransactionController::class, 'memberAreaTransaction'])
         ->name('memberareatransaction.show');
    Route::get('userdetailswithdrawal/show/{id}', [TransactionController::class, 'userDetailsWithdrawal'])
         ->name('userdetailswithdrawal.show');
    Route::get('showuserdeatilspv/show/{id}', [TransactionController::class, 'showUserDetailsPv'])
         ->name('showuserdeatilspv.show');
    Route::get('showuserfundtransfer/show/{id}', [TransactionController::class, 'showUserFundTransfer'])
         ->name('showuserfundtransfer.show');


    // Premium Courses Controller
    Route::get('/showelearning/show', [PremiumCoursesController::class, 'showELearning'])
        ->name('admin.elearning.show');

    Route::post('/elearning/insertcourse', [PremiumCoursesController::class, 'insertCourse'])
        ->name('elearning.insertcourse');

    Route::post('/elearning/updatecourses', [PremiumCoursesController::class, 'updateCourses'])
        ->name('updatecourses');

    Route::get('/showcoursematerial/{sub1}/{sub2}', [PremiumCoursesController::class, 'showCourseMaterial'])
        ->name('showcoursematerial');

    Route::get('/delete/{sub1}', [PremiumCoursesController::class, 'deleteCourse'])
        ->name('deletecourse');

    Route::get('/finalstage', [PremiumCoursesController::class, 'finalStage'])
        ->name('finalstage');

    Route::get('/finaleditstage', [PremiumCoursesController::class, 'finalEditStage'])
        ->name('finaleditstage');

    Route::post('/elearning/updatestatus', [PremiumCoursesController::class, 'updateStatus'])
        ->name('updatestatus');

    Route::post('/elearning/showsubtitle', [PremiumCoursesController::class, 'showSubTitle'])
        ->name('showsubtitle');

    Route::get('/elearning/showallelearning', [PremiumCoursesController::class, 'showAllELearning'])
        ->name('elearning.showallelearning');

    Route::post('/elearning/updateeditstatus', [PremiumCoursesController::class, 'updateEditStatus'])
        ->name('updateeditstatus');

    Route::post('/elearning/checktitle', [PremiumCoursesController::class, 'checkTitle'])
        ->name('checktitle');

    Route::get('/elearning/showpak_rank/{sub1}/{id?}', [PremiumCoursesController::class, 'showPakRank'])
        ->name('showpak_rank');

    Route::post('/elearning/submitannouncement/{sub1}', [PremiumCoursesController::class, 'addAnnouncement'])
        ->name('submitannouncement');

    Route::post('/elearning/insertcourcedetails', [PremiumCoursesController::class, 'addCourcedetails'])
        ->name('insertcourcedetails');

    // Premium Learning Lesson Controller
    Route::get('/lesson/{course}', [PremiumLearningLessonController::class, 'viewLessonDetails'])
        ->name('viewlessondetails');

    Route::get('/edit-course/{course}', [PremiumLearningLessonController::class, 'editELearning'])
        ->name('editelearning');

    Route::get('/elearning/showlession/{id}', [PremiumLearningLessonController::class, 'showLession'])
        ->name('showlession');

    Route::get('/elearning/editlession/{course}/{lesson}', [PremiumLearningLessonController::class, 'editLession'])
        ->name('editlession');

    Route::get('/elearning/addlession/{course}/{lesson}', [PremiumLearningLessonController::class, 'addLession'])
        ->name('addlession');

    Route::get('/elearning/editshowlession/{course}/{lesson}/{type}', [PremiumLearningLessonController::class, 'editShowLession'])
        ->name('editshowlession');

    Route::post('/elearning/insertlession/{course}/{lesson}', [PremiumLearningLessonController::class, 'insertLession'])
        ->name('insertlession');

    Route::get('/elearning/showreview/{id}', [PremiumLearningLessonController::class, 'showReview'])
        ->name('showreview');

    Route::post('/elearning/showcoursesubtitle', [PremiumLearningLessonController::class, 'showcoursesubtitle'])
        ->name('showcoursesubtitle');

    Route::get('/elearning/showfullreview/{id}', [PremiumLearningLessonController::class, 'showFullReview'])
        ->name('showfullreview');

    Route::get('/elearning/showcoursefaq/{id}', [PremiumLearningLessonController::class, 'showCourseFaq'])
        ->name('showcoursefaq');

    Route::post('/elearning/insertcoursefaq/{id}', [PremiumLearningLessonController::class, 'insertCourseFaq'])
        ->name('insertcoursefaq');

    Route::post('/elearning/insertcourseansfaq/{id}', [PremiumLearningLessonController::class, 'insertCourseAnsFaq'])
        ->name('insertcourseansfaq');

    Route::post( '/elearning/insertsubcourse/{id}', [PremiumLearningLessonController::class, 'insertSubCourse'])
        ->name('elearning.insertsubcourse');

    Route::post('/elearning/addsubtitlelession/{course}/{lesson}/{type}', [PremiumLearningLessonController::class, 'addSubLession'])
        ->name('addsubtitlelession');

    Route::get('/elearning/getfaqlession/{id}', [PremiumLearningLessonController::class, 'getFaqLession'])
        ->name('getfaqlession');

    Route::get('/elearning/delete/{id}/{fid}', [PremiumLearningLessonController::class, 'deleteFaqLession'])
        ->name('delete');

    Route::get('/elearning/deletelession/{id}/{lessonid}', [PremiumLearningLessonController::class, 'deleteLession'])
        ->name('deletelession');

    Route::get('/elearning/editshowquiz/{course}/{lesson}/{type}', [PremiumLearningLessonController::class, 'editShowQuiz'])
        ->name('editshowquiz');

    Route::get('/elearning/showcoursequiz/{id}', [PremiumLearningLessonController::class, 'showCoursequiz'])
        ->name('showcoursequiz');

    Route::get('/elearning/showaddquiz/{id}', [PremiumLearningLessonController::class, 'showCourseAddQuiz'])
        ->name('showaddquiz');

    Route::get('/elearning/getquiz/{id}', [PremiumLearningLessonController::class, 'getQuiz'])
        ->name('getquiz');

    Route::post('/elearning/updatequizlession/{id}/{lessid}', [PremiumLearningLessonController::class, 'Updatequizlession'])
        ->name('updatequizlession');

    Route::post('/elearning/insertquiz/{id}', [PremiumLearningLessonController::class, 'insertCoursequiz'])
        ->name('insertquiz');

    Route::get('/elearning/viewlinklession/{id}', [PremiumLearningLessonController::class, 'viewlinklession'])
        ->name('viewlinklession');

    // Premium Learning Lesson Update Controller
    Route::post('/elearning/updatelession/{course}/{lesson}', [PremiumLearningLessonUpdateController::class, 'updateLession'])
        ->name('elearning.updatelession');

    // Premium Course Payment Controller
    Route::get('/showcoursepayment', [PremiumCoursePaymentController::class, 'coursePayment'])
        ->name('coursepayment.show');

    Route::get('/coursepayment/changepaymentstatus/{sub1}/{sub2}', [PremiumCoursePaymentController::class, 'changePaymentStatus'])
        ->name('coursepayment.changepaymentstatus');

    Route::get('/coursepayment/cancelpayment/{sub1}/{sub2}', [PremiumCoursePaymentController::class, 'cancelPayment'])
        ->name('coursepayment.cancel');

});


// Routes for Matrix Packages
Route::prefix('admin')->group(function () {

//Plans Edit
Route::Post('matrix/setconfig/{matrix_id}', [MatrixConfigurationController::class, 'setMatrixConfiguration'])->name('matrix.setconfig');
Route::get('matrix/configure/{matrix_id}', [MatrixConfigurationController::class, 'showMatrixConfiguration'])->name('matrix.showconfig');
Route::Post('matrix/validatesetconfig/{matrix_id}', [MatrixConfigurationController::class, 'validateSetMatrixConfig'])->name('matrix.validatesetconfig');

// Routes for Matrix Packages
// GET Routes (for viewing, showing, or previewing)
Route::get('matrix/viewAllPackage/{matrix_id}', [MatrixPackageController::class, 'viewAllPackages'])->name('matrix.allpackage');
Route::get('matrix/editpackage/{package_id}/{matrix_id}', [MatrixPackageController::class, 'showEditPackage'])->name('matrix.editpackage');
Route::get('matrix/showAddPackage/{matrix_id}', [MatrixPackageController::class, 'showAddPackage'])->name('matrix.addpackage');
Route::get('matrix/previewPackageIcon/{matrix_id}', [MatrixPackageController::class, 'previewPackageIcon'])->name('matrix.previewPackageIcon');

// POST Routes (for actions that modify data)
Route::post('matrix/insertPackage/{matrix_id}', [MatrixPackageController::class, 'insertPackage'])->name('matrix.insertPackage');
Route::post('matrix/updatePackage/{package_id}/{matrix_id}', [MatrixPackageController::class, 'updatePackage'])->name('matrix.updatePackage');
Route::Delete('matrix/deletePackage/{package_id}', [MatrixPackageController::class, 'deletePackage'])->name('matrix.deletePackage');
Route::post('matrix/validatePackageName/{matrix_id}', [MatrixPackageController::class, 'validatePackageName'])->name('matrix.validatePackageName');

//  levelcommision

Route::get('matrix/level/{matrix_id}', [LevelCommissionController::class, 'showLevelCommission'])->name('matrix.level');
Route::post('matrix/validatelevel', [LevelCommissionController::class, 'validateLevelCommission'])->name('matrix.validatelevel');
Route::post('matrix/deletelevel', [LevelCommissionController::class, 'deleteLevelCommission'])->name('matrix.deletelevel');

//  levelcommision
Route::get('matrix/packagelevel/{matrix_id}/{package_id}', [PackageLevelCommissionController::class, 'showPackageLevelCommission'])->name('matrix.packagelevel');
Route::post('matrix/validatepackagelevel', [PackageLevelCommissionController::class, 'validatePackageLevelCommission'])->name('matrix.validatepackagelevel');
Route::post('matrix/deletepackagelevel', [PackageLevelCommissionController::class, 'deletePackageLevelCommission'])->name('matrix.deletepackagelevel');


});

// Genealogy

Route::prefix('admin')->group(function () {
Route::get('grpgenealogy/viewtree/{matrixId}/{memberId?}', [GraphicalGenealogyController::class, 'viewGenealogyTree'])
    ->name('grpgenealogy.viewtree');

//Classic view
Route::get('genealogy/viewtree/classicview/{matrixId}/{memberId?}',
    [GenealogyController::class, 'viewGenealogyTree'])
    ->name('genealogy.viewtree.classicview');
// Route::get('getmember', [GenealogyController::class, 'getMembers'])->name('getMembers');

    // Auto-suggestion list (POST)
Route::get('genealogy/getmembers/{matrixId}/{query}',
    [GenealogyController::class, 'getMembers']);



// Search route (POST)
Route::post('genealogy/search',[GenealogyController::class, 'searchMember'])->name('genealogy.search');

Route::post('grpgenealogy/updatetemplate', [GraphicalGenealogyTemplateController::class, 'setGenealogyTemplate'])->name('updatetemplate');

Route::get('getcryptdata', [GenealogyController::class, 'getCryptData'])->name('getcryptdata');

//collapse view
Route::get('genealogy/viewtree/collapseview/{matrixId}/{memberId?}',
    [CollapseGenealogyController::class, 'viewGenealogyTree'])
    ->name('genealogy.viewtree.collapseview');
//Tabular view
Route::get('genealogy/viewtree/tabularview/{matrixId}/{memberId?}',
    [TabularGenealogyController::class, 'viewTabularGenealogy'])
    ->name('genealogy.viewtree.tabularview');

Route::get('/genealogy/viewtree/gettabularview/{matrixId}/{memberId?}',
    [TabularGenealogyController::class, 'getTabularGenealogyDetails'])
    ->name('genealogy.viewtree.gettabularview');


    //Rank view
    Route::get('rankgenealogy/viewtree/{matrixId}/{memberId?}',
    [GraphicalGenealogyController::class, 'viewGenealogyTree'])
    ->name('genealogy.viewtree');

    //downline view
    Route::get('countgenealogy/viewtree/{matrixId}/{memberId?}',
    [GraphicalGenealogyController::class, 'viewGenealogyTree'])
    ->name('genealogy.viewtree.countgenealogy');


    //E-pin
    Route::get('sendpin', [SendEpinsController::class, 'showSendEpin'])->name('sendpin');

    Route::post('updateEpins', [SendEpinsController::class, 'updateEpins'])->name('updateepins');

    Route::get('sendepin/getpackageamount/{id}/{type}',
    [SendEpinsController::class, 'getPackageAmount']
)->name('getpackageamount');

//epinhsitory
 Route::get('epinhistory', [EpinManagementController::class, 'showEpinManagement'])->name('epinhistory');
  Route::get('epinhistorydata', [EpinManagementController::class, 'getEpinManagementRecords'])->name('epinhistorydata');

  //settings login
   Route::get('showbanners/login', [BannerSettingsController::class, 'showBanners'])->name('showbanners/login');
Route::get('editbanner/{action}/{id}', [BannerSettingsController::class, 'showEditBanner'])
    ->name('editbanner');

Route::post('validateeditbanner/{action}/{id}',
    [BannerSettingsController::class, 'validateEditBanner']
)->name('validateeditbanner');
Route::get('showbanners/delete/{id}',
    [BannerSettingsController::class, 'deleteBanner']
)->name('banner.delete');
 //settings register
   Route::get('showbanners/register', [BannerSettingsController::class, 'showBanners'])->name('showbanners/register');
// Route::get('editbanner/{action}/{id}', [BannerSettingsController::class, 'showEditBanner'])
//     ->name('editbanner');

// Route::post('validateeditbanner/{action}/{id}',
//     [BannerSettingsController::class, 'validateEditBanner']
// )->name('validateeditbanner');
// Route::get('showbanners/delete/{id}',
//     [BannerSettingsController::class, 'deleteBanner']
// )->name('banner.delete');

 //ewalletgateway
   Route::get('ewalletgateway', [EwalletGatewaySettingsController::class, 'ewalletGateway'])->name('ewalletgateway');
      Route::post('updateewallet', [EwalletGatewaySettingsController::class, 'updateEwallet'])->name('updateewallet');
    Route::post('generateKey', [EwalletGatewaySettingsController::class, 'generateKey'])->name('generateKey');
//system modules
Route::get('systemmodules', [SystemManagementController::class, 'showSystemModules'])
    ->name('systemmodules');


   //logs(user)
    Route::get('userlogs', [LogManagementController::class, 'showUserLogs'])->name('userlogs');
    //logs(admin);
    Route::get('adminlogs', [LogManagementController::class, 'showAdminLogs'])->name('adminlogs');

    //reistersettings
        Route::get('registersettings', [RegisterSettingsController::class, 'showRegisterSettings'])->name('registersettings');
        //updateregistersettings
         Route::post('updateRegSettings', [RegisterSettingsController::class, 'updateRegSettings'])->name('updateRegSettings');


    //userdashboard setting
     Route::get('dashboardsettings', [UserDashboardController::class, 'showUserDashboard'])->name('dashboardsettings');
     Route::post('updatedashboardsetting', [UserDashboardController::class, 'updateUserDashboard'])->name('updatedashboardsetting');
     //enable/disable features
    Route::get('enablefeature', [FeaturesController::class, 'showFeature'])->name('enablefeature');
    Route::post('enablefeatureupdate', [FeaturesController::class, 'updateFeature'])
     ->name('enablefeatureupdate');

    //terminology feature
    Route::get('terminologysettings/lang/{lang}', [TerminologyController::class, 'showTerminologySettings'])
    ->name('terminologysettings');
    Route::post('terminologysettings/update/{lang}',
        [TerminologyController::class, 'updateTerminologySettings']
    )->name('terminologysettings.update');
    //role settings
    // Route::get('rolemanagement', [RoleManagementController::class, 'showRoleManagementSettings'])->name('rolemanagement');
    Route::get('rolemanagement/view/{id}',
        [RoleManagementController::class, 'showRoleManagementSettings']
    )->name('rolemanagement.view');

    //update role
    Route::post('rolemanagement/updaterole', [RoleManagementController::class, 'updateRole'])
        ->name('rolemanagement.update');
    //create role
    Route::post('create-role', [RoleManagementController::class, 'createRole'])
    ->name('create');
    Route::get('rolemanagement/deleterole/{id}',
        [RoleManagementController::class, 'deleterole']
    )->name('delete');
    //currency settings
    Route::get('currencysettings', [LeadContactsController::class, 'currencysetting'])->name('currencysettings');
    Route::post('insertcurrency', [LeadContactsController::class, 'insertcurrency'])->name('insertcurrency');
    //update
    Route::get('paymentsettings', [PaymentSettingsController::class, 'showPaymentSettings'])->name('paymentsettings');
    Route::post('updatepaymentsettings', [PaymentSettingsController::class, 'updatePaymentSettings'])->name('updatepaymentsettings');
    //otpsend
    Route::post('otpsent', [PaymentSettingsController::class, 'sendOTPPayment'])->name('otpsent');
    // Route::get('otpsent', [PaymentSettingsController::class, 'sendOTPPayment'])->name('otpsent');
    Route::post('paymentsettings/validateotp',[PaymentSettingsController::class, 'paymentValidateOTP']
        )->name('validateotp');

});


Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('user.dashboard')
        : redirect()->route('user.login');
})->name('home');

Route::fallback(function () {
    if (request()->is('admin*') && !Auth::check()) {
        return redirect()->route('admin.login');
    }
    abort(404);
});
