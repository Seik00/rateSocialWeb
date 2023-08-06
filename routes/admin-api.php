<?php

use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\InsuranceController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RecordController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WalletController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

// Protected routes->middleware(['jwt.auth', 'check-creator']);
//Route::middleware('jwt.auth')->group(function () {
Route::group(['middleware' => ['jwt.auth', 'check-admin']], function () {

    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('home', [DashboardController::class, 'home']);
        Route::get('header', [DashboardController::class, 'header']);
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('user_list', [UserController::class, 'user_list']);
        Route::post('/registerMember', [UserController::class, 'registerMember']);
        Route::post('/delete_admin', [UserController::class, 'delete_admin']);
        Route::get('user_list', [UserController::class, 'user_list']);
        Route::get('/admin_list', [UserController::class, 'admin_list']);
        Route::post('/update_admin', [UserController::class, 'update_admin']);
        Route::post('/create_admin', [UserController::class, 'create_admin']);
        Route::get('get_user_info', [UserController::class, 'get_user_info']);
        Route::get('/userPackage', 'UserController@userPackage')->name('userPackage');
        Route::post('updateUser', [UserController::class, 'updateUser']);
        Route::post('userSetting', [UserController::class, 'userSetting']);

        Route::post('updatePwd', [UserController::class, 'updatePwd']);

        Route::get('kycList', [UserController::class, 'kycList']);
        Route::post('kycControl', [UserController::class, 'kycControl']);
        Route::get('kycHis', [UserController::class, 'kycHis']);
    });

    Route::group(['prefix' => 'package'], function () {
        Route::get('userRobotPackage', [PackageController::class, 'userRobotPackage']);
    });

    Route::group(['prefix' => 'export'], function () {
        Route::get('/exportBonus', [ExportController::class, 'exportBonus']);
        Route::get('/exportWithdrawHis', [ExportController::class, 'exportWithdrawHis']);
        Route::get('/exportWithdrawList', [ExportController::class, 'exportWithdrawList']);
        Route::get('/exportReloadRecord', [ExportController::class, 'exportReloadRecord']);
        Route::get('/exportTransactionRecord', [ExportController::class, 'exportTransactionRecord']);
        Route::get('/exportUser', [ExportController::class, 'exportUser']);
        Route::get('/exportWallet', [ExportController::class, 'exportWallet']);
    });

    Route::group(['prefix' => 'wallet'], function () {
        Route::get('/walletChangeRec', [WalletController::class, 'walletChangeRec']);
        Route::post('/changeWallet', [WalletController::class, 'changeWallet']);
        Route::get('/withdrawList', [WalletController::class, 'withdrawList']);
        Route::get('/withdrawHis', [WalletController::class, 'withdrawHis']);
        Route::post('/withdrawControl', [WalletController::class, 'withdrawControl']);
        Route::post('/batchWithdrawControl', [WalletController::class, 'batchWithdrawControl']);
        //////////////new changed ////////////////////

        Route::get('/depositList', [WalletController::class, 'depositList']);
        Route::post('/depositControl', [WalletController::class, 'depositControl']);
        Route::get('/depositCoinList', [WalletController::class, 'depositCoinList']);
        Route::post('/depositCoinControl', [WalletController::class, 'depositCoinControl']);
//new api
        Route::get('/depositRequestList', [WalletController::class, 'depositRequestList']);
        Route::post('/depositRequestControl', [WalletController::class, 'depositRequestControl']);

        Route::get('/withdrawCashList', [WalletController::class, 'withdrawCashList']);
        Route::post('/editWithdrawCash', [WalletController::class, 'editWithdrawCash']);
        Route::get('/withdrawCashHis', [WalletController::class, 'withdrawCashHis']);
        Route::post('/withdrawCashControl', [WalletController::class, 'withdrawCashControl']);

        Route::post('/editWithdrawCoin', [WalletController::class, 'editWithdrawCoin']);
        Route::get('/reloadRecord', [WalletController::class, 'reloadRecord']);
        //

    });
    Route::group(['prefix' => 'insurance'], function () {
        Route::get('claimRecord', [InsuranceController::class, 'claimRecord']);

        Route::post('/claimControl', [InsuranceController::class, 'claimControl']);
        Route::get('claimHis', [InsuranceController::class, 'claimHis']);
        Route::get('/insuranceBetRecord', [InsuranceController::class, 'insuranceBetRecord']);
        Route::get('surenderRecord', [InsuranceController::class, 'surenderRecord']);
        Route::get('surenderHis', [InsuranceController::class, 'surenderHis']);
        Route::post('/surenderControl', [InsuranceController::class, 'surenderControl']);
        Route::get('/revertRecord', [InsuranceController::class, 'revertRecord']);
        Route::post('/revertControl', [InsuranceController::class, 'revertControl']);
    });

    Route::group(['prefix' => 'record'], function () {
        Route::get('otpRecord', [RecordController::class, 'otpRecord']);
        Route::get('walletRecord', [RecordController::class, 'walletRecord']);
        Route::get('userWalletRecord', [RecordController::class, 'userWalletRecord']);
        Route::get('bonusRecord', [RecordController::class, 'bonusRecord']);
        Route::get('userPackageRecord', [RecordController::class, 'userPackageRecord']);
        Route::get('teamReport', [RecordController::class, 'teamReport']);
        Route::get('exportTeamReport', [RecordController::class, 'exportTeamReport']);
    });
    Route::group(['prefix' => 'team'], function () {
        Route::get('/sponsorTree', [TeamController::class, 'sponsorTree']);
        Route::get('/jstree_ajax_data', [TeamController::class, 'jstree_ajax_data']);
    });

    Route::group(['prefix' => 'news'], function () {
        Route::get('/newsList', [NewsController::class, 'newsList'])->name('newsList');
        Route::post('/newsControl', [NewsController::class, 'newsControl'])->name('newsControl');
        Route::get('/newsInfo', [NewsController::class, 'newsInfo'])->name('newsInfo');
    });
    Route::group(['prefix' => 'customer'], function () {
        Route::get('/ticketList', [CustomerController::class, 'ticketList'])->name('ticketList');
        Route::post('/ticketControl', [CustomerController::class, 'ticketControl'])->name('ticketControl');
        Route::get('/ticketInfo', [CustomerController::class, 'ticketInfo'])->name('ticketInfo');
        Route::post('/markRead', [CustomerController::class, 'markRead'])->name('markRead');
        Route::get('/countRead', [CustomerController::class, 'countRead'])->name('countRead');
    });
    Route::group(['prefix' => 'setting'], function () {
        Route::get('/systemConfig', [SettingController::class, 'systemConfig'])->name('systemConfig');
        Route::post('/saveConfig', [SettingController::class, 'saveConfig'])->name('saveConfig');

        Route::get('/packageConfig', 'SettingController@packageConfig')->name('packageConfig');
        Route::post('/savePackage', 'SettingController@savePackage')->name('savePackage');
    });

    //boost system
    Route::group(['prefix' => 'product'], function () {
        Route::get('/productList', [ProductController::class, 'productList'])->name('productList');
        Route::get('/getProductByPrice', [ProductController::class, 'getProductByPrice'])->name('getProductByPrice');
        Route::post('/productControl', [ProductController::class, 'productControl'])->name('productControl');
        Route::get('/productInfo', [ProductController::class, 'productInfo'])->name('productInfo');
    });
    Route::group(['prefix' => 'chat'], function () {
        Route::get('chatlist', [ChatController::class, 'chatlist']);
        Route::get('getChat', [ChatController::class, 'getChat']);
        Route::get('getChatNotification', [ChatController::class, 'getChatNotification']);
        Route::post('sentChat', [ChatController::class, 'sentChat']);
    });
    Route::group(['prefix' => 'country'], function () {
        Route::get('/coutryList', [CountryController::class, 'coutryList'])->name('coutryList');
        Route::post('/countryControl', [CountryController::class, 'countryControl'])->name('countryControl');
        Route::get('/countryInfo', [CountryController::class, 'countryInfo'])->name('countryInfo');

        Route::get('/bankList', [CountryController::class, 'bankList'])->name('bankList');
        Route::post('/bankControl', [CountryController::class, 'bankControl'])->name('bankControl');
        Route::get('/bankInfo', [CountryController::class, 'bankInfo'])->name('bankInfo');
    });
});
