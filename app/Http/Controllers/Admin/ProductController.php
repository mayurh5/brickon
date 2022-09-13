<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
  public function index(){

    return view('admin.product.index');

  }

  public function create(Request $request){

    return view('admin.product.create');

  }

  public function view(Request $request){

    return view('admin.product.view');

  }
}
