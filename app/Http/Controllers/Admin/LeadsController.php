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

      $lead = Lead::where('id', $id)->with('user_details')->first();

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

    }

  }

  public function status_update(Request $request){

    Log::info("status_update ". print_r($request->all(),true));


  }

}
