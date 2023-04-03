<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assets;
use App\Models\Distributor;
use Validator;
use Log;
use Carbon\Carbon;

class DistributorController extends Controller
{
   public function get_distributor_list(Request $request){

    try {

      $data = Distributor::from('distributors as dis')
                          ->where('dis.is_active', 1)
                          ->orderBy('dis.distributor_id', 'DESC')
                          ->leftjoin('address as add','add.id','=','dis.address_id')
                          ->select('dis.*','add.address_line_1','add.address_line_2','add.city','add.state','add.country','add.postal_code','add.lat','add.long')
                          ->get();

      return response()->json(["status" => 1, "message" => "List distributor data.", "data" => $data]);

    }catch(\Exception $e) {
      return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);
    }


   }
}
