<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->truncate();

        DB::table('statuses')->insert([
            'name'=>'Order created by user',
            'description' => 'The initial status for a new order. The order maintains this status until you tell us that you have shipped the item to PostDelay, or if you do not enter this information in the order details, it maintains this status until PostDelay has received your item.'
            ,'color' => 'GREEN',
            'subject' => 'PostDelay Order Confirmation',
            'message' => 'Your PostDelay order has been placed! Keep this email handy to view the details of your order, to manage the shipment date, and to let us know when you ship the item to PostDelay',
            'button_text' => 'Manage Your Order'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Item sent to PostDelay by user.',
            'description' => 'If you choose to enter details about your shipment to PostDelay in the \'Order Details\' page, this status will be set when you tell us you\'ve sent your item to PostDelay.',
            'color' => 'GREEN',
            'subject' => 'PostDelay Received Your Item Shipment Details',
            'message' => 'PostDelay has received your shipment details and start tracking your shipment to us and will send you a notification as soon as we received your shipment',
            'button_text' => 'Manage Your Order'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Item received by PostDelay.',
            'description' => 'Your item has been received by PostDelay and have been placed into storage, waiting for the future shipment date.',
            'color' => 'ORANGE',
            'subject' => 'PostDelay has received your item for Order',
            'message' => 'PostDelay has received your shipment. It has now been placed into our secure storage and will be shipped out to its final destination on ',
            'button_text' => 'Manage Your Order'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Item sent to recipient by PostDelay.',
            'description' => 'Your future shipment date has come! Your item has been sent to the recipient.',
            'color' => 'YELLOW',
            'subject' => 'PostDelay has shipped your item for Order',
            'message' => 'PostDelay has shipped your item to its recipient!',
            'button_text' => 'View Your Order'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Item received by recipient.',
            'description' => 'Based on the tracking information of PostDelay\'s outgoing shipment, your recipient has received the item.',
            'color' => 'GREEN',
            'subject' => 'Your PostDelay Order is complete!',
            'message' => 'Your recipient has received your shipment!',
            'button_text' => 'View Your Order'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Shipment cancelled before item sent to Postdelay by user.',
            'description' => 'Your order was cancelled before the item was shipped to PostDelay. Did you cancel by accident? Did you cancel but still ship your item? Contact Us.',
            'color' => 'GREEN',
            'subject' => 'Your PostDelay Order has been cancelled',
            'message' => 'You requested to cancel your order before PostDelay received your item. Your order has been refunded.',
            'button_text' => 'View Your Order'

        ]);
        DB::table('statuses')->insert([
            'name'=>'Shipment cancelled during shipment to PostDelay. Awaiting response from user.',
            'description' => 'You cancelled your order after you shipped the item to us, but before PostDelay received it. We are waiting to hear from you how you want to proceed.',
            'color' => 'GREEN',
            'subject' => 'PostDelay Action Required for order',
            'message' => 'You requested to cancel your order during PostDelay received your shipment.  Let us know whether you want the item shipped back to you, or if you want PostDelay to dispose of the item.',
            'button_text' => 'View Your Order'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Shipment cancelled during shipment to PostDelay. Item disposed.',
            'description' => 'You cancelled your order after you shipped the item to us, but before PostDelay received it. You instructed us that you did not want the item returned to you, and we have disposed of the item',
            'color' => 'YELLOW',
            'subject' => 'Your PostDelay Order has been cancelled',
            'message' => 'You requested to cancel your order during PostDelay received your shipment, and you let us know you do not want the item returned to you. We have disposed of your item.',
            'button_text' => 'View Your Order'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Shipment cancelled during shipment to PostDelay. Returning item to user.',
            'description' => 'You cancelled your order after you shipped the item to us, but before PostDelay received it. You instructed us that you want the item returned to you.',
            'color' => 'YELLOW',
            'subject' => 'Your PostDelay Order has been cancelled',
            'message' => 'You requested to cancel your order during PostDelay received your shipment, and you let us know you do want the item returned to you. We have returned your item.',
            'button_text' => 'View Your Order'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Shipment cancelled after receipt by PostDelay. Awaiting response from user.',
            'description' => 'You cancelled your order after you shipped the item to us, but before PostDelay received it. We are waiting to hear from you how you want to proceed.',
            'color' => 'GREEN',
            'subject' => 'PostDelay Action Required for order',
            'message' => 'You requested to cancel your order during PostDelay received your shipment.  Let us know whether you want the item shipped back to you, or if you want PostDelay to dispose of the item.',
            'button_text' => 'View Your Order'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Shipment cancelled after receipt by PostDelay. Item disposed.',
            'description' => 'You cancelled your order after you shipped the item to us, but before PostDelay received it. You instructed us that you did not want the item returned to you, and we have disposed of the item',
            'color' => 'YELLOW',
            'subject' => 'Your PostDelay Order has been cancelled',
            'message' => 'You requested to cancel your order during PostDelay received your shipment, and you let us know you do not want the item returned to you. We have disposed of your item.',
            'button_text' => 'View Your Order'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Shipment cancelled after receipt by PostDelay. Returning item to user.',
            'description' => 'You cancelled your order after you shipped the item to us, but before PostDelay received it. You instructed us that you want the item returned to you.',
            'color' => 'YELLOW',
            'subject' => 'Your PostDelay Order has been cancelled',
            'message' => 'You requested to cancel your order during PostDelay received your shipment, and you let us know you do want the item returned to you. We have returned your item.',
            'button_text' => 'View Your Order'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Cancelled shipment returned by Post Delay to user',
            'description' => 'We have mailed the cancelled shipment back to you, along with tracking information for the return shipment.',
            'color' => 'YELLOW',
            'subject' => 'Your Cancelled PostDelay Order has been Shipped to you',
            'message' => 'We have mailed the cancelled shipment back to you, along with tracking information for the return shipment.',
            'button_text' => 'View Your Order'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Cancelled shipment received by user.',
            'description' => 'Based on the tracking information of PostDelay\'s outgoing shipment, you have received your cancelled shipment back.',
            'color' => 'YELLOW',
            'subject' => 'Your Cancelled PostDelay Order has been received by you',
            'message' => 'Based on the tracking information of PostDelay\'s outgoing shipment, you have received your cancelled shipment back.',
            'button_text' => 'View Your Order'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Shipment price has changed. Awaiting response from user.',
            'description' => 'We check the price of mailing again a few days before shipment date. The price of shipping your package increased. We are waiting to hear from you how you want to proceed.',
            'color' => 'GREEN',
            'subject' => 'PostDelay Action Required for order ',
            'message' => 'PostDelay has attempted to ship your item, but the cost to complete the shipment changed. Let us know whether you want to continue with shipment or if you want to have the item shipped back to you. You can also choose to cancel the order and wen can dispose of the item for you.',
            'button_text' => 'Let us know how to Proceed'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Shipment price has changed. Payment received to continue shipment',
            'description' => 'We check the price of mailing again a few days before shipment date. The price of shipping your package increased. You instructed us to ship the item to your recipient and you paid for this increase in shipping cost.',
            'color' => 'YELLOW',
            'subject' => 'PostDelay has received your payment and is completing shipment of Order ',
            'message' => 'We have received your additional payment and are re-attempting delivery.',
            'button_text' => 'View Your Order'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Shipment price has changed. Payment received to return item to user.',
            'description' => 'We check the price of mailing again a few days before shipment date. The price of shipping your package increased. You instructed us not to ship the item to your recipient and you paid the shipping cost to have the item returned to you',
            'color' => 'YELLOW',
            'subject' => 'PostDelay has received your payment and is returning your order to you.',
            'message' => 'We have received your additional payment and are sending your item back to you.',
            'button_text' => 'View Your Order'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Shipment price has changed. User does not want to continue delivery. Item Disposed.',
            'description' => 'We check the price of mailing again a few days before shipment date. The price of shipping your package increased. You instructed us not to ship the item to you recipient and instructed us to dispose of the item.',
            'color' => 'GREEN',
            'subject' => 'PostDelay disposed your order as you say',
            'message' => 'We check the price of mailing again a few days before shipment date. The price of shipping your package increased. You instructed us not to ship the item to you recipient and instructed us to dispose of the item.',
            'button_text' => 'View Your Order'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Delivery failure. Awaiting response from user.',
            'description' => 'After shipping your item to your recipient, the item was returned to PostDelay as undeliverable. We are waiting to hear from you how you want to proceed.',
            'color' => 'GREEN',
            'subject' => 'PostDelay Action Required for order',
            'message' => ' PostDelay has attempted to ship your item, but the shipment was returned to us as undeliverable. Let us know whether you want to re-attempt delivery with the same or another address, or if you want to have the item shipped back to you. You can also choose to cancel the order and wen can dispose of the item for you.',
            'button_text' => 'Let us know how to Proceed'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Delivery failure. Payment and information received to re-attempt delivery.',
            'description' => 'After shipping your item to your recipient, the item was returned to PostDelay as undeliverable. You instructed us to ship the item to your recipient again and you paid for additional shipping attempt.',
            'color' => 'YELLOW',
            'subject' => 'PostDelay has received your payment and is completing shipment of Order',
            'message' => 'We have received your additional payment and are proceeding with shipment.',
            'button_text' => 'View Your Order'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Delivery failure. User does not want to re-attempt deliverable and payment received to return item to user.',
            'description' => 'After shipping your item to your recipient, the item was returned to PostDelay as undeliverable. You instructed us not to attempt redelivery to your recipient and you paid the shipping cost to have the item returned to you',
            'color' => 'YELLOW',
            'subject' => 'PostDelay Un-delivered Order Mailed To You ',
            'message' => 'After shipping your item to your recipient, the item was returned to PostDelay as undeliverable. You instructed us not to attempt redelivery to your recipient and you paid the shipping cost to have the item returned to you',
            'button_text' => 'View Your Order'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Delivery failure. User does not want to re-attempt delivery and instructions received to dispose item.',
            'description' => 'After shipping your item to your recipient, the item was returned to PostDelay as undeliverable. You instructed us not to reattempt delivery, to not return the item to you, and to dispose of the item.',
            'color' => 'GREEN',
            'subject' => 'PostDelay Un-delivered Order Disposed As You Say ',
            'message' => 'After shipping your item to your recipient, the item was returned to PostDelay as undeliverable. You instructed us not to reattempt delivery, to not return the item to you, and to dispose of the item.',
            'button_text' => 'View Your Order'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Undeliverable item returned to user by PostDelay.',
            'description' => 'The item that was returned to PostDelay as undeliverable has been shipped to the user.',
            'color' => 'YELLOW',
            'subject' => 'Your Un-deliverable PostDelay Order has been Shipped to you',
            'message' => 'The item that was returned to PostDelay as undeliverable has been shipped to the user.',
            'button_text' => 'View Your Order'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Undeliverable item received by user.',
            'description' => 'The item that was returned to PostDelay as undeliverable has been shipped to and received by the user.',
            'color' => 'GREEN',
            'subject' => 'Your Un-deliverable PostDelay Order has been Received by you',
            'message' => 'The item that was returned to PostDelay as undeliverable has been shipped to and received by the user.',
            'button_text' => 'View Your Order'
        ]);
    }
}
