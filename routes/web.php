<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login/check', [LoginController::class, 'login_check']);
Route::post('/saveEnvData', [LoginController::class, 'saveEnvData']);
Route::post('/saveAdminData', [LoginController::class, 'saveAdminData']);

// review dashborard
Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('booking', 'BookingMasterController@index')->name('booking');
    Route::group(['namespace' => 'Admin'], function () {
        Route::get('/home', 'PaymentTransactionController@dashboard')->name('home');

        Route::get('earning', 'PaymentTransactionController@index')->name('earning.index');

        Route::get('report', 'PaymentTransactionController@randomReportIndex')->name('report.index');
        Route::post('report', 'PaymentTransactionController@randomReportGenerate')->name('reportGenerate');
        Route::post('earning', 'PaymentTransactionController@index')->name('earning.filter');
        Route::post('earning/show', 'PaymentTransactionController@show')->name('earning.show');
        Route::post('earning/settle', 'PaymentTransactionController@settle')->name('earning.settle');

        Route::resources([
            'roles' => 'RolesController',
            'users' => 'UsersController',
            'fueltype' => 'FuelTypeController',
            'subfueltype' => 'SubFuelTypeController',
            'vehicleBrand' => 'VehicleBrandController',
            'vehicleModel' => 'VehicleModelController',
            'notification' => 'StaticNotiController',
            'loadingtext' => 'LoadingTextController',

        ]);
        Route::get('pp', 'AdminSettingController@pp')->name('pp');
        Route::get('review', 'AdminSettingController@allReview')->name('review');
        Route::post('pp/update', 'AdminSettingController@updatePP')->name('pp.update');
        Route::post('twilio/update', 'TwilioController@updateTwilio')->name('twilio.update');
        Route::post('onesignal', 'StaticNotiController@updateOnesignl')->name('onesignal.update');
        Route::post('base', 'AdminSettingController@updateBase')->name('base.update');
        Route::post('license', 'AdminSettingController@updateLicense')->name('license.update');
        Route::post('stripe', 'StripeController@updateStripe')->name('stripe.update');
        Route::post('paypal', 'PaypalController@updatePaypal')->name('paypal.update');
        Route::post('razor', 'RazorController@updatePaypal')->name('razor.update');
        // module
        Route::get('setting', 'AdminSettingController@index')->name('setting.index');
        Route::post('setting/basic', 'AdminSettingController@basicUpdate')->name('setting.basic');
        Route::get('custom/notification', 'StaticNotiController@customIndex')->name('custom.index');
        Route::post('custom/notification/user', 'StaticNotiController@customUser')->name('custom.user');
    });
    Route::get('appuser', 'AppUsersController@index')->name('appuser.index');
    Route::post('appuser/status/{id}', 'AppUsersController@changeStatus')->name('appuser.statusChange');
    Route::get('provider', 'FuelProviderController@index')->name('provider.index');
    Route::get('provider/{id}', 'FuelProviderController@show')->name('provider.show');
    Route::post('provider/status/{id}', 'FuelProviderController@changeStatus')->name('provider.statusChange');
});
Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', 'UserController', ['except' => ['show']]);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});
