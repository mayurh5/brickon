@extends('layouts.contentLayoutMaster')

{{-- title --}}
@section('title','Leads List')

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
            <li class="breadcrumb-item"><a href="{{ route('leads.index')}}">Leads List</a> </li>
            <li class="breadcrumb-item active">Add </li>
        </ol>
      </p>

      <div class="card-header d-flex">
          <h4 class="card-title text-primary">Leads Add</h4>
      </div>

      <div class="card-body">

        <form action="#" method="POST" class="form" id="distributor_form_id" enctype="multipart/form-data">
          @csrf
          <div class="form-body">



            <div class="tab-content">
                <!-- Distributor details -->
                    <div class="tab-pane active fade show" id="basic" aria-labelledby="basic-tab" role="tabpanel">
                        <div class="row">



                            <div class="col-12 col-md-12">
                                <div class="row">

                                    <div class="col-md-6 form-group">
                                        <div class="controls">
                                            <label class="d-block required">Party Name</span></label>
                                            <input type="text" name="party_name" class="form-control" id="" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <div class="controls">
                                            <label class="d-block required">Product Count</label>
                                            <input type="number" name="product_count" class="form-control" id="" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                      <div class="controls">
                                          <label class="d-block required">Rate</label>
                                          <input type="number" name="rate" class="form-control" id="" required>
                                      </div>
                                  </div>

                                    <div class="col-md-6 form-group">
                                        <div class="controls">
                                            <label class="d-block required">Total Ton</label>
                                            <input type="number" name="total_ton" class="form-control" id="" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 form-group ">
                                      <label class="d-block">Status</label>
                                      <div class="custom-control-inline">
                                          <div class="radio mr-1 mt-1">
                                              <input type="radio" name="status" id="radio1" value="1">
                                              <label for="radio1">{{ trans('pages.yes') }}</label>
                                          </div>
                                          <div class="radio mt-1">
                                              <input type="radio" name="status" id="radio2" checked="" value="0">
                                              <label for="radio2">{{ trans('pages.no') }}</label>
                                          </div>
                                      </div>
                                  </div>


                                    <div class="col-md-6 form-group">
                                        <div class="controls">
                                            <label class="d-block required">Delivery address</label>
                                            <textarea name="consignee_address" class="form-control" id="" cols="5" rows="3"></textarea>
                                        </div>
                                    </div>



                                </div>
                            </div>

                        </div>





                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-primary" id="savedistributorBtn">{{ trans('pages.save') }}</button>
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
    @include('scripts.leads.index_js')
@endsection

