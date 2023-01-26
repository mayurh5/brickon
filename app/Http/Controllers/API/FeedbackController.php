<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Member;
use App\Models\Feedback;
use App\Models\LeadStatus;
use Illuminate\Support\Facades\Hash;
use Validator;
use Log;

class FeedbackController extends Controller
{

  public function store_feedback(Request $request){

    try {

      $response_array = array('status' => 0,  'message' => trans('pages.something_wrong') );

      $validation_rules = [
          'user_id' => 'required',
          'description' => 'required',
      ];

      $validator = Validator::make( $request->all(), $validation_rules );

      if($validator->fails()) {

          return response()->json(['status' => 0, 'message' => implode(',', $validator->messages()->all()) ]);

      } else {

        $feedback = new Feedback;
        $feedback->user_id = $request->user_id;
        $feedback->description = $request->description;
        $feedback->save();

        $response_array = array('status' => 1,  'message' => "Your feedback sent successfully." );
        return response()->json($response_array, 200);
      }

    }catch(\Exception $e) {

        return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);

    }

  }

  public function get_feedback_details(Request $request){

    try {

      $response_array = array('status' => 0,  'message' => trans('pages.something_wrong') );

      $validation_rules = [
          'user_id' => 'required',
      ];

      $validator = Validator::make( $request->all(), $validation_rules );

      if($validator->fails()) {

          return response()->json(['status' => 0, 'message' => implode(',', $validator->messages()->all()) ]);

      } else {

        $main_query =  Feedback::from('feedback')
                                ->where('user_id', $request->user_id)
                                ->select('feedback.id','feedback.description','feedback.is_primacreated_atry');

                      if(!empty($request->search)){

                        $main_query = $main_query->where('feedback.description','LIKE',"%{$request->search}%")
                                          ->orWhere('feedback.title','LIKE',"%{$request->search}%");

                      }

                      $main_query = $main_query->get();

                      $data['list'] = $main_query->all();
                      // $data['total_pages'] = $main_query->lastPage();

          return response()->json(["status" => 1, "message" => "Product list with search text.", "data" => $data]);

      }

    }catch(\Exception $e) {

        return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);

    }

  }

}
