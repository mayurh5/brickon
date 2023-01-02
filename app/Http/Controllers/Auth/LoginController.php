<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Illuminate\Support\Str;
use Auth;
use Carbon\Carbon;
use Log;
use Hash;
use Exception;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Login
    public function show_login_form()
    {
      return view('auth.login');

    }

    public function login(Request $request){

      try{

          $credentials = $request->only('user_name', 'password');

          if (Auth()->attempt($credentials)) {

              $user = Auth::user();

              if($user && in_array($user->association_type, ["admin"])){

                  // if($user->association_type_term == config('custom.association_type_term.admin')){

                  return response()->json(['success' => 1, 'message' => trans('auth.success_login'), 'redirect_url' => route('dashboard')]);

              }
              else{
                  Auth::logout();
                  return response()->json(['success' => 0, 'message' => trans('auth.failed')]);
              }

          }else{

              return response()->json(['success' => 0, 'message' => trans('auth.failed')]);
          }

      }
      catch(Exception $exception)
      {
          Log::info(print_r($exception->getmessage(),true));
          return response()->json(['success' => 0, 'message' => 'Something went wrong']);
      }

    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }

}
