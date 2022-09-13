@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Leads')

@section('vendor-styles')
@endsection

@section('content')

<section>
    <div class="card">
        <div class="card-content">
            <p>
                <ol class="breadcrumb p-0 mb-0 pl-1 bg-white mt-0">
                    <li class="breadcrumb-item "><a href="/"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item ">Leads</a></li>
                </ol>
            </p>
              <div class="card-header pt-75 pb-75">
                  <h4 class="card-title text-primary">Leads List</h4>
                  <div class="d-flex">
                      <a class="btn btn-primary mr-1" href="{{route('leads.create')}}" id="addBillBtn"><i class="bx bx-plus"></i> {{ trans('pages.add_with_attr', ['attribute' => 'Leads']) }}</a>
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
                              <th>Party name</th>
                              <th>production count</th>
                              <th>rate</th>
                              <th>total ton</th>
                              <th>status</th>
                              <th>consignee address</th>
                              <th>action</th>
                            </tr>
                        </thead>

                        <tbody>
                          <tr>
                            <td>01</td>
                            <td>Kishan savani</td>
                            <td>50</td>
                            <td>100</td>
                            <td>100</td>
                            <td>Confirmed</td>
                            <td>Ahemdabad</td>
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
    @include('scripts.leads.index_js')
@endsection
