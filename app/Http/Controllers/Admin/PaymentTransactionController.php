<?php

namespace App\Http\Controllers\Admin;

use App\AdminSetting;
use App\AppUsers;
use App\BookingMaster;
use App\FuelProvider;
use App\FuelType;
use App\Http\Controllers\Controller;
use App\PaymentTransaction;
use App\Review;
use App\SubFuelType;
use Carbon\Carbon;
use DB;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PaymentTransactionController extends Controller
{
    //
    public function index(Request $request)
    {
        abort_if(Gate::denies('earning_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $st = Carbon::parse('01/02/2020');
        $et = Carbon::today();
        $intr = 15;
        $length = $st->diffInDays($et);
        $loop = $length / $intr;
        $loop = (int) floor($loop);
        $master = array();
        for ($i = 0; $i < $loop; $i++) {
            $temp = array();
            $temp['start_date'] = $st->toDateString();
            $st->addDays($intr);
            $temp['end_date'] = $st->toDateString();
            array_push($master, $temp);
            $st->addDay();
        }
        $temp['start_date'] = $st->toDateString();
        $temp['end_date'] = $et;
        array_push($master, $temp);
        $temp = $master = array_reverse($master);
        if ($request->has('index')) {
            $temp = $master[$request->index];

            $earingD = PaymentTransaction::whereBetween('created_at', [$temp['start_date'], $temp['end_date']])->with('provider:id,name')->groupBy('provider_id')->get(['id', 'provider_id', 'created_at']);
        } else {
            $earingD = PaymentTransaction::with('provider:id,name')->groupBy('provider_id')->get(['id', 'provider_id', 'created_at']);
        }

        foreach ($earingD as $value) {
            $pt = PaymentTransaction::where('provider_id', $value['provider_id'])->get();
            $value['d_total_task'] = $pt->count();
            $value['d_admin_share'] = $pt->sum('admin_share');
            $value['d_provider_share'] = $pt->sum('provider_share');
            $value['d_total_amount'] = $value['d_admin_share'] + $value['d_provider_share'];

            $remainingOnline = PaymentTransaction::where([['provider_id', $value['provider_id']], ['shattle', 0], ['payment', 0]])->get();

            $remainingOffline = PaymentTransaction::where([['provider_id', $value['provider_id']], ['shattle', 0], ['payment', 1]])->get();

            $online = $remainingOnline->sum('provider_share'); // admin e devana
            $offline = $remainingOffline->sum('admin_share'); // admin e levana

            $value['d_balance'] = $offline - $online; // + hoy to levana  - devana
            $value['d_online'] = $online; // + hoy to levana  - devana
            $value['d_offline'] = $offline; // + hoy to levana  - devana
        }
// return ($earingD);

        return view('admin.earning.index', compact(['earingD', 'master']));
    }

    public function show(Request $request)
    {

        abort_if(Gate::denies('earning_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $provider = FuelProvider::find($request->provider_id);
        $provider->setAppends(['currency']);
        $earning = array();
        $pt = PaymentTransaction::where('provider_id', $request->provider_id)->get();

        foreach ($pt as $value) {
            $pb = BookingMaster::find($value['booking_id']);
            // $pb->load(['category:id,name', 'service:id,name']);
            $value['bookingData'] = $pb;
        }

        $earning['data'] = $pt;
        $earning['d_total_task'] = $pt->count();
        $earning['d_admin_share'] = $pt->sum('admin_share');
        $earning['d_provider_share'] = $pt->sum('provider_share');
        $earning['d_total_amount'] = $earning['d_admin_share'] + $earning['d_provider_share'];

        $remainingOnline = PaymentTransaction::where([['provider_id', $request->provider_id], ['shattle', 0], ['payment', 0]])->get();

        $remainingOffline = PaymentTransaction::where([['provider_id', $request->provider_id], ['shattle', 0], ['payment', 1]])->get();

        $online = $remainingOnline->sum('provider_share'); // admin e devana
        $offline = $remainingOffline->sum('admin_share'); // admin e levana

        $earning['d_admin_to_provider'] = $online;
        $earning['d_provider_to_admin'] = $offline;

        $earning['d_balance'] = $offline - $online; // + hoy to levana  - devana
        return view('admin.earning.show', compact(['earning', 'provider']));
    }
    public function settle(Request $request)
    {
        abort_if(Gate::denies('earning_settle'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        PaymentTransaction::where([['provider_id', $request->provider_id], ['shattle', 0]])->update(['shattle' => 1]);
        return redirect()->route('earning.index')->withStatus(__('Payment are settle to paid'));
    }

    public function dashboard(Request $request)
    {
        abort_if(Gate::denies('dashboard'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $master = array();
        $master['currency'] = AdminSetting::first()->currency_symbol;
        $master['all_user'] = AppUsers::all()->count();

        $master['all_provider'] = FuelProvider::all()->count();
        $master['sub_fuel_type'] = SubFuelType::all()->count();
        $master['fuel_type'] = FuelType::all()->count();
        $master['review_count'] = Review::all()->count();

        $master['all_booking'] = BookingMaster::all()->count();
        $master['today_booking'] = BookingMaster::whereDate('created_at', Carbon::today())->get()->count();

        // $pt =  PaymentTransaction::all();
        // $master['total'] = $pt->sum('admin_share') + $pt->sum('provider_share');
        // $master['admin'] = $pt->sum('admin_share');
        // $master['online'] = collect($pt)->where('payment', 0)->count();
        // $master['offline'] = collect($pt)->where('payment', 1)->count();
        // $ptt =  PaymentTransaction::whereDate('created_at', Carbon::today())->get();
        // $master['today_total'] = $ptt->sum('admin_share') + $pt->sum('provider_share');
        // $master['today_admin'] = $ptt->sum('admin_share');
        // $master['today_online'] = collect($ptt)->where('payment', 0)->count();
        // $master['today_offline'] = collect($ptt)->where('payment', 1)->count();

        $book = BookingMaster::get();
        $total = $book->count();
        $master['book_total'] = $book->count();
        $master['waiting'] = collect($book)->where('status', 0)->count();
        $master['book_ongoing'] = collect($book)->where('status', 1)->count() + collect($book)->where('status', 2)->count();
        $master['book_complete'] = collect($book)->where('status', 3)->count();
        $master['book_rejected'] = collect($book)->where('status', 6)->count() + collect($book)->where('status', 4)->count();

        try {
            $master['waiting_per'] = round(($master['waiting'] * 100) / $total);
            $master['book_ongoing_per'] = round(($master['book_ongoing'] * 100) / $total);
            $master['book_complete_per'] = round(($master['book_complete'] * 100) / $total);
            $master['book_rejected_per'] = round(($master['book_rejected'] * 100) / $total);
        } catch (\Throwable $th) {
            $master['waiting_per'] = 0;
            $master['book_ongoing_per'] = 0;
            $master['book_complete_per'] = 0;
            $master['book_rejected_per'] = 0;
        }

        return view('dashboard', compact(['master']));
    }

    public function randomReportIndex()
    {
        abort_if(Gate::denies('report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $provider = FuelProvider::all();
        $req = array();
        $req['provider'] = 'provider';
        $req['payment'] = 'all';
        $req['status'] = 'all';
        return view('admin.report.index', compact(['provider', 'req']));
    }
    public function randomReportGenerate(Request $request)
    {
        abort_if(Gate::denies('report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fd = $request->from . " 00:00:00";
        $td = $request->to . " 00:00:00";

        $data = DB::select("select * from `payment_transaction` where (`provider_id` = $request->provider and `payment` = $request->payment and `shattle` = $request->status) and `created_at` between '$fd' and '$td'");

        $master = array();
        foreach ($data as $value) {
            $bhk = BookingMaster::find($value->booking_id);
            $bhk->load('provider');
            $temp['job_id'] = $bhk['booking_id'];
            $temp['job_date'] = $bhk['created_at']->format('Y-m-d');
            $temp['provider_name'] = $bhk['provider']['name'];
            $temp['total'] = $value->admin_share + $value->provider_share;
            $temp['admin_share'] = $value->admin_share;
            $temp['provider_share'] = $value->provider_share;
            $temp['payment_type'] = $value->payment;
            $temp['paid'] = $value->payment;
            $date = Carbon::parse($value->created_at);
            $temp['time'] = $date->format('Y-m-d');
            array_push($master, $temp);
        }
        $provider = FuelProvider::all();
        $req = $request->all();
        $req['currency'] = AdminSetting::first()->currency_symbol;
        return view('admin.report.index', compact(['provider', 'master', 'req']));
        // return $master;
        // return PaymentTransaction::with(['provider:id,name', 'booking:id,booking_id,created_at'])->where([['provider_id', $request->provider], ['payment', $request->payment], ['shattle', $request->status]])->whereBetween('created_at', array($request->from . " 00:00:00", $request->to . " 00:00:00"))->get();
        // dd($request->all());
    }
}
