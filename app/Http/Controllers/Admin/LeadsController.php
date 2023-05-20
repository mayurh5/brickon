<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CommonRepository as CommonRepo;
use App\Repositories\LeadsRepository as LeadsRepo;
use App\Models\Lead;
use App\Models\Product;
use App\Models\LeadProduct;
use App\Models\Charges;
use App\Models\LeadCharges;
use App\Models\LeadStatus;
use Log;

class LeadsController extends Controller
{
  public function index(Request $request)
  {
    return LeadsRepo :: get_list_leads($request);
  }

  public function create(Request $request)
  {
    return LeadsRepo :: create($request);
  }


  public function get_lead_list_json(Request $request)
  {
    return LeadsRepo :: get_lead_list($request);
  }

  public function view($id){

    if (Lead::where('id', $id)->exists()) {

      $lead = Lead::from('lead')
                  ->where('lead.id', $id)
                  ->leftjoin('users as u','u.id','=','lead.user_id')
                  ->leftjoin('member as m','m.id','=','u.association_id')
                  ->where('u.association_type',config('global.user_type.member'))
                  ->select('lead.*','m.id as member_id','m.first_name','m.last_name','m.email','m.phone')
                  ->first();


      if($lead){

        $lead_product = LeadProduct::from('lead_product_details as product')
                                    ->where('product.lead_id', $lead->id)
                                    ->with('product_details')
                                    ->select('product.*')
                                    ->get();

        $lead['product'] = $lead_product;

      }

      return view('admin.leads.view', compact('lead'));

    } else {
      return redirect()->route('leads.index')->with('error', 'Lead not found!');
    }

  }

  public function status_update(Request $request){

      $lead = Lead::where('id', $request->lead_id)->first();

      if($lead){

        \Helper::store_lead_status($request);

        $lead->status = $request->status_action;
        $lead->save();

      }

      if ($request->status_action == config('global.status.confirmed')) {
        $message = "Order status has been ".config('global.status.confirmed')."";
      } else if ($request->status_action == config('global.status.cancelled')){
        $message = "Order status has been ".config('global.status.cancelled')."";
      } else {
        $message = "Order status has been ".config('global.status.completed')."";
      }

      $response_array = array('success' => 1,  'message' => $message );

      return response()->json($response_array, 200);

  }

}
