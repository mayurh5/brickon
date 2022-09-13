<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Repositories\CommonRepository as CommonRepo;
use Validator;
use Helper;
use Hash;
use Log;
use DB;

use Setting;

class LeadsRepository {

  public static function get_list_leads(Request $request){

    try {

      return view('admin.leads.index');

    } catch (\Throwable $th) {
      //throw $th;
    }

  }
  public static function create(Request $request){

    try {

      return view('admin.leads.create');

    } catch (\Throwable $th) {
      //throw $th;
    }

  }



}
