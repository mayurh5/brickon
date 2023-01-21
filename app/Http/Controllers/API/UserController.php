<?php

namespace App\Http\Controllers\API;

use App\Repositories\CommonRepository as CommonRepo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Member;
use App\Models\Address;
use App\Models\MobileOtp;
use App\Models\KYC;
use Illuminate\Support\Facades\Hash;
use Validator;
use Log;

class UserController extends Controller
{

  private $apiToken;
  public function __construct()
  {
      $this->apiToken = uniqid(base64_encode(str_random(130)));
  }

  public function send_otp(Request $request){

    try {

      // if ($request->is_for_login == 1) {

        // if (Member::where('phone', $request->mobile)->where('is_active',1)->exists()){

          $validator = Validator::make($request->all() , ['mobile' => 'required', ]);

            if ($validator->fails()){

              return response()->json(['status' => 0, 'message' => implode(',', $validator->messages()->all()) ]);

            }

            do
            {
                $refrence_id = mt_rand(1000, 9999);
            }
            while (MobileOtp::where('otp', $refrence_id)->exists());

            $sendOtp = new MobileOtp;
            $sendOtp->mobile = $request->mobile;
            $sendOtp->otp = $refrence_id;
            $sendOtp->save();

            $response_array = array('status' => 1,  'message' => "Sent otp in your mobile.", 'data' => $sendOtp );
        // } else {
        //   $response_array = array('status' => 0,  'message' => "User not found." );
        // }

      // } else {

      //   if (Member::where('phone', $request->mobile)->where('is_active',1)->exists())
      //   {
      //       $response_array = array('status' => 0,  'message' => "This mobile number is already uses, Please try another number." );

      //   } else {

      //     $validator = Validator::make($request->all() , ['mobile' => 'required', ]);

      //     if ($validator->fails()){

      //       return response()->json(['status' => 0, 'message' => implode(',', $validator->messages()->all()) ]);

      //     } else {

      //       do
      //       {
      //           $refrence_id = mt_rand(1000, 9999);
      //       }
      //       while (MobileOtp::where('otp', $refrence_id)->exists());

      //       $sendOtp = new MobileOtp;
      //       $sendOtp->mobile = $request->mobile;
      //       $sendOtp->otp = $refrence_id;
      //       $sendOtp->save();

      //       $response_array = array('status' => 1,  'message' => "Please check your mobile device.", 'data' => $sendOtp );
      //     }
      //   }

      // }

      return response()->json($response_array, 200);

    }catch(\Exception $e) {

      return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);

    }

  }

  public function verify_otp(Request $request){

    try {

      if (MobileOtp::where('mobile', $request->mobile)->exists()){

        $validator = Validator::make($request->all() , ['mobile' => 'required', 'otp' => 'required', ]);

        if ($validator->fails()) {

          return response()->json(['status' => 0, 'message' => implode(',', $validator->messages()->all()) ]);

        } else {

          $verify_otp = MobileOtp::where('mobile', $request->mobile)
                                ->where('otp', $request->otp)
                                ->orderBy('id', 'DESC')
                                ->first();

          if (isset($verify_otp)){

            $user = Member::where('phone', $request->mobile)->first();

            if($user){

              $user->fcm_token = $request->fcm_token;
              $user->auth_token = $this->apiToken;
              $user->save();

              return response()->json(["status" => 1, "message" => "Your otp sucessfully.", "data" => ['is_verifed' => 1,'user_id' => $user->id, 'auth_token' => $user->auth_token]]);
            }

              return response()->json(["status" => 1, "message" => "Your otp sucessfully.", "data" => ['is_verifed' => 1,'user_id' => null, 'auth_token' => null]]);
          }
          else {

              return response()->json(["status" => 0, "message" => "Please enter valid OTP code.", "data" => ['is_verifed' => 0]]);
          }

        }

      } else {

        return response()->json(["status" => 0, "message" => "User not found."]);

      }

    } catch (\Exception $e) {

      return response()->json(['status' => 0, 'message' => $e->getMessage()]);

    }

  }

  public function register(Request $request) {

    try{

        $response_array = array('status' => 0,  'message' => trans('pages.something_wrong') );

        $validation_rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'mobile' => 'required|unique:member,phone',
        ];

        $validator = Validator::make( $request->all(), $validation_rules );

        if($validator->fails()) {

            return response()->json(['status' => 0, 'message' => implode(',', $validator->messages()->all()) ]);

        }else{

            $member = new Member;
            $member->first_name = $request->first_name;
            $member->last_name = $request->last_name;
            $member->email = $request->email;
            $member->phone = $request->mobile;
            $member->display_name = \Helper::UniqueUserName($request->first_name,$request->last_name);
            $member->auth_token = $this->apiToken;
            $member->fcm_token = $request->fcm_token;
            $member->role_type = config('global.user_type.member'); // as per logic
            $member->is_active = 1;
            $member->save();

            if($member){

            $user = new User;
            $user->association_id = $member->id;
            $user->association_type = config('global.user_type.member');
            $user->password =  bcrypt('123456'); // Hash::make(Str::random(8))
            $user->company_name = $request->company_name;
            $user->user_name = $request->mobile;
            $user->designation = $request->designation;
            $user->save();

            CommonRepo::save_location_details($request, $user->id);
            CommonRepo::save_kyc_details($request, $user->id);

            $user['member'] = $member;

            $response_array = array('status' => 1,  'message' => trans('pages.signup_success'), 'data' => $user );

            }


            return response()->json($response_array, 200);
        }
    }catch(\Exception $e) {

        return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);

    }
  }

  // public function login(Request $request)
  // {
  //   try {

  //     $response_array = array('status' => 0,  'message' => trans('pages.something_wrong') );

  //     $validation_rules = [
  //         'user_name' => 'required',
  //     ];

  //     $validator = Validator::make( $request->all(), $validation_rules );

  //     if($validator->fails()) {

  //         return response()->json(['status' => 0, 'message' => implode(',', $validator->messages()->all()) ]);

  //     } else {
  //       $user = User::where('mobile_no', $request->user_name)->first();

  //       if ($user) {

  //         if (!in_array($user->association_type_term, [config('global.user_type.member')])) {

  //             $response_array = array('status' => 0, 'message' => trans('auth.username_failed'));

  //         } else {

  //             if (!Hash::check($request->password, $user->password)) {

  //                 $response_array = ['status' => 0, 'message' => trans('auth.password')];

  //             } else {

  //                 if (!$user->is_active) {

  //                     $response_array = array('status' => 0, 'message' => trans('auth.inactive_account'));

  //                 } else {

  //                   $postArray = ['token' => $this->apiToken, 'fcm_token' => $request->fcm_token];

  //                   $login = User::where('id', $user->user_id)->update($postArray);


  //                     $response_array = array('status' => 1,  'message' => trans('auth.login_success'), 'data' => $user);

  //                 }
  //             }

  //         }
  //     } else {

  //         $response_array = array('status' => 0, 'message' => trans('auth.username_failed'));
  //     }

  //     }

  //     return response()->json($response_array, 200);

  //   }catch(\Exception $e) {

  //     return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);

  //   }
  // }

  public function logout(Request $request)
  {
      try
      {

          if (Member::where('id', $request->user_id)
              ->exists())
          {

              $postArray = ['auth_token' => null, 'fcm_token' => null];

              $logout = Member::where('id', $request->user_id)
                  ->update($postArray);

              if ($logout)
              {
                  return response()->json(['status' => 1, 'message' => 'User Logged Out.']);
              }
          }
          else
          {
            return response()->json(['status' => 0, 'message' => "Record not found." ]);
          }

      }
      catch(Exception $exception)
      {
          return response()->json(["status" => 0, "message" => "Somthing went wrong", "data" => (object)[]]);
      }

  }

  public function get_user_details_by_id(Request $request)
  {
      if (Member::where('id', $request->user_id)->exists())
      {

          $member = Member::where('id',$request->user_id)->first();


          $user = User::where(['association_id' => $member->id,
                               'association_type' => config('global.user_type.member')])
                        ->first();

          if($user){
            $user['address'] = Address::where('user_id', $user->id)->first();
          }

          $user['member'] = $member;

          // $user = User::where(['id' => $request->user_id])->first();

          // $member['profile_pic'] = $user->profile_pic;

                        // ->first(['first_name','last_name','mobile_no','email','compony_name','designation_term','state','city','profile_pic']);

          return response()->json(["status" => 1, "message" => "User details get by id.", "data" => $user]);
      }
      else
      {
          return response()->json(["status" => 0, "message" => "User not found!"]);
      }
  }

  public function update_user_details_by_id(Request $request)
  {

      try {

        $validator = Validator::make(
            $request->all(),
            [
              'user_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                // 'mobile_no' => 'required|unique:member,phone,'.$request->user_id.',member_id',
                'email' => 'required',
            ]
        );

        if ($validator->fails()) {

            $response_array = ['status' => 0, 'message' => implode(',', $validator->messages()->all()), 'is_valid' => false];

        } else {

          $user = User::where(['association_id' => $request->user_id,
                               'association_type' => config('global.user_type.member')])
                        ->first();

          $member = Member::where('id',$user->association_id)->first();

          if($member && $user){

              $member->first_name = $request->first_name;
              $member->last_name = $request->last_name;
              $member->email = $request->email;

              CommonRepo::save_location_details($request, $user->id);

              // if ($request->hasFile('profile_pic')){
                if ($request->profile_pic){

                    $old_file = $member->profile_pic;

                    if(!empty($old_file)){
                          // Remove old file
                          \Helper::unlink_document($old_file);
                    }

                    $file = $request->file('profile_pic');
                    $file_name_to_store = time();
                    $file_uploaded_path ='images/member';

                    $file_path = \Helper::upload_file($file, "", $file_name_to_store, $file_uploaded_path, $is_base64_file = false);

                    $member->profile_pic = $file_path;
                }


              $member->save();
              $response_array = array('status' => 1,  'message' => trans('pages.action_success') , "data" => $member);

          } else {
            $response_array = array('status' => 0,  'message' => trans('pages.something_wrong') );
          }

        }

        return response()->json($response_array, 200);

      } catch (\Exception $e) {

        return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);

      }

  }

  public function get_kyc_details(Request $request){
    try {

      $validator = Validator::make($request->all() , ['user_id' => 'required', ]);

      if ($validator->fails()){

        return response()->json(['status' => 0, 'message' => implode(',', $validator->messages()->all()) ]);

      } else {

        $user = User::where(['association_id' => $request->user_id,
                            'association_type' => config('global.user_type.member')])
                    ->first();

              if($user){

                $kyc = KYC::where('user_id', $user->id)->first();

                if($kyc){

                  $response_array = array('status' => 1,  'message' => trans('pages.action_success') , "data" => $kyc);

                } else{
                  $response_array = array('status' => 0,  'message' => "Kyc details not found." );
                }

              } else {
                $response_array = array('status' => 0,  'message' => "User not found." );
              }

              return response()->json($response_array, 200);
      }

    } catch (\Exception $e) {

      return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);

    }
  }

  public function update_kyc_details(Request $request){
    try {

      $validator = Validator::make($request->all() , ['user_id' => 'required', ]);

      if ($validator->fails()){

        return response()->json(['status' => 0, 'message' => implode(',', $validator->messages()->all()) ]);

      } else {

        $user = User::where(['association_id' => $request->user_id,
                            'association_type' => config('global.user_type.member')])
                    ->first();

              if($user){

               $kyc =  CommonRepo::save_kyc_details($request, $user->id);
               
                $response_array = array('status' => 1,  'message' => "Kyc details updated successfully done.", 'data' => $kyc );

              } else {
                $response_array = array('status' => 0,  'message' => "User not found." );
              }

              return response()->json($response_array, 200);
      }

    } catch (\Exception $e) {

      return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);

    }
  }

}
