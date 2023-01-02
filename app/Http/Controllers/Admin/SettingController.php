<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use Validator;
use Log;

class SettingController extends Controller
{
    public function index(Request $request){

      $setting = Settings::first();

      return view('admin.setting.index',compact('setting'));

    }

    public function update(Request $request){

      try {

          $setting = Settings::where('id', $request->id)->first();

          if($setting){

            $setting->android_version = $request->android_version;
            $setting->ios_version = $request->ios_version;
            $setting->under_maintanave = $request->is_undermaintenance;
            $setting->terms = $request->terms;
            $setting->about_us = $request->about_us;
            $setting->policy = $request->policy;
            $setting->base_url = $request->base_url;
            $setting->image_base_url = $request->image_base_url;
            $setting->save();

              if ($request->hasFile('brochure_doc')){

                if(!empty($request->id)){
                    // remove old image from folder
                    \Helper::deleteFile($setting->brochure);
                }

                  $file = $request->file('brochure_doc');
                  $file_name_to_store = time();
                  $file_uploaded_path ='images/setting';
                  $file_type = $request->file('brochure_doc')->getClientOriginalExtension();

                  $brochure_file_path = \Helper::upload_file($file, "", $file_name_to_store, $file_uploaded_path, $is_base64_file = false);
                  $setting->brochure = $brochure_file_path;
                  $setting->save();
              }

              if ($request->hasFile('product_quality_doc')){

                if(!empty($request->id)){
                    // remove old image from folder
                    \Helper::deleteFile($setting->product_qualilty);
                }

                  $file = $request->file('product_quality_doc');
                  $file_name_to_store = time();
                  $file_uploaded_path ='images/setting';
                  $file_type = $request->file('product_quality_doc')->getClientOriginalExtension();

                  $product_qualilty_file_path = \Helper::upload_file($file, "", $file_name_to_store, $file_uploaded_path, $is_base64_file = false);
                  $setting->product_qualilty = $product_qualilty_file_path;
                  $setting->save();
              }

          }
          return redirect()->route('setting.index')->with('message', 'Settings updated sucessfully!');

      }catch(\Exception $e) {

        Log::info("SettingController update - ". $e->getMessage());
        return redirect()->route('setting.index')->with(['error' => "Something want wrong.", 'status' => 0]);

      }

    }
}
