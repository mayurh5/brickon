<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
  public function index(Request $request){

    return view('admin.contact_us.index');

  }
}
