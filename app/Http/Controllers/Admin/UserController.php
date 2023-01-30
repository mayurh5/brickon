<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Member;
use Validator;
use Log;

class UserController extends Controller
{
    public function index(){

      return view('admin.users.index');

    }

    public function create(Request $request){

      return view('admin.users.create');

    }

    public function view(Request $request, $id){

      return view('admin.users.view');

    }

    public function user_json_list(Request $request){

      try {
        // Log::info("message". print_r($request->all(),true));
        $page_index = (int)$request->input('start') > 0 ? ($request->input('start') / $request->input('length')) + 1 : 1;

        $limit = (int)$request->input('length') > 0 ? $request->input('length') : DEFAULT_RECORDS_LIMIT;
        $columnIndex = $request->input('order')[0]['column']; // Column index
        $columnName = $request->input('columns')[$columnIndex]['data']; // Column name
        $columnSortOrder = $request->input('order')[0]['dir']; // asc or desc value

        $main_query =  Member::from('member')
                              ->where(['member.is_active' => 1,
                                       'member.is_deleted' => 0,
                                       'member.role_type' => config('global.user_type.member')])
                              ->select('member.*')
                              ->orderBy($columnName, $columnSortOrder);

                    $data_list_for_count = $main_query->get();  // group by and direct count not working
                    $recordsTotal = count($data_list_for_count);

                    $recordsFiltered = $recordsTotal;

                    if(empty($request->input('search.value'))){

                        $appointments = $main_query->paginate($limit, ['*'], 'page', $page_index);

                    }else {

                        $search = $request->input('search.value');

                        $search_query = $main_query->where('member.first_name','LIKE',"%{$search}%")
                                                    ->orWhere('member.last_name','LIKE',"%{$search}%")
                                                    ->orWhere('member.email','LIKE',"%{$search}%")
                                                    ->orWhere('member.phone','LIKE',"%{$search}%")
                                                    ->orWhere('member.display_name','LIKE',"%{$search}%");

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

        Log::info("UserController index - ". $e->getMessage());
        return redirect()->route('dashboard')->with(['error' => "Something want wrong.", 'status' => 0]);

      }

    }
}
