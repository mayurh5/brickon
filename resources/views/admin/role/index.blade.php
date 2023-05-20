@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Role')

{{-- vendor styles --}}
@section('vendor-styles')

@endsection
{{-- @php
    $page_action = Helper::pageAction(config('pages.admin.user_management_role'));
@endphp --}}

{{-- page styles --}}
@section('page-styles')

@endsection

@section('content')
    <section>
        <div class="card">
            <div class="card-content">

                <p>
                    <ol class="breadcrumb p-0 mb-0 pl-1 bg-white mt-0">
                        <li class="breadcrumb-item "><a href="/"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active">{{ trans('pages.user_role_list.role') }}</a> </li>
                    </ol>
                </p>


                    <div class="card-header pt-75 pb-75">
                        <h4 class="card-title text-primary">{{ trans('pages.list_with_attr', ['attribute' => 'Role']) }}</h4>

                        <div class="d-flex">
                            <a class="btn btn-primary mr-1" href="{{ route('roles.create') }}"><i class="bx bx-plus"></i>{{ trans('pages.add_with_attr', ['attribute' => 'Role']) }}</a>
                        </div>
                    </div>


                <div class="card-body">
                    <!-- datatable start -->
                    <div class="table-responsive">
                        <table class="table add-rows" id="userrole_list_tbl">
                            <thead>
                                <tr>
                                    <th style="display:none;"></th>
                                    <th>#</th>
                                    <th>{{ trans('pages.user_role_list.role_name') }}</th>
                                    <th>{{ trans('pages.user_role_list.role_detail') }}</th>
                                    <th>{{ trans('pages.status') }}</th>
                                    <th>{{ trans('pages.action') }}</th>
                                </tr>
                            </thead>
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
  @include('scripts.role.role_index_js')
@endsection
