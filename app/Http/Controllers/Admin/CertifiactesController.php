<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CertifiactesController extends Controller
{
  public function index(Request $request){

    return view('admin.certificates.index');

  }

  public function create(Request $request){

    return view('admin.certificates.create');

  }

}
