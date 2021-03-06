<?php
/*********************************************************************************
 *  PhpStorm - phpad
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By phpad
 * 用户中心路由控制
 *-------------------------------------------------------------------------------
 * $FILE:Account.php
 * $Author:zxs
 * $Dtime:2016/9/11
 ***********************************************************************************/
Route::get('register/protocol.html', ['as' => 'passport', 'uses' => 'PassportController@protocol']);
Route::match(['get', 'post'], 'signin/captcha', ['as' => 'passport', 'uses' => 'PassportController@captcha']);

Route::post('common/sendVerifyCode', ['as' => 'passport', 'uses' => 'PassportController@sendVerifyCode']);
//手机找回密码
Route::match(['get', 'post'], 'findpassword.html', ['as' => 'passport', 'uses' => 'PassportController@findPassword']);
Route::any('findpassword/resetByPhone.html', ['as' => 'passport', 'uses' => 'PassportController@resetByPhone']);
Route::match(['get', 'post'], 'findpassword/doresetpasswordphone.html', ['as' => 'passport', 'uses' => 'PassportController@doresetpasswordphone']);
//邮箱找回密码
Route::any('findpassword/resetByEmail.html', ['as' => 'passport', 'uses' => 'PassportController@resetByEmail']);
Route::match(['get', 'post'], 'findpassword/checkEmailRegisted.html', ['as' => 'passport', 'uses' => 'PassportController@checkEmailRegisted']);
Route::get('findpassword/resetpasswordemail/{token}.html', ['as' => 'passport', 'uses' => 'PassportController@setPassowrdByEmail']);
Route::match(['get', 'post'], 'findpassword/doResetPasswordEmail.html', ['as' => 'passport', 'uses' => 'PassportController@complete']);

Route::group(['middleware' => 'middle.account'], function () {
    Route::match(['get', 'post'], 'signin.html', ['as' => 'passport', 'uses' => 'PassportController@signin']);
    Route::match(['get', 'post'], 'register.html', ['as' => 'passport', 'uses' => 'PassportController@register']);
    Route::get('signout.html', ['as' => 'passport', 'uses' => 'PassportController@signout']);

    Route::get('/', ['as' => 'index', 'uses' => 'HomeController@index']);
    //投资记录
    Route::get('networth/index.html', ['as' => 'networth', 'uses' => 'NetworthController@index']);
    Route::any('networth/create/{id}', ['as' => 'networth.create', 'uses' => 'NetworthController@create']);
    Route::any('networth/show/{id}', ['as' => 'networth.show', 'uses' => 'NetworthController@show']);
    Route::any('networth/delete/{id}', ['as' => 'networth.delete', 'uses' => 'NetworthController@delete']);
    //平台
    Route::get('platforms/statistic.html', ['as' => 'platform', 'uses' => 'PlatformController@statistic']);
    Route::get('platforms/analysis.html', ['as' => 'platform', 'uses' => 'PlatformController@analysis']);
    //账号充值
    Route::match(['get', 'post'], 'wallet/withdraw.html', ['as' => 'wallet.withdraw', 'uses' => 'WalletController@withdraw']);
    Route::get('wallet/withdrawlist.html', ['as' => 'wallet.withdrawlist', 'uses' => 'WalletController@withdrawlist']);
    Route::get('wallet/record.html', ['as' => 'wallet.record', 'uses' => 'WalletController@record']);
    //记帐本
    Route::get('book.html', ['as' => 'record.index', 'uses' => 'BookController@index']);
    Route::any('book/create/{id?}', ['as' => 'book.create', 'uses' => 'BookController@create']);
    Route::get('book/delete/{id}', ['as' => 'book.delete', 'uses' => 'BookController@delete']);
    Route::post('book/template/delete/{id}', ['as' => 'book.template.delete', 'uses' => "BookController@deletetemplate"]);
    Route::get('book/template/{id}', ['as' => 'book.template', 'uses' => 'BookController@template']);
    Route::post('book/stats', ['as' => 'book.stats', 'uses' => 'BookController@stats']);
    //账户管理
    Route::get('safe.html', ['as' => 'safe', 'uses' => 'AccountController@safe']);
    Route::match(['get', 'post'], 'safe/changeNickname.html', ['as' => 'safe.changeNickname', 'uses' => 'AccountController@changenickname']);
    Route::match(['get', 'post'], 'safe/changeTelephone.html', ['as' => 'safe.changeTelephone', 'uses' => 'AccountController@changetelephone']);
    Route::match(['get', 'post'], 'safe/validateEmail.html', ['as' => 'safe.validateEmail', 'uses' => 'AccountController@validateemail']);
    Route::match(['get', 'post'], 'safe/changeEmailByTelephone.html', ['as' => 'safe.changeEmailByTelephone', 'uses' => 'AccountController@changeEmailByTelephone']);
//    Route::match(['get', 'post'], 'safe/validIdCard.html', ['as' => 'safe.validIdCard', 'uses' => 'AccountController@validcard']);
    Route::match(['get', 'post'], 'safe/changePassword.html', ['as' => 'safe.changePassword', 'uses' => 'AccountController@changepassword']);
    Route::match(['get', 'post'], 'safe/setDealPassword.html', ['as' => 'safe.setDealPassword', 'uses' => 'AccountController@setdealpassword']);
    Route::match(['get', 'post'], 'safe/changeDealPassword.html', ['as' => 'safe.changeDealPassword', 'uses' => 'AccountController@dealpassword']);
    Route::match(['get', 'post'], 'safe/finddealpassword.html', ['as' => 'safe.finddealpassword', 'uses' => 'AccountController@findpassword']);
//    Route::match(['get', 'post'], 'safe/setSecurityQuestion.html', ['as' => 'safe.setSecurityQuestion', 'uses' => 'AccountController@question']);
    Route::match(['get', 'post'], 'bankcard.html', ['as' => 'safe', 'uses' => 'AccountController@bankcard']);
    Route::match(['get', 'post'], 'bankcard/update.html', ['as' => 'safe.bankcard', 'uses' => 'AccountController@updatebcard']);
    //活动专区
//    Route::get('activity/recommend.html', ['as' => 'activity.recommend', 'uses' => 'ActivityController@recommend']);
//    Route::get('shop.html', ['as' => 'shop', 'uses' => 'ActivityController@shop']);
    //理财劵
//    Route::get('coupon/index.html', ['as' => 'coupon', 'uses' => 'CouponController@index']);
    //消息中心
    Route::get('message.html', ['as' => 'message', 'uses' => 'MessageController@index']);
    Route::post('message/readAll.html', ['as' => 'message.readAll', 'uses' => 'MessageController@readAll']);
    Route::post('message/deleteAll.html', ['as' => 'message.deleteAll', 'uses' => 'MessageController@deleteAll']);
    //我的积分
    Route::get('user/scores.html', ['as' => 'scores', 'uses' => 'ScoresController@index']);
    //统计
    Route::get('chart/waitIncomeStats', ['as' => 'charts.income', 'uses' => 'ChartController@waitIncomeStats']);
    Route::get('chart/incomeStats', ['as' => 'charts.halfyear', 'uses' => 'ChartController@incomeStats']);
    //签到
    Route::get('shop/signin', ['as' => 'shop.signin', 'uses' => 'AccountController@signin']);
});
