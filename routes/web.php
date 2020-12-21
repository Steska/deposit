<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Web')->group(function () {
    Route::get('/', 'IndexController@index')->middleware('guest');
    Route::get('wallet/balance', 'WalletController@balanceForm')->middleware('dbAuth');
    Route::post('wallet/balance', 'WalletController@addBalance')->middleware('dbAuth');
    Route::get('deposit', 'DepositController@createDepositForm')->middleware('dbAuth');
    Route::post('deposit', 'DepositController@create')->middleware('dbAuth');
    Route::get('deposits', 'DepositController@getDeposits')->middleware('dbAuth');
    Route::get('transactions', 'TransactionController@getTransactions')->middleware('dbAuth');

    Route::get('registration', 'RegisterController@index')->middleware('guest');
    Route::post('register', 'RegisterController@register')->middleware('guest');
    Route::get('login', 'LoginController@index')->middleware('guest');
    Route::post('login', 'LoginController@login')->middleware('guest');

});

Route::get('/home', 'HomeController@index')->name('home')->middleware('dbAuth');;
