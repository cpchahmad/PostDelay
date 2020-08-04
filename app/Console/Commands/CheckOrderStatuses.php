<?php

namespace App\Console\Commands;

use App\Customer;
use App\Mail\DisposeOrderAfterNoPaymentToReturn;
use App\Mail\DisposeOrderNoInstructionAfterCancellation;
use App\Mail\DisposeOrderNoInstructionAfterPriceChange;
use App\Mail\DisposeOrderNoInstructionAfterUndeliverable;
use App\Mail\OrderMailOut;
use App\Mail\OrderVerifyShipmentCost;
use App\Order;
use App\OrderStatusHistory;
use App\Settings;
use Carbon\Carbon;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckOrderStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order_status:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set Automatically Emails to Admin on Daily Bases';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $orders = Order::where('checkout_completed',1)->where('additional_payment',0)->get();
        $settings = Settings::all()->first();

        foreach ($orders as $order){
            /*If order has status 3, 16 or 20 on send-out date, send email with subject "ORDER XXX MAIL OUT"*/
            if(in_array($order->status_id,[3,16,20])){
                $date = new DateTime($order->ship_out_date);
                $now = new DateTime();
                $customer = Customer::find($order->customer_id);
                if($date == $now) {
                    Mail::to('admin@postdelay.com')->send(new OrderMailOut($customer, $order));
                }
            }

            /*If order has status 3, YYY days before send-out date, send email with subject 'ORDER XXX VERIFY SHIPMENT COST".  YYY days is defined in admin gui.*/
            if(in_array($order->status_id,[3])){
                $verification_time = strtotime(Carbon::parse(date_create($order->ship_out_date)->format('Y-m-d'))->subDays((int)$settings->verify_shipping_cost_threshold));
                $current = strtotime(Carbon::parse(now()->format('Y-m-d')));
                if($current == $verification_time){
                    $customer = Customer::find($order->customer_id);
                    Mail::to('admin@postdelay.com')->send(new OrderVerifyShipmentCost($customer, $order));
                }
            }

            /*If order has status 7 for NNN days, send email with subject " DISPOSE ORDER XXX - NO INSTRUCTIONS AFTER CANCELLATION" and set status 13. NNN defined in admin gui.*/
            if(in_array($order->status_id,[7])){
                $stay_time = strtotime(Carbon::parse(date_create($order->updated_at)->format('Y-m-d'))->addDays((int)$settings->wait_for_response_for_status_7));
                $current = strtotime(Carbon::parse(now()->format('Y-m-d')));
                if($stay_time == $current){
                    $customer = Customer::find($order->customer_id);

                    $order->status_id = '13';
                    $order->save();

                    $history = new OrderStatusHistory();
                    $history->order_id = $order->id;
                    $history->order_status_id = $order->status_id;
                    $history->change_at = now();
                    $history->setCreatedAt(now());
                    $history->setUpdatedAt(now());
                    $history->save();

                    Mail::to('admin@postdelay.com')->send(new DisposeOrderNoInstructionAfterCancellation($customer, $order));


                }
            }

            /*If order has status 15 for NNN days, send email with subject "DISPOSE ORDER XXX - NO INSTRUCTIONS AFTER PRICE CHANGE" and set status 12.  NNN defined in admin gui.*/
            if(in_array($order->status_id,[15])){
                $stay_time = strtotime(Carbon::parse(date_create($order->updated_at)->format('Y-m-d'))->addDays((int)$settings->wait_for_response_for_status_15));
                $current = strtotime(Carbon::parse(now()->format('Y-m-d')));
                if($stay_time == $current){
                    $customer = Customer::find($order->customer_id);

                    $order->status_id = '12';
                    $order->save();

                    $history = new OrderStatusHistory();
                    $history->order_id = $order->id;
                    $history->order_status_id = $order->status_id;
                    $history->change_at = now();
                    $history->setCreatedAt(now());
                    $history->setUpdatedAt(now());
                    $history->save();

                    Mail::to('admin@postdelay.com')->send(new DisposeOrderNoInstructionAfterPriceChange($customer, $order));


                }
            }


            /*If order has status 19 for NNN days, send email with subject "DISPOSE ORDER XXX - NO INSTRUCTIONS AFTER UNDELIVERABLE" and set status 11.  NNN defined in admin gui.*/
            if(in_array($order->status_id,[19])){
                $stay_time = strtotime(Carbon::parse(date_create($order->updated_at)->format('Y-m-d'))->addDays((int)$settings->wait_for_response_for_status_19));
                $current = strtotime(Carbon::parse(now()->format('Y-m-d')));

                if($stay_time == $current){
                    $customer = Customer::find($order->customer_id);

                    $order->status_id = '11';
                    $order->save();

                    $history = new OrderStatusHistory();
                    $history->order_id = $order->id;
                    $history->order_status_id = $order->status_id;
                    $history->change_at = now();
                    $history->setCreatedAt(now());
                    $history->setUpdatedAt(now());
                    $history->save();

                    Mail::to('admin@postdelay.com')->send(new DisposeOrderNoInstructionAfterUndeliverable($customer, $order));


                }
            }

            /*If order has status 10 for NNN days, send email with subject "DISPOSE ORDER XXX - DID NOT MAKE PAYMENT TO RETURN ITEM AFTER CANCELLATION" and set status 23.  NNN defined in admin gui.*/
            if(in_array($order->status_id,[10])){
                $stay_time = strtotime(Carbon::parse(date_create($order->updated_at)->format('Y-m-d'))->addDays((int)$settings->wait_for_response_for_status_10));
                $current = strtotime(Carbon::parse(now()->format('Y-m-d')));

                if($stay_time == $current){
                    $customer = Customer::find($order->customer_id);

                    $order->status_id = '23';
                    $order->save();

                    $history = new OrderStatusHistory();
                    $history->order_id = $order->id;
                    $history->order_status_id = $order->status_id;
                    $history->change_at = now();
                    $history->setCreatedAt(now());
                    $history->setUpdatedAt(now());
                    $history->save();

                    Mail::to('admin@postdelay.com')->send(new DisposeOrderAfterNoPaymentToReturn($customer, $order));


                }
            }


        }
    }
}
