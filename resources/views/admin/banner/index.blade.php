@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Banner')

@section('vendor-styles')
@endsection

@section('content')

<section>
    <div class="card">
        <div class="card-content">
            <p>
                <ol class="breadcrumb p-0 mb-0 pl-1 bg-white mt-0">
                    <li class="breadcrumb-item "><a href="/"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item ">Banner</a></li>
                </ol>
            </p>
              <div class="card-header pt-75 pb-75">
                  <h4 class="card-title text-primary">Banner List</h4>
                  <div class="d-flex">
                      <a class="btn btn-primary mr-1" href="{{route('banner.create')}}" id="addBillBtn"><i class="bx bx-plus"></i> {{ trans('pages.add_with_attr', ['attribute' => 'Banner']) }}</a>
                  </div>
              </div>

            <div class="card-body">
                <!-- datatable start -->
                <div class="table-responsive">
                    <table class="table add-rows" id="banner_tbl">
                        <thead>
                            <tr>
                              {{-- <th style="display:none;"></th> --}}
                              <th style="display:none;"></th>
                              <th>#</th>
                              <th>Title</th>
                              <th>Order</th>
                              <th>Expiry</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>
                </div>
                <!-- datatable ends -->
            </div>

        </div>
    </div>
</section>
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')

@endsection

{{-- page scripts --}}
@section('page-scripts')
    @include('scripts.banner.index_js')
@endsection
