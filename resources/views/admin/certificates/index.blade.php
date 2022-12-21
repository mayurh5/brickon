@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Certifiactes')

@section('vendor-styles')
@endsection

@section('content')

<section>
    <div class="card">
        <div class="card-content">
            <p>
                <ol class="breadcrumb p-0 mb-0 pl-1 bg-white mt-0">
                    <li class="breadcrumb-item "><a href="/"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item ">Certifiactes</a></li>
                </ol>
            </p>
              <div class="card-header pt-75 pb-75">
                  <h4 class="card-title text-primary">Certifiactes List</h4>
                  <div class="d-flex">
                      <a class="btn btn-primary mr-1" href="{{route('certifiactes.create')}}" id="addBillBtn"><i class="bx bx-plus"></i> {{ trans('pages.add_with_attr', ['attribute' => 'Certifiactes']) }}</a>
                  </div>
              </div>

              <div class="card-body">
                <div class="table-responsive">
                  <table class="table add-rows" id="certificate_tbl">
                    <thead>
                      <tr>
                        <th style="display:none;"></th>
                        <th>#</th>
                        <th>Title</th>
                        <th>Document</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                  </table>
                </div>
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
@include('scripts.certificates.index_js')
@endsection
