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
       DB::table('statuses')->insert([
          'name'=>'Order created by user'
       ]);
        DB::table('statuses')->insert([
            'name'=>'Item sent to PostDelay by user.'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Item received by PostDelay.'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Item sent to recipient by PostDelay.'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Item received by recipient.'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Shipment cancelled before item sent to Postdelay by user.'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Shipment cancelled during shipment to PostDelay. Awaiting response from user.'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Shipment cancelled during shipment to PostDelay. Item disposed.'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Shipment cancelled during shipment to PostDelay. Returning item to user.'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Shipment cancelled after receipt by PostDelay. Awaiting response from user.'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Shipment cancelled after receipt by PostDelay. Item disposed.'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Shipment cancelled after receipt by PostDelay. Returning item to user.'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Cancelled shipment returned by Post Delay to user'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Cancelled shipment received by user.'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Shipment price has changed. Awaiting response from user.'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Shipment price has changed. Payment received to continue shipment'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Shipment price has changed. Payment received to return item to user.'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Shipment price has changed. User does not want to continue delivery. Item Disposed.'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Delivery failure. Awaiting response from user.'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Delivery failure. Payment and information received to re-attempt delivery.'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Delivery failure. User does not want to re-attempt deliverable and payment received to return item to user.'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Delivery failure. User does not want to re-attempt delivery and instructions received to dispose item.'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Undeliverable item returned to user by PostDelay.'
        ]);
        DB::table('statuses')->insert([
            'name'=>'Undeliverable item received by user.'
        ]);
    }
}
