<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Member;
use App\Models\Address;
use App\Models\Product;
use App\Models\KYC;
use App\Models\Contact;
use App\Models\Lead;

use Illuminate\Http\Request;

class DashboardController extends Controller
{


    public function dashboardEcommerce(){

      $user = User::where(['association_type' => config('global.user_type.member')])->count();
      $product = Product::count();
      $lead_total = Lead::sum('final_total');

      $members = Member::from('member')
                        ->where('member.is_active',1)
                        ->orderBy('member.id','DESC')
                        ->leftjoin('users as u','u.association_id','=','member.id')
                        ->where('u.association_type', config('global.user_type.member'))
                        ->leftjoin('kyc_info as kyc','kyc.user_id','=','u.id')
                        ->select('member.*','kyc.gst_number','kyc.pan_number')
                        ->limit(10)
                        ->get();

      $leads = Lead::from('lead')
                    ->where('lead.status',config('global.status.pending'))
                    ->leftjoin('users as u','u.id','=','lead.user_id')
                    ->leftjoin('member','member.id','=','u.association_id')
                    ->where('u.association_type', config('global.user_type.member'))
                    ->select('lead.id','lead.order_code','lead.due_date','lead.primary_product_price','lead.status','lead.total','lead.final_total','lead.order_date','member.first_name','member.last_name')
                    ->orderBy('lead.created_at','DESC')
                    ->limit(10)
                    ->get();

      $data = [
          'user' => $user,
          'product' => $product,
          'lead_total' => $lead_total,
          'members' => $members,
          'leads' => $leads
      ];

        return view('admin.dashboard', compact('data'));
    }


}
