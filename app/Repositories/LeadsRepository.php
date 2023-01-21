<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Repositories\CommonRepository as CommonRepo;
use App\Models\Lead;
use App\Models\User;
use App\Models\LeadProduct;
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

  public static function get_lead_list(Request $request){

    try {

      $page_index = (int)$request->input('start') > 0 ? ($request->input('start') / $request->input('length')) + 1 : 1;

      $limit = (int)$request->input('length') > 0 ? $request->input('length') : DEFAULT_RECORDS_LIMIT;
      $columnIndex = $request->input('order')[0]['column']; // Column index
      $columnName = $request->input('columns')[$columnIndex]['data']; // Column name
      $columnSortOrder = $request->input('order')[0]['dir']; // asc or desc value

      $main_query =  Lead::from('lead')
                            ->leftjoin('users as u','u.id','=','lead.user_id')
                            ->leftjoin('member as m','m.id','=','u.association_id')
                            ->where('u.association_type', config('global.user_type.member'))
                            ->select('lead.*','m.first_name','m.last_name','m.phone')
                            ->orderBy($columnName, $columnSortOrder);

            $data_list_for_count = $main_query->get();  // group by and direct count not working
            $recordsTotal = count($data_list_for_count);

            $recordsFiltered = $recordsTotal;

            if(empty($request->input('search.value'))){

                $appointments = $main_query->paginate($limit, ['*'], 'page', $page_index);

            }else {

                $search = $request->input('search.value');

                $search_query = $main_query->where('m.first_name','LIKE',"%{$search}%")
                                            ->orWhere('m.last_name','LIKE',"%{$search}%")
                                            ->orWhere('m.phone','LIKE',"%{$search}%")
                                            ->orWhere('lead.created_at','LIKE',"%{$search}%");

                $appointments = $search_query->paginate($limit, ['*'], 'page', $page_index);

                $search_list_for_count = $search_query->get();  // group by and direct count not working

                $recordsFiltered = count($search_list_for_count);

            }

            $response = array(
                "draw" => (int)$request->input('draw'),
                "recordsTotal" => (int)$recordsTotal,
                "recordsFiltered" => (int)$recordsFiltered,
                "data" => $appointments->getCollection()
            );

          return response()->json($response, 200);



    }catch(\Exception $e) {
      Log::info("CertifiactesController index - ". $e->getMessage());
      return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);

    }
  }



}
