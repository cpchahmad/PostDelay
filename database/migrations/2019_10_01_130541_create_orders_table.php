<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('draft_order_id')->nullable();
            $table->text('checkout_token');
            $table->date('ship_out_date')->nullable();
            $table->boolean('checkout_completed')->default(0);
            $table->text('shopify_order_id')->nullable();
            $table->text('shopify_customer_id')->nullable();
            $table->text('order_name')->nullable();
            $table->float('order_total')->nullable();
            $table->text('payment_gateway')->nullable();

            $table->text('shipping_method_title')->nullable();
            $table->text('shipping_method_id')->nullable();
            $table->float('shipping_method_price')->nullable();
            $table->text('shipping_method_source')->nullable();

            $table->unsignedBigInteger('status_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('package_detail_id')->nullable();
            $table->unsignedBigInteger('billing_address_id')->nullable();
            $table->unsignedBigInteger('sender_address_id')->nullable();
            $table->unsignedBigInteger('recipient_address_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
