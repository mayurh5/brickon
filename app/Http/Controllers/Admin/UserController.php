<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Member;
use App\Models\KYC;
use App\Models\Address;
use App\Models\Role;
use App\Models\UserRole;
use Validator;
use Log;

class UserController extends Controller
{
    public function index(){

      return view('admin.users.index');

    }

    public function create($id = ''){

      $role_list = Role::where('is_active',1)->get(['role_id','role_name']);

      if(!empty($id)){

        $user_details = User::find($id);
        $user_role = UserRole::where('user_id', $id)->first('role_id');

        $user_details['role_id'] = @$user_role->role_id;


        return view('admin.users.create', compact('role_list','user_details'));
      }

      return view('admin.users.create', compact('role_list'));

    }

    public function view(Request $request, $id){

      if (Member::where('id', $id)->exists()) {

        $member_details = Member::from('member as mem')
                        ->where('mem.id', $id)
                        ->leftjoin('users as u','u.association_id','=','mem.id')
                        ->where('u.association_type',config('global.user_type.member'))
                        ->select('mem.*','u.kyc_id','u.address_id','u.id as user_id')
                        ->first();

        $member_details['kyc'] = KYC::where('user_id', $member_details->user_id)->first();
        $member_details['address'] = Address::where('user_id', $member_details->user_id)->first();

        // dd($member_details);
        return view('admin.users.view',compact('member_details'));


      } else {
        return redirect()->route('users.index')->with('error', 'User not found!');
      }
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
                                       ])
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

    public function web_user_json_list(Request $request){

      try {
        // Log::info("message". print_r($request->all(),true));
        $page_index = (int)$request->input('start') > 0 ? ($request->input('start') / $request->input('length')) + 1 : 1;

        $limit = (int)$request->input('length') > 0 ? $request->input('length') : DEFAULT_RECORDS_LIMIT;
        $columnIndex = $request->input('order')[0]['column']; // Column index
        $columnName = $request->input('columns')[$columnIndex]['data']; // Column name
        $columnSortOrder = $request->input('order')[0]['dir']; // asc or desc value

        $main_query =  User::from('users')
                              ->where(['users.is_active' => 1])
                              ->where('users.association_type','!=',config('global.user_type.member'))
                              ->select('users.*')
                              ->orderBy($columnName, $columnSortOrder);

                    $data_list_for_count = $main_query->get();  // group by and direct count not working
                    $recordsTotal = count($data_list_for_count);

                    $recordsFiltered = $recordsTotal;

                    if(empty($request->input('search.value'))){

                        $appointments = $main_query->paginate($limit, ['*'], 'page', $page_index);

                    }else {

                        $search = $request->input('search.value');

                        $search_query = $main_query->where('users.first_name','LIKE',"%{$search}%")
                                                    ->orWhere('users.last_name','LIKE',"%{$search}%")
                                                    ->orWhere('users.user_name','LIKE',"%{$search}%")
                                                    ->orWhere('users.mobile_no','LIKE',"%{$search}%")
                                                    ->orWhere('users.display_name','LIKE',"%{$search}%");

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

    public function store(Request $request){

      try {

        if(!empty($request->user_id)){

          $validation_rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,user_name,'.$request->user_id.',id',
            'display_name' => 'required',
            'mobile_no' => 'required',
            'role_type' => 'required'
          ];

        }else{

          $validation_rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,user_name',
            'display_name' => 'required',
            'mobile_no' => 'required',
            'role_type' => 'required',
            'password' => 'min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:6'
          ];

        }



        $validator = Validator::make( $request->all(), $validation_rules );

        if($validator->fails()) {

            return response()->json(['status' => 0, 'message' => implode(',', $validator->messages()->all()) ]);

        }else{

                $auth_user_id = \Helper:: get_auth_user();

                if(isset($request->user_id)){

                  $user = User::find($request->user_id);
                  $user->user_name = $request->email;
                  $user->first_name = $request->first_name;
                  $user->last_name = $request->last_name;
                  $user->display_name = $request->display_name;
                  $user->mobile_no = $request->mobile_no;
                  $user->save();

                } else {

                  $user = new User;
                  $user->association_id = NULL;
                  $user->association_type = isset($request->role_type) ? \Helper::get_role_name($request->role_type)->role_name : NULL;
                  $user->password =  bcrypt($request->password); // Hash::make(Str::random(8))
                  $user->company_name = "Brickon";
                  $user->user_name = $request->email;
                  $user->first_name = $request->first_name;
                  $user->last_name = $request->last_name;
                  $user->display_name = $request->display_name;
                  $user->mobile_no = $request->mobile_no;
                  $user->save();

                  $user->association_id = $user->id;
                  $user->save();

                }

                $user_id = $user->id;


                if(isset($user_id) && !empty($user_id)){

                  $role = $request->role;

                  if (!empty($request->user_id)) {
                    UserRole::where('user_id',$request->user_id)->delete();
                  }

                  $user_role = new UserRole;

                  $user_role->user_id = $user_id;
                  $user_role->role_id = $request->role_type;
                  $user_role->created_by = $auth_user_id;
                  $user_role->save();

              }

              return response()->json( [ 'success' => 1, !empty($request->user_id) ? 'User updated successfully!' : 'User created successfully!', 'redirect_url' => route('users.index')], 200 );

        }

      } catch (\Throwable $exception) {

          return redirect()->route('users.index')->with(["success" => 0, "message" => $exception->getMessage()]);

      }

    }

    public function change_password(Request $request){

      return view('admin.change_password.password');

    }

    public function admin_change_password(Request $request){

      $user = auth()->user();
      
      if ($user)
      {

          if (password_verify($request->current_password, $user->password))
          {


              if($request->new_password == $request->con_password){

                  $postArray = ['password' => bcrypt($request->new_password) ];

                  $login = User::where('id', $user->id)
                      ->update($postArray);
                  $user = User::where('id', $user->id)
                      ->first();

              }else{
                  return redirect()->back()->with('error', 'Your Re-type password not matched.');
              }

              if ($login)
              {

                return redirect()->back()->with('message', 'Your password successfully changed.');
              }
          }
          else
          {
            return redirect()->back()->with('error', 'Old Password is invalid, Please enter valid password!.');
          }
      }
      else
      {
        return redirect()->route('admin.dashboard')->with('error', 'The error message here!');
      }
 }


}
