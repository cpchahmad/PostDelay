<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use App\OrderStatusHistory;
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
        return view('orders.update_orders')->with([
            'logs' => $logs,
            'order' => $order,
            'status' => $status
        ]);
    }
    public function single_customer($id){
        $customer =Customer::find($id);
        return view('customers.single_customer',compact('customer'));
    }
}
