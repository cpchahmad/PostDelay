<?php

namespace App\Http\Controllers;


use App\PostDelayFee;
use App\PostType;
use App\Scale;
use App\Settings;
use App\Shape;

use App\State;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use USPS\RatePackage;

class SettingsController extends Controller
{
    public function show_shape(){
        $shapes = Shape::all();

        return view('settings.shapes.index')->with([
            "shapes" =>$shapes,
        ]);

    }

    public function show_threshold(){
        $settings = Settings::all()->first();
        if($settings == null){
            $settings =  new Settings();
            $settings->min_threshold_ship_out_date = 7;
            $settings->min_threshold_for_modify_ship_out_date = 5;
            $settings->max_threshold_for_modify_ship_out_date = 5;
            $settings->save();
        }

        return view('settings.threshold.index')->with([
            "settings" =>$settings,
        ]);

    }

    public function update_threshold(Request $request){
        $settings = Settings::find($request->id);
        if($settings != null){
            if($request->has('min_threshold_ship_out_date')){
                $settings->min_threshold_ship_out_date = $request->input('min_threshold_ship_out_date');
            }
            if($request->has('min_threshold_for_modify_ship_out_date')){
                $settings->min_threshold_for_modify_ship_out_date = $request->input('min_threshold_for_modify_ship_out_date');
            }
            if($request->has('max_threshold_for_modify_ship_out_date')){
                $settings->max_threshold_for_modify_ship_out_date = $request->input('max_threshold_for_modify_ship_out_date');
            }
            if($request->has('min_threshold_in_cancellation')){
                $settings->min_threshold_in_cancellation = $request->input('min_threshold_in_cancellation');
            }
            if($request->has('max_days_storage_for_letters_postcards')){
                $settings->max_days_storage_for_letters_postcards = $request->input('max_days_storage_for_letters_postcards');
            }
            if($request->has('max_days_storage_for_packages')){
                $settings->max_days_storage_for_packages = $request->input('max_days_storage_for_packages');
            }
            $settings->save();
            return redirect()->back();
        }
        else{
            return redirect()->route('threshold.index');
        }
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

    public function api_credentials(Request $request){
        $settings = Settings::all()->first();
        return view('settings.api.index')->with([
            'settings' => $settings
        ]);
    }
    public function update_usps_credentials(Request $request){
       $user_name =  $request->input('usps_username');
        $xml_data = '<RateV4Request USERID="'.$user_name.'">'.
            '<Revision>2</Revision>'.
            '<Package ID="1ST">'.
            '<Service>'.RatePackage::SERVICE_FIRST_CLASS.'</Service>'.
            '<FirstClassMailType>'.RatePackage::MAIL_TYPE_POSTCARD.'</FirstClassMailType>'.
            '<ZipOrigination>10001</ZipOrigination>'.
            '<ZipDestination>10007</ZipDestination>'.
            '<Pounds>0</Pounds>'.
            '<Ounces>0.12</Ounces>'.
            '<Container>POSTCARDS</Container>'.
            '<Size>regular</Size>'.
            '<Machinable>false</Machinable>'.
            '</Package>'.
            '</RateV4Request>';

        $url = "https://Secure.ShippingAPIs.com/ShippingAPI.dll";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 1);
        $data = "API=RateV4&XML=".$xml_data;
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        $result=curl_exec ($ch);

        if (curl_errno($ch)){
            return redirect()->back()->with('error','USPS Credentials cannot be verified. Try Later!');
        }
        else{
            curl_close($ch);
//            dd($result);
            $data = strstr($result, '<?');
            $xml = simplexml_load_string($data);
            $json = json_encode($xml);
            $array = json_decode($json,TRUE);
            if(array_key_exists('Source',$array)){
                 return redirect()->back()->with('error','Provided USPS credentials are not valid!');
            }
            else{
              $settings = Settings::find($request->input('setting_id'));
              if($settings != null){
                  $settings->usps_username = $user_name;
                  $settings->save();
                  return redirect()->back()->with('success','USPS Credentials Updated!');

              }
              else{
                  return redirect()->back()->with('error','Settings Not Found. Please Refresh the Page!');

              }
            }

        }
    }

    public function app_messages(Request $request){
        $settings = Settings::all()->first();
        return view('settings.messages.index')->with([
            'settings' => $settings
        ]);
    }

    public function update_app_messages(Request $request){
        $settings = Settings::find($request->input('setting_id'));
        if($settings != null){
            $settings->status_19_option_3 = $request->input('status_19_option_3');
            $settings->status_19_option_2 = $request->input('status_19_option_2');
            $settings->status_19_option_1 = $request->input('status_19_option_1');
            $settings->status_15_option_3 = $request->input('status_15_option_3');
            $settings->status_15_option_2 = $request->input('status_15_option_2');
            $settings->status_15_option_1 = $request->input('status_15_option_1');
            $settings->status_7_option_3 = $request->input('status_7_option_3');
            $settings->status_7_option_2 = $request->input('status_7_option_2');
            $settings->status_7_option_1 = $request->input('status_7_option_1');
            $settings->save();
            return redirect()->back()->with('success','App Messages Updated!');

        }
        else{
            return redirect()->back()->with('error','Settings Not Found. Please Refresh the Page!');

        }
    }

}
