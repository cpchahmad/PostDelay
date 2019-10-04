<?php

namespace App\Http\Controllers;


use App\PostType;
use App\Scale;
use App\Shape;

use Illuminate\Http\Request;

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

        PostType::find($request->input('type_id'))->update([
            'name' => $request->input('type')
        ]);

        return response()->json([
            'type' => $request->input('type')
        ]);

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
}
