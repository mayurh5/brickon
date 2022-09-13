<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
  public function index(){

    return view('admin.distributor.index');

  }

  public function create(Request $request){

    return view('admin.distributor.create');

  }
}
