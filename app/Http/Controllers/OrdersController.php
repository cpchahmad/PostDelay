<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index(){
//        dd(session('shop_name'));
        return view('orders.index');
    }
}
