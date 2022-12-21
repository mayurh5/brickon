<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Certificate;
use Validator;
use Log;

class CertifiactesController extends Controller
{
  public function index(Request $request){

    return view('admin.certificates.index');

  }

  public function create(Request $request){

    return view('admin.certificates.create');

  }

  public function store(Request $request){

    try {

      $validator = Validator::make($request->all(), [

        'title' => 'required',
        'certificate_doc' => 'required'

      ]);

      if ($validator->fails()) {

          $errorMessage = implode(',', $validator->errors()->all());
          return response()->json( [ 'success' => 0, 'message' => $errorMessage ] );

      } else {

            $certificate = new Certificate;
            $certificate->certificate_name = $request->title;


            if ($request->hasFile('certificate_doc')){

                $file = $request->file('certificate_doc');
                $file_name_to_store = time();
                $file_uploaded_path ='images/certificate';

                $file_path = \Helper::upload_file($file, "", $file_name_to_store, $file_uploaded_path, $is_base64_file = false);
                $certificate->certificate_file_path = $file_path;


            }

              $certificate->save();

              return response()->json( [ 'success' => 1, 'message' => 'Certificated Added successfully!', 'redirect_url' => route('certifiactes.index')], 200 );
      }

    }catch(\Exception $e) {
      Log::info("CertifiactesController store - ". $e->getMessage());
      return redirect()->route('certifiactes.index')->with(['error' => "Something want wrong.", 'status' => 0]);

    }
  }

  public function certificate_list_json(Request $request)
  {
    try {

            $page_index = (int)$request->input('start') > 0 ? ($request->input('start') / $request->input('length')) + 1 : 1;

            $limit = (int)$request->input('length') > 0 ? $request->input('length') : DEFAULT_RECORDS_LIMIT;
            $columnIndex = $request->input('order')[0]['column']; // Column index
            $columnName = $request->input('columns')[$columnIndex]['data']; // Column name
            $columnSortOrder = $request->input('order')[0]['dir']; // asc or desc value

            $main_query =  Certificate::from('mst_certificate')
                                  ->select('mst_certificate.*')
                                  ->orderBy($columnName, $columnSortOrder);

            $data_list_for_count = $main_query->get();  // group by and direct count not working
            $recordsTotal = count($data_list_for_count);

            $recordsFiltered = $recordsTotal;

            if(empty($request->input('search.value'))){

                $appointments = $main_query->paginate($limit, ['*'], 'page', $page_index);

            }else {

                $search = $request->input('search.value');

                $search_query = $main_query->where('certificate_name','LIKE',"%{$search}%")
                                            ->orWhere('certificate_detail','LIKE',"%{$search}%");

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
      Log::info("CertifiactesController index - ". $e->getMessage());
      return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);

    }
  }

}

