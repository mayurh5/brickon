<?php

namespace App\Repositories;

use App\Models\Address;
use App\Models\KYC;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Validator;
use File;
use Image;
use Exception;
use Log;
use DB;

class CommonRepository {

  	public static function save_location_details(Request $request, $user_id) {

        try{

          // $auth_user = \Helper::get_auth_user($request);

          if(isset($request->locations) && is_array($request->locations)){

            foreach ($request->locations as $key => $value) {

              if(isset($value['location_id']) && !empty($value['location_id'])){

                $location = Address::find($value['location_id']);

              }else{

                $location = new Address;
                // $location->association_id = $association_id;
                // $location->association_type_term = $association_type_term;
                $location->is_active = 1;
                // $location->created_by = $auth_user->user_id;
              }

              $location->address1 = isset($value['address1']) ? $value['address1'] : NULL;
              $location->city = isset($value['city']) ? $value['city'] : NULL;
              $location->state = isset($value['state']) ? $value['state'] : NULL;
              $location->postal_code = isset($value['postal_code']) ? $value['postal_code'] : NULL;
              $location->lat = isset($value['lat']) ? $value['lat'] : NULL;
              $location->long = isset($value['long']) ? $value['long'] : NULL;
              $location->country = isset($value['country']) ? $value['country'] : NULL;
              $location->save();

            }

          }else{

            $location = Address::where('user_id', $user_id)->first();

            if(!$location){
              $location = new Address;
              $location->user_id = $user_id;
              // $location->association_id = $association_id;
              // $location->association_type_term = $association_type_term;
              $location->is_active = 1;
            }

            $location->address_line_1 = $request->address_line_1;
            $location->address_line_2 = $request->address_line_2;
            $location->city = $request->city;
            $location->state = $request->state;
            $location->postal_code = $request->postal_code;
            $location->lat = $request->lat;
            $location->long = $request->long;
            $location->country = $request->country;
            $location->save();

            User::where('id', $user_id)->update(array('address_id' => $location->id));
          }

        }catch(\Exception $e) {

                Log::info("error save_location_details ". print_r($e->getMessage(), true));
            }

    }

    public static function save_kyc_details(Request $request, $user_id) {

        try{
          // dd($request->all());
          // $auth_user = \Helper::get_auth_user($request);

            $kyc = KYC::where('user_id', $user_id)->first();

            if(!$kyc){
              $kyc = new KYC;
              $kyc->user_id = $user_id;
            }

            $kyc->customer_name = $request->customer_name;
            $kyc->gst_number = $request->gst_number;
            $kyc->pan_number = $request->pan_number;
            $kyc->office_address = $request->office_address;
            $kyc->bank_name = $request->bank_name;
            $kyc->ac_number = $request->ac_number;
            $kyc->ifsc_code = $request->ifsc_code;
            $kyc->bank_address = $request->bank_address;
            $kyc->save();

            // file upload code
            if ($request->hasFile('gst_file')){

                $old_file = $kyc->gst_file;

                if(!empty($old_file)){
                      \Helper::unlink_document($old_file);
                }

                $file = $request->file('gst_file');
                $file_name_to_store = time();
                $file_uploaded_path ='images/document';

                $gst_file = \Helper::upload_file($file, "", $file_name_to_store, $file_uploaded_path, $is_base64_file = false);

                $kyc->gst_file = $gst_file;
            }

            if ($request->hasFile('pan_file')){

                $old_file = $kyc->pan_file;

                if(!empty($old_file)){
                      \Helper::unlink_document($old_file);
                }

                $file = $request->file('pan_file');
                $file_name_to_store = time();
                $file_uploaded_path ='images/document';

                $pan_file = \Helper::upload_file($file, "", $file_name_to_store, $file_uploaded_path, $is_base64_file = false);

                $kyc->pan_file = $pan_file;
            }

            $kyc->save();

            User::where('id', $user_id)->update(array('kyc_id' => $kyc->id));

            return $kyc;

        }catch(\Exception $e) {

                Log::info("error save_location_details ". print_r($e->getMessage(), true));
        }

    }

}
