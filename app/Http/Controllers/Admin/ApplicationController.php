<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index(Request $request){

      return view('admin.application.index');

    }

    public function create(Request $request){

      return view('admin.application.create');

    }
}
