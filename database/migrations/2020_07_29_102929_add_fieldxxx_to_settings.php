<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldxxxToSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->text('usps_username')->nullable();

            $table->text('status_7_option_1')->nullable();
            $table->text('status_7_option_2')->nullable();
            $table->text('status_7_option_3')->nullable();


            $table->text('status_15_option_1')->nullable();
            $table->text('status_15_option_2')->nullable();
            $table->text('status_15_option_3')->nullable();


            $table->text('status_19_option_1')->nullable();
            $table->text('status_19_option_2')->nullable();
            $table->text('status_19_option_3')->nullable();

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
