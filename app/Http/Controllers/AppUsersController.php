<?php

namespace App\Http\Controllers;

use App\AdminSetting;
use App\AppUsers;
use App\BookingMaster;
use App\FuelProvider;
use App\FuelType;
use App\Http\Requests\PasswordRequest;
use App\Notifications;
use App\ProviderPricing;
use App\Review;
use App\UserVehicle;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AppUsersController extends Controller
{

    public function index()
    {
        //

        abort_if(Gate::denies('appuser_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $appuser = AppUsers::all();
        return view('admin.appuser.index', compact('appuser'));
    }
    public function changeStatus($id)
    {
        abort_if(Gate::denies('appuser_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = AppUsers::findOrFail($id);
        $data->status = $data->status === 1 ? 0 : 1;
        $data->update();
        return redirect()->back()->withStatus(__('Status Is changed.'));
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:6',
        ]);
        $user = AppUsers::where([['email', $request->email], ['provider', 'LOCAL']])->first();
        if ($user && Hash::check($request->password, $user->password)) {
            if ($user['verified'] != 1) {
                return response()->json(['msg' => 'Please Verify your account', 'data' => null, 'success' => false, 'verification' => true], 200);
            }
            if ($user['status'] == 0) {
                return response()->json(['msg' => 'You are block by admin', 'data' => null, 'success' => false], 200);
            }
            $token = $user->createToken('user')->accessToken;
            $user['device_token'] = $request->device_token;
            $user->save();
            $user['token'] = $token;
            return response()->json(['msg' => 'Welcome back  ', 'data' => $user, 'success' => true], 200);
        } else {
            return response()->json(['msg' => 'Email and Password not match with our record', 'data' => null, 'success' => false], 200);
        }
    }
    public function store(Request $request)
    {
        //
        $request->validate([
            'email' => 'bail|required|email|unique:app_users,email',
            'name' => 'bail|required',
            'password' => 'bail|required|min:6',
            'phone_no' => 'bail|required|unique:app_users,phone_no',
        ]);
        $reqData = $request->all();

        $app = AdminSetting::get(['id', 'verification', 'sms_gateway'])->first();
        $flow = $app->verification == 1 ? 'verification' : 'home';
        if ($app->verification != 1) {
            $reqData['verified'] = 1;
        } else {
            try {
                $res = (new Admin\TwilioController)->sendOTPUser($request, $app->sms_gateway, 'verification', 0);
                if ($res['success'] === true) {
                    $reqData['otp'] = $res['otp'];
                    // $reqData['otp'] = '0000';
                }
            } catch (\Exception $e) {
                $reqData['verified'] = 1;
                $reqData['otp'] = '0000';
                //  dd($e->getMessage());
            }
        }

        $data = AppUsers::create($reqData);
        if ($app->verification != 1) {
            $token = $data->createToken('user')->accessToken;
            $data['token'] = $token;
        }
        return response()->json(['msg' => 'Welcome to' . env('APP_NAME'), 'data' => $data, 'success' => true, 'flow' => $flow], 200);
    }
    public function socialLogin(Request $request)
    {
        $user = AppUsers::firstOrCreate(
            ['provider_token' => $request->provider_token],
            $request->all()
        );
        if ($user['status'] == 0) {
            return response()->json(['msg' => 'You are block by admin', 'data' => null, 'success' => false], 200);
        }
        $token = $user->createToken('User')->accessToken;
        if (isset($request->device_token)) {

            $user['device_token'] = $request->device_token;
        }
        $user->save();
        $user['token'] = $token;

        return response()->json(['msg' => $user['name'] . 'Welcome to ' . env('APP_NAME'), 'data' => $user, 'success' => true], 200);
    }
    public function newPassword(Request $request)
    {
        $request->validate([
            'password' => 'bail|required|min:6',
        ]);
        auth()->user()->update($request->all());

        $data['token'] = auth()->user()->createToken('users')->accessToken;
        return response()->json(['msg' => 'Welcome back... ' . auth()->user()->name, 'data' => $data, 'success' => true], 200);
    }
    public function profileUpdate(Request $request)
    {

        auth()->user()->update($request->all());
        return response()->json(['msg' => 'Profile Updated', 'data' => null, 'success' => true], 200);
    }
    public function profile()
    {

        return response()->json(['msg' => null, 'data' => auth()->user(), 'success' => true], 200);
    }
    public function profilePictureUpdate(Request $request)
    {
        $name = (new AppHelper)->saveBase64($request->image);

        auth()->user()->update([
            'image' => $name,
        ]);
        return response()->json(['msg' => 'Profile Updated', 'data' => null, 'success' => true], 200);
    }
    public function simpleState()
    {
        $data = array();
        $data['booking'] = BookingMaster::where('user_id', Auth::id())->count();
        $data['review'] = Review::where('user_id', Auth::id())->count();
        $data['vehicle'] = UserVehicle::where('user_id', Auth::id())->count();
        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }
    public function notification()
    {
        $data = Notifications::where('user_id', Auth::id())->orderBy('created_at', "desc")->get();
        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }
    public function verifyMe(Request $request)
    {
        $request->validate([

            'phone_no' => 'bail|required',
        ]);
        if ($request->type == '1') {
            $userData = FuelProvider::Where([['phone_no', $request->phone_no]])->first();
        } else {

            $userData = AppUsers::Where([['phone_no', $request->phone_no]])->first();
        }

        if ($userData && $userData['verified'] === 1) {
            return response()->json(['msg' => 'You already verify ', 'data' => null, 'success' => false, 'redirect' => 'login'], 200);
        } else if ($userData && $userData['verified'] != 1) {

            if ($userData['otp'] === $request->OTP) {
                $userData->otp = '';
                $userData->verified = 1;
                $userData->save();
                $token = $userData->createToken('user')->accessToken;
                $userData['token'] = $token;
                return response()->json(['msg' => 'Thanks For being With us', 'data' => $userData, 'success' => true], 200);
            }

            return response()->json(['msg' => 'OTP is Invalid', 'data' => $userData, 'success' => false], 200);
        } else {
            return response()->json(['msg' => 'Email and number are attached with different account', 'data' => null, 'success' => false, 'redirect' => 'login'], 200);
        }
    }

    public function notiList()
    {
        $data = Notifications::where('user_id', Auth::user()->id)->get()->each->setAppends(['provider']);
        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }

    public function privacy()
    {
        $d = AdminSetting::first();
        return response()->json(['msg' => null, 'data' => $d->pp, 'success' => true], 200);
    }

    public function password(PasswordRequest $request)
    {
        // dd(auth()->user());
        auth()->user()->update(['password' => $request->get('password')]);
        $data['token'] = auth()->user()->createToken('user')->accessToken;
        return response()->json(['msg' => "Password Change", 'data' => $data['token'], 'success' => true], 200);
    }
    public function forgot(Request $request)
    {
        $request->validate([
            'phone_no' => 'bail|required',
            'type' => 'bail|required',
        ]);
        $app = AdminSetting::get(['id', 'verification', 'sms_gateway'])->first();
        if ($request->type == '1') {
            $userData = FuelProvider::Where([['phone_no', $request->phone_no], ['provider', 'LOCAL']])->first();
        } else {
            $userData = AppUsers::where([['phone_no', $request->phone_no], ['provider', 'LOCAL']])->first();
        }
        if ($userData) {

            $res = (new Admin\TwilioController)->sendOTPUser($request, $app->sms_gateway, 'forgot', $request->type);
            if ($res['success'] === true) {
                $reqData['otp'] = $res['otp'];
                $userData->update($reqData);
                return response()->json(['msg' => 'OTP send to your phone.', 'data' => null, 'success' => true], 200);
            } else {
                return response()->json(['msg' => 'Something went wrong.', 'data' => null, 'success' => false], 200);
            }
        }
        return response()->json(['msg' => 'You are not verified user.', 'data' => null, 'success' => false], 200);
    }
    public function forgotValidate(Request $request)
    {
        $request->validate([
            'phone_no' => 'bail|required',
            'type' => 'bail|required',
            'otp' => 'bail|required',
        ]);
        if ($request->type == '1') {
            $userData = FuelProvider::where([['phone_no', $request->phone_no], ['otp', $request->otp]])->first();
        } else {
            $userData = AppUsers::where([['phone_no', $request->phone_no], ['otp', $request->otp]])->first();
        }
        if ($userData) {
            $userData->update(['otp' => '']);
            $data['token'] = $userData->createToken('user')->accessToken;
            return response()->json(['msg' => 'OTP is verified.', 'data' => $data, 'success' => true], 200);
        }
        return response()->json(['msg' => 'Given OTP is invalid.', 'data' => null, 'success' => false], 200);
    }

    public function homeApi(Request $request)
    {
        $data = FuelProvider::where([['status', 1], ['verified', 1], ['is_online', 1]])->GetByDistance($request->lat, $request->lang, $request->radius)->get(['id', 'name', 'lat', 'lang', 'image']);

        foreach ($data as $value) {
            $value['fuel_type'] = ProviderPricing::where('provider_id', $value['id'])->get()->pluck('fuel_type');
            // $value['fuel_type'] = SubFuelType::whereIn('id', $t)->groupBy('fuel_type')->get()->pluck('fuel_type');

        }
        $master['provider'] = $data;
        $master['fuel_type'] = FuelType::with('subFuelType:id,name,fuel_type')->where('status', 1)->get();
        return response()->json(['msg' => null, 'data' => $master, 'success' => true], 200);
    }
    public function singleProvider($id, $fuel)
    {
        $data = FuelProvider::find($id, ['name', 'email', 'phone_no', 'is_featured', 'lat', 'lang', 'image']);
        $data['price'] = ProviderPricing::firstWhere([['provider_id', $id], ['fuel_type', $fuel]]);
        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }
    public function newVehicleStore(Request $request)
    {
        $reqData = $request->all();
        $reqData['user_id'] = Auth::id();
        $name = (new AppHelper)->saveBase64($request->image);
        $reqData['image'] = $name;
        UserVehicle::create($reqData);
        return response()->json(['msg' => 'Vehicle added successfully', 'data' => null, 'success' => true], 200);
    }
    public function vehicleListUpdate(Request $request, $id)
    {
        $data = UserVehicle::find($id);
        $reqData = $request->all();

        if (isset($request->image)) {

            $name = (new AppHelper)->saveBase64($request->image);
            $reqData['image'] = $name;
        }
        $data->update($reqData);
        return response()->json(['msg' => 'Vehicle update successfully', 'data' => null, 'success' => true], 200);
    }
    public function vehicleList()
    {

        $data = UserVehicle::with(['model.brand'])->where('user_id', Auth::id())->get();
        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }
    public function singleVehicle($id)
    {
        $data = UserVehicle::with(['model.brand'])->where('id', $id)->first();
        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }
}
