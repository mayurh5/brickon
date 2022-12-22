<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assets;
use Validator;
use Log;

class ApplicationController extends Controller
{
    public function index(Request $request){

      return view('admin.application.index');

    }

    public function create($id = ''){
      try {

        if(!empty($id)){

          $data = Assets::find($id);

          if($data){
            return view('admin.application.create', compact('data'));
          } else {
            return redirect()->route('dashboard')->with(['error' => "Something want wrong.", 'status' => 0]);
          }

        } else {

          return view('admin.application.create');

        }

      }catch(\Exception $e) {
        Log::info("ApplicationController create - ". $e->getMessage());
        return redirect()->route('application.index')->with(['error' => "Something want wrong.", 'status' => 0]);

      }

    }

    public function store(Request $request, $id = ''){

      try {

        if(!empty($request->id)){

          $validator = Validator::make( $request->all(),[
            'title' => 'required',
          ]);

        }else{

            $validator = Validator::make( $request->all(),[
              'title' => 'required',
              'application_doc' => 'required'
            ]);
        }

        if ($validator->fails()) {

            $errorMessage = implode(',', $validator->errors()->all());
            return response()->json( [ 'success' => 0, 'message' => $errorMessage ] );

        } else {

            if(!empty($request->id)){

              $application = Assets::where('id',$request->id)->first();

              $application->title = $request->title;
              $application->save();

            } else {

              $application = new Assets;
              $application->title = $request->title;
              $application->type = config('global.file_type.application');

            }

              if ($request->hasFile('application_doc')){

                if(!empty($request->id)){

                    // remove old image from folder
                    \Helper::deleteFile($application->path);

                }

                  $file = $request->file('application_doc');
                  $file_name_to_store = time();
                  $file_uploaded_path ='images/application';
                  $file_type = $request->file('application_doc')->getClientOriginalExtension();


                  $file_path = \Helper::upload_file($file, "", $file_name_to_store, $file_uploaded_path, $is_base64_file = false);

                  $application->file_type = $file_type;
                  $application->path = $file_path;


              }

                $application->save();
                $response_array = ['success' => 1, 'message' => !empty($request->id) ? "Application updated sucessfully." : "Application added sucessfully." , 'redirect_url' => route('application.index')];
                return response()->json($response_array, 200);
        }

      }catch(\Exception $e) {
        Log::info("ApplicationController store - ". $e->getMessage());
        return redirect()->route('application.index')->with(['error' => "Something want wrong.", 'status' => 0]);

      }
    }

    public function application_list_json(Request $request)
    {
      try {

              $page_index = (int)$request->input('start') > 0 ? ($request->input('start') / $request->input('length')) + 1 : 1;

              $limit = (int)$request->input('length') > 0 ? $request->input('length') : DEFAULT_RECORDS_LIMIT;
              $columnIndex = $request->input('order')[0]['column']; // Column index
              $columnName = $request->input('columns')[$columnIndex]['data']; // Column name
              $columnSortOrder = $request->input('order')[0]['dir']; // asc or desc value

              $main_query =  Assets::from('assets')
                                    ->where('assets.type',config('global.file_type.application'))
                                    // ->where('assets.is_active',1)
                                    ->select('assets.*')
                                    ->orderBy($columnName, $columnSortOrder);

              $data_list_for_count = $main_query->get();  // group by and direct count not working
              $recordsTotal = count($data_list_for_count);

              $recordsFiltered = $recordsTotal;

              if(empty($request->input('search.value'))){

                  $appointments = $main_query->paginate($limit, ['*'], 'page', $page_index);

              }else {

                  $search = $request->input('search.value');

                  $search_query = $main_query->where('title','LIKE',"%{$search}%")
                                              ->orWhere('path','LIKE',"%{$search}%");

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
        Log::info("ApplicationController application_list_json - ". $e->getMessage());
        return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);

      }
    }
}
