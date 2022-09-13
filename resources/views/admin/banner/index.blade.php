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
                    <table class="table add-rows" id="stock_list_tbl">
                        <thead>
                            <tr>
                              {{-- <th style="display:none;"></th> --}}
                              <th>#</th>
                              <th>IMG</th>
                              <th class="white-space-nowrap">	POSITION</th>
                              <th>ORDER</th>
                              <th>Expiry</th>
                              <th>Active</th>
                              <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                          <tr>
                            <td>01</td>
                            <td><img src="#" alt="users avatar"
                              class="users-avatar-shadow media-bordered rounded-circle" target="_blank" height="40" width="40"  onerror="this.src = '{{defaultImage()}}';"></td>
                              <td>03</td>
                              <td>03</td>
                              <td>27-09-2022</td>
                              <td>11-09-2022</td>
                              <td>
                                <a href="#" data-id="1" class="float-top"><i class="bx bx-edit text-primary bx-sm"></i></a>
                                <a href="#" data-id="1" class="float-top"><i class="bx bx-trash text-danger bx-sm"></i></a>
                              </td>
                          </tr>


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
<script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>
    @include('scripts.banner.index_js')
@endsection
