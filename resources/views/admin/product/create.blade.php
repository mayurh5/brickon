@extends('layouts.contentLayoutMaster')

{{-- title --}}
@section('title','Product')

@section('content')

<style>

  input[type='file'] {
    opacity:0;
  }

</style>

<section>

    <div class="card">

      <p>
        <ol class="breadcrumb p-0 mb-0 pl-1 bg-white mt-0">
            <li class="breadcrumb-item "><a href="/"><i class="bx bx-home-alt"></i></a> </li>
            <li class="breadcrumb-item"><a href="{{ route('product.index')}}">Product List</a> </li>
            <li class="breadcrumb-item active">{{ isset($product_details) ? 'Update' : 'Add' }} </li>
        </ol>
      </p>

      <div class="card-header d-flex">
          <h4 class="card-title text-primary">Product {{ isset($product_details) ? 'Update' : 'Add' }}</h4>
      </div>

      <div class="card-body">

        <form action="{{route('product.store')}}" method="POST" class="form" id="product_form_id" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="product_id" value="{{ isset($product_details) ? $product_details->id : ''}}">
          <div class="form-body">

            <div class="tab-content">
                <!-- Distributor details -->
                    <div class="tab-pane active fade show" id="basic" aria-labelledby="basic-tab" role="tabpanel">
                        <div class="row">


                            <div class="col-12 col-md-12">
                                <div class="row">

                                    <div class="col-md-6 form-group">
                                        <div class="controls">
                                            <label class="d-block required">MM (Value)</span></label>
                                            <input type="number"  value="{{ isset($product_details) ? $product_details->value : ''}}" name="mm" class="form-control"  required>
                                        </div>
                                    </div>



                                    <div class="col-md-6 form-group">
                                      <div class="controls">
                                          <label class="d-block required">Price Difference</label>
                                          <input type="number" value="{{ isset($product_details) ? $product_details->price_difference : ''}}" name="price_difference" class="form-control" required>
                                      </div>
                                  </div>

                                    {{-- <div class="col-md-6 form-group">
                                        <div class="controls">
                                            <label class="d-block required">Ton</label>
                                            <input type="number" name="total_ton" class="form-control" id="" required>
                                        </div>
                                    </div> --}}

                                    <div class="col-sm-6 form-group ">
                                      <label class="d-block">Status</label>
                                      <div class="custom-control-inline">
                                          <div class="radio mr-1 mt-1">
                                              <input type="radio" name="status" id="radio1" {{ isset($product_details) && $product_details->is_active == 1 ? 'checked' : ( !isset($product_details) ? 'checked' : '') }} value="1">
                                              <label for="radio1">{{ trans('pages.yes') }}</label>
                                          </div>
                                          <div class="radio mt-1">
                                              <input type="radio" name="status" id="radio2"  {{ isset($product_details) && $product_details->is_active == 0 ? 'checked' : ( !isset($product_details) ? 'checked' : '') }} value="0">
                                              <label for="radio2">{{ trans('pages.no') }}</label>
                                          </div>
                                      </div>
                                  </div>

                                  <div class="col-sm-6 form-group ">
                                    <label class="d-block">Primary</label>
                                    <div class="custom-control-inline">
                                        <div class="radio mr-1 mt-1">
                                            <input type="radio" name="primary" id="primary1" {{ isset($product_details) && $product_details->is_primary === 1 ? 'checked' : ( !isset($product_details) ? 'checked' : '') }} value="1">
                                            <label for="primary1">{{ trans('pages.yes') }}</label>
                                        </div>
                                        <div class="radio mt-1">
                                            <input type="radio" name="primary" id="primary2"  {{ isset($product_details) && $product_details->is_primary === 0 ? 'checked' : ( !isset($product_details) ? 'checked' : '') }} value="0">
                                            <label for="primary2">{{ trans('pages.no') }}</label>
                                        </div>
                                    </div>
                                </div>


                                    {{-- <div class="col-md-6 form-group">
                                        <div class="controls">
                                            <label class="d-block required">consignee address</label>
                                            <textarea name="consignee_address" class="form-control" id="" cols="5" rows="3"></textarea>
                                        </div>
                                    </div> --}}



                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-primary" id="saveProductBtn">{{ trans('pages.save') }}</button>
                                <!-- <button type="button" class="btn btn-danger ml-1">{{ trans('pages.cancel') }}</button> -->
                                <a href="{{ url()->previous() }}" class="btn btn-danger ml-1">{{ trans('pages.cancel') }}</a>
                            </div>
                        </div>
                    </div>
            </div>

          </div>
        </form>

      </div>
    </div>
</section>


@endsection

{{-- page scripts --}}
@section('page-scripts')
    @include('scripts.product.create_js')
@endsection

