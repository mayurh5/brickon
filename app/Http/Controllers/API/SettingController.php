<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Member;
use App\Models\Lead;
use App\Models\Settings;

use Illuminate\Support\Facades\Hash;
use Validator;
use Log;

class SettingController extends Controller
{
    public function get_cms_pages(Request $request){

        try{

          $get_term_and_condition = Settings::first(['policy','about_us']);

          $data['policy'] = $get_term_and_condition['policy'];
          $data['about_us'] = $get_term_and_condition['about_us'];

          return response()->json([
          "status"=>1,
          "message" => "CMS pages.",
          "data"=>$data
          ]);


        }catch(Exception $exception)
        {
            return response()->json(["status" => 0, "message" => "Somthing went wrong", "data" => (object)[]]);
        }

    }
}
