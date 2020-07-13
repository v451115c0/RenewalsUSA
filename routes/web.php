<?php

Route::get('renewals/', "renewals\RenewalsController@index");

Route::post('renewals/charge', "renewals\RenewalsController@charge");

Route::get('renewals/email/', function(){
    return view("renewals/emails/email");
});