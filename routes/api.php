<?php

use Illuminate\Http\Request;
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


Route::group(['prefix' => 'provider'], function () {
    Route::group(['namespace' => 'Admin'], function () {
        Route::get('noti/setting', 'AdminSettingController@apiNotiKey');

        Route::get('fuletype', 'FuelTypeController@apiIndex');
        Route::get('fuletype/{id}', 'FuelTypeController@subFuelType');
        Route::get('loadingtext', 'LoadingTextController@apiIndex');
        Route::get('setting', 'AdminSettingController@allSetting');
    });
    Route::group(['middleware' => ['auth:providerAuth']], function () {
        Route::get('notification', 'FuelProviderController@notification');
        Route::get('fuel/pricing', 'FuelProviderController@providerPricing');
        Route::get('booking/future', 'BookingMasterController@providerFutureBooking');
        Route::post('mackPayment', 'BookingMasterController@mackPayment');
        Route::get('booking', 'BookingMasterController@providerBooking');
        Route::post('booking', 'BookingMasterController@providerBookingDate');
        Route::get('booking/{id}/detail', 'BookingMasterController@singleBooking');
        Route::post('booking/{id}/update', 'BookingMasterController@bookingUpdate');
        Route::get('review', 'FuelProviderController@review');
        Route::post('fuel/pricing', 'FuelProviderController@providerPricingUpdate');
        Route::post('earning', 'BookingMasterController@earningStat');
        Route::get('fuel/pricing/{id}', 'FuelProviderController@providerPricingSingle');
        Route::delete('fuel/pricing/{id}','FuelProviderController@providerPricingDelete');


        Route::post('profile/update', 'AppUsersController@profileUpdate');
        Route::post('profile/password/update', 'AppUsersController@password');
        Route::post('profile/picture/update', 'AppUsersController@profilePictureUpdate');
        Route::post('newpassword', 'AppUsersController@newPassword');
        Route::get('profile', 'AppUsersController@profile');
    });
    Route::post('register', 'FuelProviderController@store');
    Route::post('login', 'FuelProviderController@login');
    Route::get('privacy', 'AppUsersController@privacy');
    Route::post('verifyMe', 'AppUsersController@verifyMe');
    Route::post('forgot', 'AppUsersController@forgot');
    Route::post('socialLogin', 'FuelProviderController@socialLogin');

    Route::post('forgot/validate', 'AppUsersController@forgotValidate');
});


Route::group(['prefix' => 'user'], function () {
    Route::group(['namespace' => 'Admin'], function () {
        Route::get('payment/setting', 'AdminSettingController@apiPaymentData');
        Route::get('noti/setting', 'AdminSettingController@apiNotiKey');
        Route::get('vehicleBrand', 'VehicleBrandController@apiIndex');
        Route::get('vehicleModel/{brand}', 'VehicleBrandController@getBrandModel');
        Route::get('loadingtext', 'LoadingTextController@apiIndex');
    });
    Route::group(['middleware' => ['auth:appUser']], function () {
        Route::post('profile/update', 'AppUsersController@profileUpdate');
        Route::post('profile/password/update', 'AppUsersController@password');
        Route::post('profile/picture/update', 'AppUsersController@profilePictureUpdate');
        Route::post('newpassword', 'AppUsersController@newPassword');
        Route::get('profile', 'AppUsersController@profile');
        Route::get('notification', 'AppUsersController@notification');
        Route::post('booking', 'BookingMasterController@store');
        Route::get('booking', 'BookingMasterController@userBooking');
        Route::post('booking/{id}/update', 'BookingMasterController@bookingUpdate');

        Route::post('mackPayment', 'BookingMasterController@mackPayment');
        Route::post('review', 'BookingMasterController@reviewStore');
        Route::get('booking/{id}', 'BookingMasterController@singleBooking');
        Route::post('vehicle', 'AppUsersController@newVehicleStore');
        Route::get('vehicle', 'AppUsersController@vehicleList');
        Route::post('vehicle/{id}/update', 'AppUsersController@vehicleListUpdate');
        Route::get('vehicle/{id}', 'AppUsersController@singleVehicle');
    });
    Route::get('privacy', 'AppUsersController@privacy');

    Route::post('home', 'AppUsersController@homeApi');
    Route::get('provider/{id}/{fuel}', 'AppUsersController@singleProvider');
    Route::post('register', 'AppUsersController@store');
    Route::post('verifyMe', 'AppUsersController@verifyMe');
    Route::post('login', 'AppUsersController@login');
    Route::post('forgot', 'AppUsersController@forgot');
    Route::post('socialLogin', 'AppUsersController@socialLogin');

    Route::post('forgot/validate', 'AppUsersController@forgotValidate');
});
