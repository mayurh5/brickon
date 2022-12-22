<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assets;
use Validator;
use Log;

class BannerController extends Controller
{
  public function index(){

    return view('admin.banner.index');

  }

  public function create($id = ''){
    try {

        if(!empty($id)){

          $data = Assets::find($id);
          if($data){
            return view('admin.banner.create', compact('data'));
          } else {
            return redirect()->route('dashboard')->with(['error' => "Something want wrong.", 'status' => 0]);
          }

        } else {

          return view('admin.banner.create');

        }

    }catch(\Exception $e) {
      Log::info("BannerController create - ". $e->getMessage());
      return redirect()->route('banner.index')->with(['error' => "Something want wrong.", 'status' => 0]);

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
            'banner_image' => 'required',
            'order_no' => 'required',
            'end_time' => 'required',

          ]);
      }

      if ($validator->fails()) {

          $errorMessage = implode(',', $validator->errors()->all());
          return response()->json( [ 'success' => 0, 'message' => $errorMessage ] );

      } else {

        if(!empty($request->id)){

          $banner = Assets::where('id',$request->id)->first();

          $banner->title = $request->title;
          $banner->order_no = $request->order_no;
          $banner->expiry_date = $request->end_time;
          $banner->save();

        } else {

          $banner = new Assets;
          $banner->title = $request->title;
          $banner->order_no = $request->order_no;
          $banner->expiry_date = $request->end_time;
          $banner->type = config('global.file_type.banner');

        }

        if ($request->hasFile('banner_image')){

          if(!empty($request->id)){

              // remove old image from folder
              \Helper::deleteFile($banner->path);

          }

            $file = $request->file('banner_image');
            $file_name_to_store = time();
            $file_uploaded_path ='images/banner';
            $file_type = $request->file('banner_image')->getClientOriginalExtension();


            $file_path = \Helper::upload_file($file, "", $file_name_to_store, $file_uploaded_path, $is_base64_file = false);

            $banner->file_type = $file_type;
            $banner->path = $file_path;


        }

        $banner->save();
        $response_array = ['success' => 1, 'message' => !empty($request->id) ? "Banner updated sucessfully." : "Banner added sucessfully." , 'redirect_url' => route('banner.index')];
        return response()->json($response_array, 200);

      }

    }catch(\Exception $e) {
      Log::info("BannerController create - ". $e->getMessage());
      return redirect()->route('banner.index')->with(['error' => "Something want wrong.", 'status' => 0]);

    }

  }

  public function banner_list_json(Request $request)
  {
    try {

            $page_index = (int)$request->input('start') > 0 ? ($request->input('start') / $request->input('length')) + 1 : 1;

            $limit = (int)$request->input('length') > 0 ? $request->input('length') : DEFAULT_RECORDS_LIMIT;
            $columnIndex = $request->input('order')[0]['column']; // Column index
            $columnName = $request->input('columns')[$columnIndex]['data']; // Column name
            $columnSortOrder = $request->input('order')[0]['dir']; // asc or desc value

            $main_query =  Assets::from('assets')
                                  ->where('assets.type',config('global.file_type.banner'))
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
      Log::info("CertifiactesController index - ". $e->getMessage());
      return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);

    }
  }



}
