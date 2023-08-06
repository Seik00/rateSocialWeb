<?php

use App\Http\Controllers\Api\APIController;
use App\Http\Controllers\Api\AttachmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BOController;
use App\Http\Controllers\Api\CasinoController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\CronController;
use App\Http\Controllers\Api\CronjobController;
use App\Http\Controllers\Api\DepositController;
use App\Http\Controllers\Api\GlobalAPIController;
use App\Http\Controllers\Api\InsuranceController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\PaymentGatewayController;
use App\Http\Controllers\Api\RecordController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\ThirdPartyController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\TradeController;
use App\Http\Controllers\Api\WalletController;
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

Route::group(['middleware' => 'guest:api'], function () {
    Route::group(['prefix' => 'cronjob'], function () {
        Route::post('heavytest', [RobortController::class, 'heavytest']);
        Route::get('test', [APIController::class, 'test']);
        Route::get('CheckRank', [CronjobController::class, 'CheckRank']);
        Route::get('renewInsurance', [CronjobController::class, 'renewInsurance']);
        Route::get('introduce', [CronjobController::class, 'introduce']);
        // Route::get('RunMatchingBonus', [CronjobController::class, 'RunMatchingBonus']);
        // Route::get('RunRoiBonus', [CronjobController::class, 'RunRoiBonus']);
        Route::get('SetSite', [CronjobController::class, 'SetSite']);
        // Route::get('CheckRank', 'CronjobController@CheckRank');
        // Route::get('RunBonus', 'CronjobController@RunBonus');
        // Route::get('RunDynamic', 'CronjobController@RunDynamic');
    });
    Route::group(['prefix' => 'third-party'], function () {
        Route::any('reload-respond', [ThirdPartyController::class, 'reloadRespond']);
        Route::any('withdraw-respond', [ThirdPartyController::class, 'withdrawRespond']);
        Route::any('grouping-respond', [ThirdPartyController::class, 'groupingRespond']);
        Route::any('deposit', [ThirdPartyController::class, 'deposit']);
        Route::any('import-bet-record', [ThirdPartyController::class, 'importBetRecord']);
    });

    Route::group(['prefix' => 'payment-gateway'], function () {
        Route::any('yodgs-frontend-respond', [PaymentGatewayController::class, 'yodgsFrontendRespond']);
        Route::any('yodgs-backend-respond', [PaymentGatewayController::class, 'yodgsBackendRespond']);
        Route::any('yodgs-withdraw-respond', [PaymentGatewayController::class, 'yodgsWithdrawRespond']);

        Route::any('crypto5Pay-frontend-respond', [PaymentGatewayController::class, 'crypto5PayFrontendRespond']);
        Route::any('crypto5Pay-backend-respond', [PaymentGatewayController::class, 'crypto5PayBackendRespond']);
        Route::any('crypto5Pay-withdraw-respond', [PaymentGatewayController::class, 'crypto5PayWithdrawRespond']);
    });

    Route::group(['prefix' => 'cron'], function () {
        Route::get('resetBoostTime', [CronjobController::class, 'resetBoostTime']);
        Route::get('index', [CronController::class, 'index']);
        Route::get('update_spot_market', [CronController::class, 'update_spot_market']);
        Route::get('push_notice', [CronController::class, 'push_notice']);

        // Route::get('RunBonus', 'CronjobController@RunBonus');
        // Route::get('RunDynamic', 'CronjobController@RunDynamic');
    });

    Route::group(['prefix' => 'global'], function () {
        Route::post('add_device_token', [GlobalAPIController::class, 'add_device_token']);
        Route::post('usernameOTP', [GlobalAPIController::class, 'usernameOTP']);
        Route::get('checkUsernameOtp', [GlobalAPIController::class, 'checkUsernameOtp']);
        Route::post('sent-otp', [GlobalAPIController::class, 'sentOTP']);
        Route::get('check-otp', [GlobalAPIController::class, 'checkOTP']);
        Route::get('country_list', [GlobalAPIController::class, 'country_list']);
        Route::get('lookup', [GlobalAPIController::class, 'lookup']);
    });
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('signup', [AuthController::class, 'signup']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('reset-password', [AuthController::class, 'resetPassword']);
    });

});
// Protected routes
Route::middleware('jwt.auth')->group(function () {
    Route::group(['prefix' => 'global'], function () {
        Route::post('add_user_device_token', [GlobalAPIController::class, 'add_device_token']);
    });

    Route::group(['prefix' => 'member'], function () {
        //special
        Route::get('detectUsername', [MemberController::class, 'detectUsername']);

        Route::post('setLanguage', [MemberController::class, 'setLanguage']);

        Route::get('get-member-info', [MemberController::class, 'getMemberInfo']);
        Route::post('update-member-info', [MemberController::class, 'updateMemberInfo']);
        Route::post('change-password', [MemberController::class, 'changePassword']);
        Route::post('set-secpassword', [MemberController::class, 'setSecPassword']);
        Route::post('reset-secpassword', [MemberController::class, 'resetSecPassword']);
        Route::post('change-secpassword', [MemberController::class, 'changeSecPassword']);
        Route::get('home-page', [MemberController::class, 'homePage']);
        Route::post('register-member', [MemberController::class, 'registerMember']);
        Route::post('user-bank', [MemberController::class, 'userBank']);
        Route::get('get-bank-info', [MemberController::class, 'getBankInfo']);
        Route::post('update-address', [MemberController::class, 'updateAddress']);
        Route::post('UserKyc', [MemberController::class, 'UserKyc']);

        Route::post('requestUserOTP', [MemberController::class, 'requestUserOTP']);
        Route::post('checkUserOTP', [MemberController::class, 'checkUserOTP']);
    });

    Route::group(['prefix' => 'project'], function () {
        Route::get('get-deposit-bank', [APIController::class, 'getDepositBank']);
    });

    Route::group(['prefix' => 'package'], function () {
        Route::get('get-upgrade-package', [PackageController::class, 'getUpgradePackage']);
        Route::post('upgrade-package', [PackageController::class, 'purchasePackage']);
        Route::get('get-package', [PackageController::class, 'getPackage']);
        Route::get('get-user-package', [PackageController::class, 'getUserPackage']);

    });

    Route::group(['prefix' => 'insurance'], function () {
        Route::get('getInsuranceHis', [InsuranceController::class, 'getInsuranceHis']);
        Route::post('purchaseInsurance', [InsuranceController::class, 'purchaseInsurance']);
        Route::post('claimInsurance', [InsuranceController::class, 'claimInsurance']);
        Route::get('getClaimInsuranceHis', [InsuranceController::class, 'getClaimInsuranceHis']);
        Route::post('surrender', [InsuranceController::class, 'surrender']);

    });

    Route::group(['prefix' => 'ticket'], function () {
        Route::get('get-ticket', [TicketController::class, 'getTicket']);
        Route::get('read-ticket', [TicketController::class, 'readTicket']);
        Route::post('create-ticket', [TicketController::class, 'createTicket']);
    });
//payment gateway
    Route::group(['prefix' => 'deposit'], function () {
        Route::post('depositCash', [DepositController::class, 'depositCash']);
        Route::post('depositCoin', [DepositController::class, 'depositCoin']);
    });

    Route::group(['prefix' => 'wallet'], function () {
        Route::get('getWallet', [MemberController::class, 'getWallet']);
    });
    Route::group(['prefix' => 'chat'], function () {
        Route::get('getChat', [ChatController::class, 'getChat']);
        Route::get('getChatNotification', [ChatController::class, 'getChatNotification']);
        Route::post('sentChat', [ChatController::class, 'sentChat']);
    });
    Route::group(['prefix' => 'wallet'], function () {

        ///boost system
        Route::get('checkAllowDeposit', [WalletController::class, 'checkAllowDeposit']);
        Route::post('requestMakeDeposit', [WalletController::class, 'requestMakeDeposit']);
        ////////////////////////////////////////
        Route::get('getDepositBank', [WalletController::class, 'getDepositBank']);
        Route::post('doDeposit', [WalletController::class, 'doDeposit']);

        Route::get('getDepositAddress', [WalletController::class, 'getDepositAddress']);
        Route::post('doDepositCoin', [WalletController::class, 'doDepositCoin']);

        Route::post('withdraw', [WalletController::class, 'withdraw']);
        Route::get('withdraw-record', [WalletController::class, 'withdrawRecord']);

        Route::post('withdrawCash', [WalletController::class, 'withdrawCash']);
        Route::get('withdrawCashRecord', [WalletController::class, 'withdrawCashRecord']);

        Route::get('wallet-tranfer-record', [WalletController::class, 'walletTransferRecord']);
        Route::post('wallet-transafer', [WalletController::class, 'walletTransfer']);
        Route::post('check-receiver', [WalletController::class, 'checkReceiver']);

        Route::post('changeWallet', [WalletController::class, 'changeWallet']);
        Route::post('depositAddress', [WalletController::class, 'depositAddress']);
        Route::get('deposit-record', [WalletController::class, 'depositRecord']);
        Route::get('boDepositRecord', [WalletController::class, 'boDepositRecord']);

    });

    Route::group(['prefix' => 'team'], function () {
        Route::get('downline-new', [TeamController::class, 'downlineNew']);
        Route::get('organize', [TeamController::class, 'organize']);
    });

    Route::group(['prefix' => 'record'], function () {
        Route::get('wallet-record', [RecordController::class, 'walletRecord']);
        Route::get('bonus-record', [RecordController::class, 'bonusRecord']);
    });
    Route::group(['prefix' => 'news'], function () {
        Route::get('banner-list', [NewsController::class, 'bannerList']);
        Route::get('news-list', [NewsController::class, 'newsList']);
    });
    Route::group(['prefix' => 'order'], function () {
        Route::get('orderInfo', [OrderController::class, 'orderInfo']);
        Route::post('checkOrder', [OrderController::class, 'checkOrder']);
        Route::post('boostOrder', [OrderController::class, 'boostOrder']);

    });
    Route::group(['prefix' => 'bo'], function () {
        Route::get('login', [BOController::class, 'login']);
        Route::get('boInfo', [BOController::class, 'boInfo']);
        Route::post('deposit', [BOController::class, 'deposit']);
    });

    Route::group(['prefix' => 'casino'], function () {
        Route::get('gameInfo', [CasinoController::class, 'gameInfo']);
        Route::post('withdraw', [CasinoController::class, 'withdraw']);
        Route::post('withdrawCasinoProfit', [CasinoController::class, 'withdrawCasinoProfit']);
        Route::post('depositCasinoProfit', [CasinoController::class, 'depositCasinoProfit']);

    });
    Route::group(['prefix' => 'upload'], function () {
        Route::post('upload-file', [AttachmentController::class, 'uploadFile']);
    });

    Route::group(['prefix' => 'trade'], function () {
        Route::post('placeOrder', [TradeController::class, 'placeOrder']);

    });
});
