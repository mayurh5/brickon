<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Validator;
use Log;

class ProductController extends Controller
{
  public function index(){

    return view('admin.product.index');

  }

  public function create($id = ''){

    try {

      if(!empty($id)){

        $product_details = Product::find($id);

        return view('admin.product.create', compact('product_details'));

      } else {

        return view('admin.product.create');

      }

    }catch(\Exception $e) {
      Log::info("ProductController create - ". $e->getMessage());
      return redirect()->route('product.index')->with(['error' => "Something want wrong.", 'status' => 0]);

    }

}

  public function view(Request $request){

    return view('admin.product.view');

  }

  public function store(Request $request, $product_id = ''){

    try {
        $response_array = array();

        if(!empty($request->product_id)){

            $validator = Validator::make( $request->all(),[
                'mm'  => 'required',
                'price_difference'  => 'required',
            ]);

        }else{

            $validator = Validator::make( $request->all(),[
              'mm'  => 'required',
              'price_difference'  => 'required',
            ]);
        }

        if($validator->fails()) {

            $response_array = ['error' => implode(',', $validator->messages()->all()) ];

        } else {

          if(!empty($request->product_id)){

            $product = Product::where('id',$request->product_id)->first();
            $product->value = $request->mm;
            $product->is_primary = $request->primary;
            $product->price_difference = $request->price_difference;
            $product->is_active = $request->status;
            $product->save();

          } else {

            $product = new Product;
            $product->value = $request->mm;
            $product->is_primary = $request->primary;
            $product->price_difference = $request->price_difference;
            $product->is_active = $request->status;
            $product->save();

          }

          $response_array = ['success' => 1, 'message' => !empty($request->product_id) ? "Product updated sucessfully." : "Product added sucessfully." , 'redirect_url' => route('product.index')];

        }

        return response()->json($response_array, 200);

    }catch(\Exception $e) {
      Log::info("ProductController store - ". $e->getMessage());
      return redirect()->route('product.index')->with(['error' => "Something want wrong.", 'status' => 0]);

    }

  }

  public function productListJson(Request $request){

    try {

          $page_index = (int)$request->input('start') > 0 ? ($request->input('start') / $request->input('length')) + 1 : 1;

          $limit = (int)$request->input('length') > 0 ? $request->input('length') : DEFAULT_RECORDS_LIMIT;
          $columnIndex = $request->input('order')[0]['column']; // Column index
          $columnName = $request->input('columns')[$columnIndex]['data']; // Column name
          $columnSortOrder = $request->input('order')[0]['dir']; // asc or desc value

          $main_query = Product::from('product')
          ->select('product.*')
          ->orderBy($columnName, $columnSortOrder);

          $data_list_for_count = $main_query->get();  // group by and direct count not working
          $recordsTotal = count($data_list_for_count);

          $recordsFiltered = $recordsTotal;

          if(empty($request->input('search.value'))){

              $appointments = $main_query->paginate($limit, ['*'], 'page', $page_index);

          }else {

              $search = $request->input('search.value');

              $search_query = $main_query->where('value','LIKE',"%{$search}%")
                                    ->orWhere('price_difference','LIKE',"%{$search}%");

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

      Log::info("ProductController productListJson - ". $e->getMessage());
      return response()->json(['status' => 0, 'message' => trans('pages.something_wrong'), 'error' => $e->getMessage()]);

    }

  }


}
