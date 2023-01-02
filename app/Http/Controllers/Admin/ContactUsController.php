<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Validator;
use Log;

class ContactUsController extends Controller
{
  public function index(Request $request){

    $web_setting = Contact::first();

    return view('admin.contact_us.index',compact('web_setting'));

  }

  public function update(Request $request){

    try {

      $setting = Contact::where('id', $request->id)->first();

      if($setting){

        $setting->email = $request->email;
        $setting->mobile = $request->mobile;
        $setting->website = $request->website;
        $setting->facebook = $request->facebook;
        $setting->twitter = $request->twitter;
        $setting->linkedin = $request->linkedin;
        $setting->instagram = $request->instagram;
        $setting->address = $request->address;
        $setting->save();

        return redirect()->route('contact_us.index')->with('message', 'Web settings updated sucessfully!');
      }

    }catch(\Exception $e) {

      Log::info("ContactUsController update - ". $e->getMessage());
      return redirect()->route('contact_us.index')->with(['error' => "Something want wrong.", 'status' => 0]);

    }
  }

}
