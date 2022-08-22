<?php

namespace App\Http\Controllers\Auth;

use App\AdminSetting;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use LicenseBoxAPI;
use Redirect;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login_check(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email',
            'password' => 'bail|required',
        ]);

        $userdata = array(
            'email' => $request->email,
            'password' => $request->password,
        );
        if (Auth::attempt($userdata)) {
            $license_code = AdminSetting::first()->license_code;
            $client_name = AdminSetting::first()->license_client_name;
            $api = new LicenseBoxAPI();
            $verify = $api->verify_license();

            if ($verify['status'] == true) {
                $set = AdminSetting::first();
                $set->license_status = 1;
                $set->save();
            } else {
                $set = AdminSetting::first();
                $set->license_status = 0;
                $set->save();
            }
            $license_status = AdminSetting::first()->license_status;
            if ($license_status == 1) {
                return redirect('/home');
            } else {
                return redirect('/setting');
            }
        } else {
            return Redirect::back()->withErrors(['Invalid Email or Passoword']);
        }
    }

    public function saveEnvData(Request $request)
    {
        $data['DB_HOST'] = $request->db_host;
        $data['DB_DATABASE'] = $request->db_name;
        $data['DB_USERNAME'] = $request->db_user;
        $data['DB_PASSWORD'] = $request->db_pass;

        $envFile = app()->environmentFilePath();

        if (is_writeable("../.env")) {

            $str = file_get_contents('../.env');
            if (count($data) > 0) {
                foreach ($data as $envKey => $envValue) {
                    $keyPosition = strpos($str, "{$envKey}=");
                    $endOfLinePosition = strpos($str, "\n", $keyPosition);
                    $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                    // If key does not exist, add it
                    if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                        $str .= "{$envKey}={$envValue}\n";
                    } else {
                        $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                    }
                }
            }
            $str = substr($str, 0, -1);
            if (!file_put_contents($envFile, $str)) {
                return response()->json(['data' => null, 'success' => false], 200);
            }
            Artisan::call('cache:clear');
            Artisan::call('config:clear');


            return response()->json(['data' => url('/login'), 'success' => true], 200);
        }
    }
    public function saveAdminData(Request $request)
    {
        $set = AdminSetting::first();
        $set->license_client_name = $request->client_name;
        $set->license_code = $request->license_code;
        $set->license_status = 1;
        $set->save();
        return response()->json(['data' => url('/login'), 'success' => true], 200);

    }
}
