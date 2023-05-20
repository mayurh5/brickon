<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Right;
use App\Models\UserRole;
use App\Models\Role;
use App\Models\RoleRight;
use DB;
use Log;

class RoleRightController extends Controller
{
    public function index(){

        try{
            return view('admin.role.index');
        }
        catch(Exception $exception)
        {
            return redirect()->back()->with(["success" => 0, "message" => $exception->getMessage()]);
        }
    }

    public function create($id = ''){

        try{

          $user_type = config('global.user_type');

            if(!empty($id)){

              $role_details = Role::find($id);
              return view('admin.role.create',compact('user_type','role_details'));

            }


            return view('admin.role.create',compact('user_type'));
        }
        catch(Exception $exception)
        {
            return redirect()->back()->with(["success" => 0, "message" => $exception->getMessage()]);
        }
    }

    public function get_right_list(request $request){

      try{

            $final_array = array();

            $main_array = array(
              'parent_right_id' => 0,
              'parent_right_name' => 'Setup'
            );

              $parent_right = Right::select('right.right_id as child_right_id','right.form_title as child_right_name','right.order_no')
                                      ->from('mst_right as right')
                                      ->where('right.is_active', 1)
                                      ->orderBy(DB::raw('ISNULL(right.order_no), right.order_no'), 'ASC')
                                      ->distinct();

              if(isset($request->role_id) && !empty($request->role_id)){

                  $role_id = $request->role_id;

                  $parent_right = $parent_right->addSelect(

                      DB::raw("(SELECT mst_role_right.is_view FROM mst_role_right WHERE mst_role_right.role_id = '".$role_id."' AND mst_role_right.right_id = right.right_id) as is_view"),
                      DB::raw("(SELECT mst_role_right.is_create FROM mst_role_right WHERE mst_role_right.role_id = '".$role_id."' AND mst_role_right.right_id = right.right_id) as is_create"),
                      DB::raw("(SELECT mst_role_right.is_update FROM mst_role_right WHERE mst_role_right.role_id = '".$role_id."' AND mst_role_right.right_id = right.right_id) as is_update"),
                      DB::raw("(SELECT mst_role_right.is_delete FROM mst_role_right WHERE mst_role_right.role_id = '".$role_id."' AND mst_role_right.right_id = right.right_id) as is_delete"),
                      DB::raw("(SELECT mst_role_right.is_export FROM mst_role_right WHERE mst_role_right.role_id = '".$role_id."' AND mst_role_right.right_id = right.right_id) as is_export")
                  );
              }

              $parent_right = $parent_right->get()->toArray();

              $main_array['child_right'] = $parent_right;

              $final_array[] = $main_array;

          return response()->json(['success' => 1 , 'data' =>  $final_array, 'message' => trans('Response send successfully.')] );

      }
      catch(Exception $exception)
      {
          // return response()->json(['success' => 0 ,'error' => trans('pages.something_wrong')] );
          return response()->json(['success' => 0 ,'error' => $exception->getMessage()] );
      }

    }

    public function store(request $request){

      try {

        $auth_user_id = \Helper:: get_auth_user();
        $id = $request->id;

        if(empty($id)){

            $role = new Role;
            $role->role_name = $request->role_name;
            $role->role_detail = $request->role_detail;
            $role->created_by = $auth_user_id;

            $role->save();
        }
        else{

            $role = Role::findOrfail($id);

            $role->role_name = $request->role_name;
            $role->role_detail = $request->role_detail;
            $role->updated_by = $auth_user_id;

            $role->update();

        }

        $role_right = $request->role_right;
        $role_right_array = json_decode($role_right);

        if (count($role_right_array) > 0) {

            $role_id = $role->role_id;

            if(!empty($id)){
                RoleRight::where('role_id', $role_id)->delete();
            }

            if(isset($role_id) && !empty($role_id)){

                foreach ($role_right_array as $key => $value) {

                    $role_right = new RoleRight;
                    $role_right->role_id = $role_id;
                    $role_right->right_id = $value->right_id;
                    $role_right->is_view = $value->is_view;
                    $role_right->is_create = $value->is_create;
                    $role_right->is_update = $value->is_update;
                    $role_right->is_delete = $value->is_delete;
                    $role_right->is_export = $value->is_export;

                    $role_right->save();
                }
            }
        }

        if(empty($id)){
            return redirect()->route('roles.index')->with(['message' => 'Role created successfully!', 'success' => 1]);

        }
        else{
            return redirect()->route('roles.index')->with(['message' => 'Role updated successfully!', 'success' => 1]);

        }
      } catch (\Throwable $th) {

        return redirect()->route('roles.index')->with(["success" => 0, "message" => $exception->getMessage()]);

      }

    }

    public function get_role_list_json(Request $request){

      try{

          $page_index = (int)$request->input('start') > 0 ? ($request->input('start') / $request->input('length')) + 1 : 1;

          $limit = (int)$request->input('length') > 0 ? $request->input('length') : DEFAULT_RECORDS_LIMIT;
          $columnIndex = $request->input('order')[0]['column']; // Column index
          $columnName = $request->input('columns')[$columnIndex]['data']; // Column name
          $columnSortOrder = $request->input('order')[0]['dir']; // asc or desc value

          $main_query = Role::select('role.*')
                              ->from('mst_role as role')
                              ->orderBy($columnName, $columnSortOrder);

          $data_list_for_count = $main_query->get();  // group by and direct count not working

          $recordsTotal = count($data_list_for_count);
          $recordsFiltered = $recordsTotal;

          if(empty($request->input('search.value'))){

              $appointments = $main_query->paginate($limit, ['*'], 'page', $page_index);

          }else {

              $search = $request->input('search.value');

              $search_query = $main_query->where('role.role_name','LIKE',"%{$search}%")
                                          ->orWhere('role.role_detail', 'LIKE',"%{$search}%");

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

          // log::info(print_r($response,true));
          return response()->json($response, 200);

      }catch(Exception $e) {
          //Log::info('log '. print_r($e->getMessage(), true));
         return response()->json(['success' => 0, 'message' => trans('pages.something_wrong')]);

      }
    }

    public function change_status(Request $request)
    {
        try{

            $role = Role::find($request->id);
            $role->is_active = $request->is_active;
            $role->save();

            return 1;
        }
        catch(Exception $exception)
        {
            return redirect()->back()->with(["success" => 0, "message" => $exception->getMessage()]);
        }
    }



}
