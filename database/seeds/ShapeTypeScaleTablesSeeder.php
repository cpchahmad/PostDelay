<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShapeTypeScaleTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shapes')->insert([
            'name'=>'Box'
        ]);
        DB::table('shapes')->insert([
            'name'=>'Light Box'
        ]);
        DB::table('shapes')->insert([
            'name'=>'Circle'
        ]);
        DB::table('shapes')->insert([
            'name'=>'Unknown'
        ]);

        DB::table('post_types')->insert([
            'name'=>'Post Card'
        ]);
        DB::table('post_types')->insert([
            'name'=>'Letter'
        ]);
        DB::table('post_types')->insert([
            'name'=>'Large Envelope'
        ]);


        DB::table('scales')->insert([
            'name'=>'millimetres'
        ]);
        DB::table('scales')->insert([
            'name'=>'centimetres'
        ]);
        DB::table('scales')->insert([
            'name'=>'inches'
        ]);
        DB::table('scales')->insert([
            'name'=>'feets'
        ]);
        DB::table('scales')->insert([
            'name'=>'metres'
        ]);

    }
}
