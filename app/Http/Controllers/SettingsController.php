<?php

namespace App\Http\Controllers;


use App\PostDelayFee;
use App\PostType;
use App\Scale;
use App\Shape;

use App\State;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function show_shape(){
        $shapes = Shape::all();

        return view('settings.shapes.index')->with([
            "shapes" =>$shapes,
        ]);

    }

    public function update_shape(Request $request){

        Shape::find($request->input('shape_id'))->update([
            'name' => $request->input('shape')
        ]);

        return response()->json([
            'shape' => $request->input('shape')
        ]);

    }

    public function delete_shape(Request $request){

        Shape::find($request->input('shape_id'))->delete();

        return response()->json([
            'shape' => 'deleted'
        ]);

    }

    public function add_shape(Request $request){
        Shape::create($request->all());
        return redirect()->back();

    }

    public function show_type(){
        $types = PostType::all();
        return view('settings.post-types.index')->with([
            "types" =>$types,
        ]);

    }

    public function update_type(Request $request){

        if($request->input('update_type') == 'type_name'){
            PostType::find($request->input('type_id'))->update([
                'name' => $request->input('type')
            ]);
            return response()->json([
                'type' => $request->input('type')
            ]);
        }

        if($request->input('update_type') == 'weight') {
            PostType::find($request->input('type_id'))->update([
                'weight' => $request->input('weight')
            ]);
            return response()->json([
                'weight' => $request->input('weight')
            ]);
        }

        if ($request->input('update_type') == 'commision_type'){

            PostType::find($request->input('type_id'))->update([
                'commision_type' => $request->input('type')
            ]);
            return response()->json([
                'commision_type' => $request->input('type')
            ]);

        }

        if ($request->input('update_type') == 'commision'){

            PostType::find($request->input('type_id'))->update([
                'commision' => $request->input('type')
            ]);
            return response()->json([
                'commision' => $request->input('type')
            ]);
        }


    }

    public function delete_type(Request $request){

        PostType::find($request->input('type_id'))->delete();

        return response()->json([
            'type' => 'deleted'
        ]);

    }

    public function add_type(Request $request){
        PostType::create($request->all());
        return redirect()->back();

    }

    public function show_scales(){
        $scales = Scale::all();

        return view('settings.scales.index')->with([
            "scales" =>$scales,
        ]);

    }

    public function update_scale(Request $request){

        Scale::find($request->input('scale_id'))->update([
            'name' => $request->input('scale')
        ]);

        return response()->json([
            'scale' => $request->input('scale')
        ]);

    }

    public function delete_scale(Request $request){

        Scale::find($request->input('scale_id'))->delete();

        return response()->json([
            'scale_id' => 'deleted'
        ]);

    }

    public function add_scale(Request $request){
        Scale::create($request->all());
        return redirect()->back();

    }

    public function show_post_delay_fee(Request $request){
        $fees  = PostDelayFee::orderBy('default','desc')->get();
        return view('settings.postdelayfee.index')->with([
            'fees' => $fees
        ]);
    }


    public function add_fee(Request $request){
        DB::table('post_delay_fees')->where('type',$request->input('type'))->update(array('default' => 0));
        PostDelayFee::create($request->all());
        return redirect()->back();

    }

    public function make_default_fee(Request $request){
          DB::table('post_delay_fees')->where('type',$request->input('type'))->update(array('default' => 0));
          PostDelayFee::find($request->input('fee'))->update([
             'default' => 1
          ]);
    }

    public function update_fee(Request $request){
        if($request->input('type') == 'name'){
            PostDelayFee::find($request->input('id'))->update([
                'name' => $request->input('name')
            ]);

            return response()->json([
                'name' => $request->input('name')
            ]);
        }
        if($request->input('type') == 'price'){
            PostDelayFee::find($request->input('id'))->update([
                'price' => $request->input('price')
            ]);

            return response()->json([
                'price' => $request->input('price')
            ]);
        }

        if($request->input('type') == 'type'){
            PostDelayFee::find($request->input('id'))->update([
                'type' => $request->input('fee_type')
            ]);

            return response()->json([
                'fee_type' => $request->input('type')
            ]);
        }
    }

    public function delete_fee(Request $request){

        PostDelayFee::find($request->input('id'))->delete();

        return response()->json([
            'fee_id' => 'deleted'
        ]);

    }
    public function show_statuses(Request $request){
        $statuses = Status::all();
        return view('settings.statuses.index')->with([
            'statuses' => $statuses
        ]);
    }

    public function edit_status(Request $request){
        $status = Status::find($request->id);
        return view('settings.statuses.edit')->with([
            'status' => $status
        ]);
    }

    public function update_status(Request $request){
       Status::find($request->input('id'))->update($request->all());
       return redirect()->back();
    }
}
