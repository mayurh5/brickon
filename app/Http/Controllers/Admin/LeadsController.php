<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CommonRepository as CommonRepo;
use App\Repositories\LeadsRepository as LeadsRepo;

class LeadsController extends Controller
{
  public function index(Request $request)
  {
    return LeadsRepo :: get_list_leads($request);
  }

  public function create(Request $request)
  {
    return LeadsRepo :: create($request);
  }
}
