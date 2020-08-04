<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThresholdsToSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->text('verify_shipping_cost_threshold')->nullable();
            $table->text('wait_for_response_for_status_7')->nullable();
            $table->text('wait_for_response_for_status_15')->nullable();
            $table->text('wait_for_response_for_status_19')->nullable();
            $table->text('wait_for_response_for_status_10')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
}
