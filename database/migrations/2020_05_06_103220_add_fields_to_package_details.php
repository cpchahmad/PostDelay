<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToPackageDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_details', function (Blueprint $table) {
            $table->text('postcard_size')->nullable();
            $table->text('unit_of_measures_weight')->nullable();
            $table->double('pounds')->nullable();
            $table->double('ounches')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_details', function (Blueprint $table) {
            //
        });
    }
}
