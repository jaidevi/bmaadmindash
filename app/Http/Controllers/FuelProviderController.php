<?php

namespace App\Http\Controllers;

use App\AdminSetting;
use App\FuelProvider;
use App\Http\Controllers\Admin\TwilioController;
use App\Notifications;
use App\ProviderPricing;
use App\Review;
use App\SubFuelType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Gate;
use Symfony\Component\HttpFoundation\Response;
class FuelProviderController extends Controller
{
    public function index()
    {
        //

        abort_if(Gate::denies('fuelProvider_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $provider =   FuelProvider::all();
        return view('admin.fuelProvider.index', compact('provider'));
    }
    public function changeStatus($id)
    {
        abort_if(Gate::denies('fuelProvider_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data =   FuelProvider::findOrFail($id);
        $data->status = $data->status === 1 ? 0  : 1;
        $data->update();
        return redirect()->back()->withStatus(__('Status Is changed.'));
    }
    public function show($id)
    {
        abort_if(Gate::denies('fuelProvider_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data =   FuelProvider::findOrFail($id);
        $data->load(['reviews','bookings','pricing']);
        // return $data;
        return view('admin.fuelProvider.show', compact('data'));

    }
    public function notification()
    {
        $data = Notifications::where('provider_id', Auth::id())->orderBy('created_at', "desc")->get();
        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }
    public function store(Request $request)
    {
        //
        $request->validate([
            'email' => 'bail|required|email|unique:fuel_provider,email',
            'name' => 'bail|required',
            'password' => 'bail|required|min:6',
            'phone_no' => 'bail|required|unique:fuel_provider,phone_no',
        ]);
        $reqData = $request->all();

        $app = AdminSetting::get(['id', 'verification', 'sms_gateway'])->first();
        $flow =    $app->verification == 1 ? 'verification' : 'home';
        if ($app->verification != 1) {
            $reqData['verified'] = 1;
        } else {
            try {
                $res = (new TwilioController)->sendOTPUser($request, $app->sms_gateway, 'verification', 1);  
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
        $data = FuelProvider::create($reqData);
        if ($app->verification != 1) {
            $token = $data->createToken('user')->accessToken;
            $data['token'] = $token;
        }
        return response()->json(['msg' => 'Welcome to the ' . env('APP_NAME'), 'data' => $data, 'success' => true, 'flow' => $flow], 200);
    }
    public function login(Request $request)
    {
        //
        $request->validate([
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:6',
        ]);
        $user = FuelProvider::where([['email', $request->email], ['provider', 'LOCAL']])->first();
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
            return response()->json(['msg' => 'Welcome back to ' . env('APP_NAME'), 'data' => $user, 'success' => true], 200);
        } else {
            return response()->json(['msg' => 'Email and Password not match with our record', 'data' => null, 'success' => false], 200);
        }
    }
    public function socialLogin(Request $request)
    {
        $user = FuelProvider::firstOrCreate(
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

        return response()->json(['msg' =>  $user['name'] . 'Welcome to ' . env('APP_NAME'), 'data' => $user, 'success' => true], 200);
    }
    public function providerPricingUpdate(Request $request)
    {

        $reqData = $request->all();
        $reqData['provider_id'] = Auth::id();
        $d = ProviderPricing::updateOrCreate(['fuel_type' => $request->fuel_type, 'provider_id' => Auth::id()], $reqData);
        return response()->json(['msg' => 'Price Added successfully', 'data' => null, 'success' => true], 200);
    }
    public function providerPricing()
    {

        $data =  ProviderPricing::where('provider_id', Auth::id())->get()->each->setAppends(['title']);

        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }
    public function providerPricingSingle($id)
    {
        
        $data =  ProviderPricing::find($id)->setAppends(['title']);
        $data['main_fuel_type'] = SubFuelType::find($data['fuel_type'])->fuel_type;
        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }
    public function providerPricingDelete($id)
    {
        
        ProviderPricing::find($id)->delete();

        return response()->json(['msg' => 'Delete Successfully', 'data' => null, 'success' => true], 200);
    }
    public function review()
    {
        $data =  Review::where('provider_id', Auth::id())->orderBy('created_at', 'desc')->get();

        return response()->json(['msg' => null, 'data' => $data, 'success' => true], 200);
    }
}
