<?php

namespace App\Http\Controllers\Admin;

use App\AdminSetting;
use App\AppUsers;
use App\BookingMaster;
use App\FuelProvider;
use App\Http\Controllers\Controller;
use App\Notifications;
use App\OwnerShop;
use App\ShopEmployee;
use App\ShopOwner;
use App\StaticNoti;
use Gate;
use Illuminate\Http\Request;
use OneSignal;
use Symfony\Component\HttpFoundation\Response;

class StaticNotiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if ($d = '') {
        } elseif ($d = "") {
        }
        abort_if(Gate::denies('notification_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $notis = StaticNoti::all();
        return view('admin.staticNotification.index', compact(['notis']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StaticNoti  $staticNoti
     * @return \Illuminate\Http\Response
     */
    public function show(StaticNoti $staticNoti)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StaticNoti  $staticNoti
     * @return \Illuminate\Http\Response
     */
    public function edit(StaticNoti $staticNoti)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StaticNoti  $staticNoti
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        abort_if(Gate::denies('notification_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        StaticNoti::find($id)->update($request->all());
        return back()->withStatus(__('Notification updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StaticNoti  $staticNoti
     * @return \Illuminate\Http\Response
     */
    public function destroy(StaticNoti $staticNoti)
    {
        //
    }
    public function customIndex()
    {
        abort_if(Gate::denies('custom_notification_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = AppUsers::all();

        return view('admin.customNotification.index', compact(['users']));
    }
    public function customUser(Request $request)
    {
        abort_if(Gate::denies('custom_notification_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tag = ['{{user_name}}'];

        $users = AppUsers::whereIn('id', $request->users)->where('device_token', '!=', null)->get(['name', 'id', 'device_token']);

        $title = $request->title;
        $sub_title = $request->sub_title;
        foreach ($users as $value) {
            # code...
            $replace = array($value['name']);
            $new_title = $this->tagReplace($title, $tag, $replace);
            $new_sub_title = $this->tagReplace($sub_title, $tag, $replace);

            if ($value['device_token']) {
                $this->oneplus($value['device_token'], $new_sub_title, $new_title);
            }
        }
        return back()->withStatus(__('Notification send successfully'));
    }

    private function tagReplace($string, $tag, $replace)
    {
        $new = str_replace($tag, $replace, $string);
        return $new;
    }

    public function baseNotification($ids, $type)
    {
        $u = AppUsers::find($ids['user_id']);
        $e = "";
        $o = "";
        if (AdminSetting::first()->notification == 0) {
            return false;
        }
        $noti = StaticNoti::find($type);
        $un = $u->name;
        $en = "";
        $on = "";


        // $ids['time'] = $data['time'];
        // $ids['bid'] = $data['id'];

        $booking = BookingMaster::find($ids['bid']);


        $bd = $booking['time'];
        $bi = $booking['order_id'];
        $add = $booking['address'];
        $ft = $booking['fuel_type'];
        if (isset($ids['provider_id'])) {
            $e = FuelProvider::find($ids['provider_id']);
            $en = $e->name;
        }

        $tag = ['{{user_name}}', '{{provider_name}}', '{{request_date}}', '{{booking_id}}', '{{fuel_type}}', '{{user_address}}'];
        $replace = [$un, $en, $bd, $bi, $ft, $add];
        $new_title = str_replace($tag, $replace, $noti->title);
        $new_sub_title = str_replace($tag, $replace, $noti->sub_title);

        if ($noti->for_who == 0) {
            // user
            Notifications::create([
                'booking_id' => $ids['bid'],
                'user_id' => $ids['user_id'],

                'title' => $new_title,
                'sub_title' => $new_sub_title,
            ]);

            if (isset($u->device_token) && $u->noti == 1) {
                $this->oneplus($u->device_token, $new_sub_title, $new_title);
            }
        } else if ($noti->for_who == 1) {
            //oenre
            Notifications::create([
                'booking_id' => $ids['bid'],

                'provider_id' => $ids['provider_id'],

                'title' => $new_title,
                'sub_title' => $new_sub_title,
            ]);
            if (isset($e->device_token) && $e->noti == 1) {
                $this->oneplus($e->device_token, $new_sub_title, $new_title);
            }
        }
        // dd($new_title, $new_sub_title);
    }
    public function oneplus($userid, $sub, $header)
    {
        try {
            OneSignal::sendNotificationToUser(
                $sub,
                $userid,
                $url = null,
                $data = null,
                $buttons = null,
                $schedule = null,
                $headings = $header
            );
        } catch (\Throwable $th) {
            // throw $th;
        }
    }
    public function updateOnesignl(Request $request)
    {
        $data = [
            'APP_ID' => $request->APP_ID,
            'REST_API_KEY' => $request->REST_API_KEY,
            'USER_AUTH_KEY' => $request->USER_AUTH_KEY,
            'PROJECT_NUMBER' => $request->PROJECT_NUMBER,
        ];
        //  country_code
        try {
            (new AdminSettingController)->updateENV($data);
        } catch (\Throwable $th) {
            dd($th);
        }

        // return "true";
        return redirect('setting')->withStatus(__('Onesignal Configuration updated successfully.'));
    }
}
