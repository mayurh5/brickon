<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Member;
use App\Models\Lead;
use App\Models\Product;
use App\Models\LeadProduct;
use Illuminate\Support\Facades\Hash;
use Validator;
use Log;

class LeadController extends Controller
{

   public function store_lead(Request $request){

    try {

        $response_array = array('status' => 0,  'message' => trans('pages.something_wrong') );

        $validation_rules = [
            'user_id' => 'required',
            'delivery_address' => 'required',
            'billing_address' => 'required',
            'lead_product' => 'required'
        ];

        $validator = Validator::make( $request->all(), $validation_rules );

        if($validator->fails()) {

            return response()->json(['status' => 0, 'message' => implode(',', $validator->messages()->all()) ]);

        } else {

            $lead_count = Lead::count();
            $lead_count = \Helper::generate_order_no('LEAD', $lead_count);

            $lead = new Lead;
            $lead->user_id = $request->user_id;
            $lead->pickup_address = $request->pickup_address;
            $lead->delivery_address = $request->delivery_address;
            $lead->billing_address = $request->billing_address;
            $lead->note = $request->note;
            $lead->order_code = $lead_count;
            $lead->order_date = $request->order_date;
            $lead->due_date = $request->due_date;
            $lead->primary_product_price = $request->primary_product_price;
            $lead->save();

            $lead_product = json_decode(json_encode($request->lead_product) , true);

            if(!empty($lead_product)){

              foreach ($lead_product as $key => $value) {

                $product =  new LeadProduct;
                $product->lead_id = $lead->id;
                $product->product_id = $value['product_id'];
                $product->qty = $value['qty'];
                $product->price = $value['price'];
                $product->type = $value['type'];
                $product->value = $value['value'];
                $product->save();

              }

              // total tons logic here

            }

            $response_array = array('status' => 1,  'message' => "Your order create successfully." );

        }

        return response()->json($response_array, 200);

    }catch(\Exception $e) {

        return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);

    }
   }

   public function get_lead_list_by_user(Request $request){

    try {

      $response_array = array('status' => 0,  'message' => trans('pages.something_wrong') );

      $validation_rules = [
          'user_id' => 'required',
      ];

      $validator = Validator::make( $request->all(), $validation_rules );

      if($validator->fails()) {

          return response()->json(['status' => 0, 'message' => implode(',', $validator->messages()->all()) ]);

      } else {

        $leads = Lead::where('user_id', $request->user_id)
                      ->orderBy('id', 'DESC')
                      ->get(['id','order_date','due_date','final_total','total_tons','status']);


        $response_array = array('status' => 1,  'message' => "Lead get sucessfully.", 'data' => $leads);

      }

      return response()->json($response_array, 200);

    }catch(\Exception $e) {

      return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);

    }

   }

   public function get_lead_detail_by_lead_id(Request $request){

    try {

      $response_array = array('status' => 0,  'message' => trans('pages.something_wrong') );

      $validation_rules = [
          'lead_id' => 'required',
      ];

      $validator = Validator::make( $request->all(), $validation_rules );

      if($validator->fails()) {

          return response()->json(['status' => 0, 'message' => implode(',', $validator->messages()->all()) ]);

      } else {

        $lead = Lead::where('id', $request->lead_id)->first();

        if($lead){

          $lead_product = LeadProduct::where('lead_id', $request->lead)->get();

        }

        $response_array = array('status' => 1,  'message' => "Lead get details sucessfully.", 'data' => $lead);

      }

      return response()->json($response_array, 200);

    }catch(\Exception $e) {

      return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);

    }

   }

   public function get_product_list(Request $request){

      try {

          $main_query =  Product::from('product as pro')
                                ->where('is_active',1)
                                ->select('pro.id','pro.value','pro.price_difference','pro.is_primary')
                                ->orderBy('id','desc');

          if(!empty($request->search)){

              $search_query = $main_query->where('pro.value','LIKE',"%{$request->search_string}%")
                                          ->orWhere('pro.price_difference','LIKE',"%{$request->search_string}%");

          }

          $main_query = $main_query->paginate(isset($request->size) ? $request->size : 10);

          $data['list'] = $main_query->all();
          $data['total_pages'] = $main_query->lastPage();

          return response()
              ->json(["status" => 1, "message" => "Product list with search text.", "data" => $data]);


      }catch(\Exception $e) {

        return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);

      }

   }


}
