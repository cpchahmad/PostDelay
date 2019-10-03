<?php

namespace App\Http\Controllers;

use App\Order;
use App\Status;
use Illuminate\Http\Request;
use Carbon\Carbon;
class AdminController extends Controller
{
    public function order_update($id){
        $order=Order::find($id);
        $status= Status::all();
        return view('orders.update_orders',compact('order','status'));
    }
    public function single_customer($id){
        $order=Order::where('customer_id',$id)->first();
        dd($order);
        return view('customers.single_customer',compact('order'));
    }
}
