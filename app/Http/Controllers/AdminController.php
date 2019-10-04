<?php

namespace App\Http\Controllers;

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
        $order=Order::where('customer_id',$id)->first();

        return view('customers.single_customer',compact('order'));
    }
}
