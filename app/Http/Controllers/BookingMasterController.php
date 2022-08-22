<?php

namespace App\Http\Controllers;

use App\AdminSetting;
use App\BookingMaster;
use App\PaymentTransaction;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingMasterController extends Controller
{
    //
    public function index()
    {

        $data =  BookingMaster::with(['user:id,name', 'provider:id,name'])->get();
        return view('admin.booking.index', compact('data'));
    }
    public function store(Request $request)
    {
        // BookingMaster
        $request->validate([
            'provider_id' => 'bail|required',
            'address' => 'bail|required',
            'fuel_type' => 'bail|required',
            'time' => 'bail|required',
            'vehicle_id' => 'bail|required',
            'price' => 'bail|required',
            'discount' => 'bail|required',
            // 'payment_status' => 'bail|required',
            // 'payment_method' => 'bail|required',
            'lat' => 'bail|required',
            'lang' => 'bail|required',
        ]);
        $reqData = $request->all();
        $reqData['user_id'] = Auth::id();
        $reqData['admin_per'] = AdminSetting::first()->admin_per;

        $reqData['order_id'] = substr(uniqid('bhk-'), 0, 10);
        $data = BookingMaster::create($reqData);

        $ids['user_id'] = $data['user_id'];
        $ids['provider_id'] = $data['provider_id'];
        $ids['time'] = $data['time'];
        $ids['bid'] = $data['id'];
        $ids['order_id'] = $data['order_id'];
        $ids['address'] = $data['address'];
        $ids['fuel_type'] = $data['fuel_type'];
        try {
            $res = (new Admin\StaticNotiController)->baseNotification($ids, 2);
            //code...
        } catch (\Throwable $th) {
            throw $th;
        }

        return response()->json(['msg' => 'Your Booking is arrived , wait  for confirmation', 'data' => null, 'success' => true], 200);
    }
    public function userBooking()
    {
        $master['future'] = BookingMaster::with(['provider:id,name,image', 'model:id,reg_number,model_id', 'model.model.brand'])->where([['user_id', Auth::id()], ['status', '<', 3]])->get(['id', 'time', 'price', 'qty', 'provider_id', 'status', 'address', 'vehicle_id', 'order_id', 'created_at', 'lat', 'lang']);
        $master['past'] = BookingMaster::with(['provider:id,name,image', 'model:id,reg_number,model_id', 'model.model.brand'])->where([['user_id', Auth::id()], ['status', '>=', 3]])->get(['id', 'time', 'price', 'qty', 'provider_id', 'status', 'address', 'vehicle_id', 'order_id', 'created_at', 'lat', 'lang']);

        return response()->json(['msg' => null, 'data' => $master, 'success' => true], 200);
    }
    public function singleBooking($id)
    {
        $master = BookingMaster::with(['user:id,name,image','provider:id,name,image', 'model.model.brand', 'review'])->where('id', $id)->get()->first();
        return response()->json(['msg' => null, 'data' => $master, 'success' => true], 200);
    }
    public function reviewStore(Request $request)
    {

        $request->validate([
            'provider_id' => 'bail|required',

            'booking_id' => 'bail|required',
            'star' => 'bail|required|numeric|min:1|max:5',
        ]);
        $reqData = $request->all();
        $reqData['user_id'] = Auth::user()->id;
        Review::create($reqData);
        return response()->json(['msg' => 'Thanks for review', 'data' => null, 'success' => true], 200);
    }

    public function providerFutureBooking()
    {
        $master = BookingMaster::with(['user:id,name,image', 'model:id,reg_number,model_id', 'model.model.brand'])->where([['provider_id', Auth::id()], ['status', '<', 3]])->get(['id', 'time', 'provider_id', 'status', 'address', 'vehicle_id', 'order_id', 'created_at', 'user_id', 'price', 'qty', 'payment_status','lat','lang']);
        return response()->json(['msg' => null, 'data' => $master, 'success' => true], 200);
    }

    public function providerBooking()
    {
        $master = BookingMaster::with(['user:id,name,image', 'model:id,reg_number,model_id', 'model.model.brand'])->where([['provider_id', Auth::id()]])->get(['id', 'time', 'provider_id', 'status', 'address', 'vehicle_id', 'order_id', 'created_at', 'user_id', 'price', 'qty', 'payment_status', 'lat', 'lang']);
        return response()->json(['msg' => null, 'data' => $master, 'success' => true], 200);
    }
    public function providerBookingDate(Request $request)
    {
        if ($request->from == $request->to) {
            $master = BookingMaster::with(['user:id,name,image', 'model:id,reg_number,model_id', 'model.model.brand'])->whereDate('time', $request->from)->where([['provider_id', Auth::id()]])->get(['id', 'time', 'provider_id', 'status', 'address', 'vehicle_id', 'order_id', 'created_at', 'user_id', 'price', 'qty', 'payment_status', 'lat', 'lang']);
        } else {
            $master = BookingMaster::with(['user:id,name,image', 'model:id,reg_number,model_id', 'model.model.brand'])->whereBetween('time', [$request->from, $request->to])->where([['provider_id', Auth::id()]])->get(['id', 'time', 'provider_id', 'status', 'address', 'vehicle_id', 'order_id', 'created_at', 'user_id', 'price', 'qty', 'payment_status', 'lat', 'lang']);
        }

        return response()->json(['msg' => null, 'data' => $master, 'success' => true], 200);
    }
    public function bookingUpdate($id, Request $request)
    {
        $data = BookingMaster::find($id);
        $data->update($request->all());

        $ids['user_id'] = $data['user_id'];
        $ids['provider_id'] = $data['provider_id'];
        $ids['time'] = $data['time'];
        $ids['bid'] = $data['id'];
        $ids['order_id'] = $data['order_id'];
        $ids['address'] = $data['address'];
        $ids['fuel_type'] = $data['fuel_type'];
        try {
            if ($request->status == '1') {
                $res = (new Admin\StaticNotiController)->baseNotification($ids, 3);
            }
            if ($request->status == '4') {
                $res = (new Admin\StaticNotiController)->baseNotification($ids, 11);
            }
            if ($request->status == '6') {
                $res = (new Admin\StaticNotiController)->baseNotification($ids, 6);
            }
            if ($request->status == '3') {
                $res = (new Admin\StaticNotiController)->baseNotification($ids, 9);
            }
            //code...
        } catch (\Throwable $th) {
            //  throw $th;
        }




        return response()->json(['msg' => null, 'data' => null, 'success' => true], 200);
    }
    public function earningStat(Request $request)
    {
        if ($request->from == $request->to) {
            $master = BookingMaster::with(['user:id,name,image'])->where([['provider_id', Auth::id()], ['status', '=', 3]])->whereDate('time', $request->from)->get(['id', 'time', 'provider_id', 'status', 'address', 'vehicle_id', 'order_id', 'created_at', 'user_id', 'price', 'qty',]);
        } else {
            $master = BookingMaster::with(['user:id,name,image'])->where([['provider_id', Auth::id()], ['status', '=', 3]])->whereBetween('time', [$request->from, $request->to])->get(['id', 'time', 'provider_id', 'status', 'address', 'vehicle_id', 'order_id', 'created_at', 'user_id', 'price', 'qty',]);
        }

        return response()->json(['msg' => null, 'data' => $master, 'success' => true], 200);
    }
    public function mackPayment(Request $request)
    {
        $data = BookingMaster::find($request->id);
        $data->update($request->all());
        $ids['user_id'] = $data['user_id'];
        $ids['provider_id'] = $data['provider_id'];
        $ids['time'] = $data['time'];
        $ids['bid'] = $data['id'];
        $ids['order_id'] = $data['order_id'];
        $ids['address'] = $data['address'];
        $ids['fuel_type'] = $data['fuel_type'];
        try {
            if ($request->status == '3') {
                $res = (new Admin\StaticNotiController)->baseNotification($ids, 9);
            }
            if ($request->payment_status == '1' && $data['payment_method']  !== 'Stripe') {
                $res = (new Admin\StaticNotiController)->baseNotification($ids, 10);
            }

            //code...
        } catch (\Throwable $th) {
            //  throw $th;
        }

        if ($data['payment_method']  === 'Stripe') {
            $cur = AdminSetting::first()->currency;
            try {
                $res = (new Admin\StripeController)->makePayment($data['price'], $data['payment_token'], $cur);
                if ($res['status']) {
                    $data->update(['payment_token' => $res['charge_id']]);
                    $res = (new Admin\StaticNotiController)->baseNotification($ids, 10);
                } else {
                    return response()->json(['msg' => 'Something went wrong.', 'data' => $data, 'success' => false], 200);
                }
            } catch (\Throwable $th) {
                throw $th;
                return response()->json(['msg' => 'Something went wrong.', 'data' => $data, 'success' => false], 200);
            }
        }
        $reqData = array();
        $reqData['admin_share'] = ($data['admin_per'] / 100) *  $data['price'];
        $reqData['provider_share'] = $data['price'] - $reqData['admin_share'];
        $reqData['provider_id'] =  $data['provider_id'];
        $reqData['booking_id'] = $data['id'];
        $reqData['payment'] = $data['payment_method'] === 'offline' ? 1 : 0;
        PaymentTransaction::create($reqData);
        return response()->json(['msg' => 'Payment successfully received.', 'data' => $data, 'success' => true], 200);
    }
}
