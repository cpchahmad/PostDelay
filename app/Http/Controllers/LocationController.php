<?php

namespace App\Http\Controllers;

use App\Location;
use App\Shop;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function show_locations(Request $request){
        $locations =  Location::all();
        $shops = Shop::all();
         return view('settings.locations.index')->with([

             'locations' =>$locations,
             'shops' => $shops
         ]);
    }

    public function add_location(Request $request){
        Location::create($request->all());
        return redirect()->back();
    }

    public function delete_location(Request $request){
        Location::find($request->input('location_id'))->delete();
        return response()->json([
            'location' => 'deleted',
        ]);
    }

    public function show_edit_form(Request $request){
        $shops = Shop::all();
        $location = Location::find($request->id);
        return view('settings.locations.edit')->with([
            'location' => $location,
            'shops' => $shops
        ]);
    }
    public function update_location(Request $request){

        $location = Location::find($request->input('location_id'))->update($request->all());
        return response()->json([
            'location' => 'updated',
        ]);
    }
}
