<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use App\OrderStatusHistory;
use App\Settings;
use App\Status;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function order_update($id)
    {
        $order = Order::find($id);
        $logs = OrderStatusHistory::where('order_id',$id)->orderBy('change_at','desc')->get();
        $status = Status::all();
        $settings = Settings::all()->first();
        if($settings == null){
            $settings =  new Settings();
            $settings->min_threshold_ship_out_date = 7;
            $settings->min_threshold_for_modify_ship_out_date = 5;
            $settings->max_threshold_for_modify_ship_out_date = 5;
            $settings->save();
        }
        return view('orders.update_orders')->with([
            'logs' => $logs,
            'order' => $order,
            'status' => $status,
            'settings' => $settings
        ]);
    }
    public function single_customer($id){
        $customer =Customer::find($id);
        return view('customers.single_customer',compact('customer'));
    }
}
