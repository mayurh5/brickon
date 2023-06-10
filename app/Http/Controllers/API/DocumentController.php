<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assets;
use Validator;
use Log;
use Carbon\Carbon;
use DB;

class DocumentController extends Controller
{
   public function get_documnent_type(Request $request){

      try {

        $get_image_type = config('global.file_type');

        return response()->json(["status" => 1, "message" => "List document type.", "data" => $get_image_type]);


      }catch(\Exception $e) {
        return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);
      }

   }

   public function get_document_list_by_type(Request $request){

    try {

      $response_array = array('status' => 0,  'message' => trans('pages.something_wrong') );

      $validation_rules = [
          'document_type' => 'required'
      ];

      $validator = Validator::make( $request->all(), $validation_rules );

      if($validator->fails()) {

          return response()->json(['status' => 0, 'message' => implode(',', $validator->messages()->all()) ]);

      } else {
        $today = Carbon::now();
        if ($request->document_type == config('global.file_type.banner')) {

          $data = Assets::where(['type' => $request->document_type,
                                'is_active' => 1])
                          ->whereDate('expiry_date', '>=', $today->format('Y-m-d'))
                          ->orderBy('created_at', 'DESC')
                          ->get(['id','type','path','file_type','title','expiry_date']);

        } else {

          $data = Assets::where(['type' => $request->document_type,
                                'is_active' => 1])
                          ->orderBy('created_at', 'DESC')
                          ->get(['id','type','path','file_type','title']);

        }

        if ($request->document_type == config('global.file_type.product_quality')) {

          $data = DB::table('settings')
                      ->select('id','product_qualilty')
                      ->get();

        } else if( $request->document_type == config('global.file_type.brochure')){
                $data = DB::table('settings')
                          ->select('id','brochure')
                          ->get();
        }


        return response()->json(["status" => 1, "message" => "List document data.", "data" => $data]);

      }

    }catch(\Exception $e) {
      return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);
    }

   }
}
