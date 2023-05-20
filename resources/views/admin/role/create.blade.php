@extends('layouts.contentLayoutMaster')

{{-- title --}}
@section('title', isset($role_details) ? 'Role Edit' : 'Role Create')



{{-- vendor styles --}}
@section('vendor-styles')

@endsection

{{-- page styles --}}
@section('page-styles')

@endsection

@section('content')
    <section>

        <form action="{{route('roles.store')}}" method="POST" class="user_role_form" id="user_role_Form_id">

            <div class="card">

                <p>
                    <ol class="breadcrumb p-0 mb-0 pl-1 bg-white mt-0">
                        <li class="breadcrumb-item "><a href="/"><i class="bx bx-home-alt"></i></a> </li>
                        <li class="breadcrumb-item"><a href="{{route('roles.index')}}">{{ trans('pages.user_role_list.role') }}</a> </li>
                        <li class="breadcrumb-item active"> {{isset($role_details) ? trans('pages.edit_with_attr', ['attribute' => 'Role']) : trans('pages.add_with_attr', ['attribute' => 'Role'])}}</li>
                    </ol>
                </p>

                <div class="card-header pt-75">
                    <h4 class="card-title text-primary">{{isset($role_details) ? trans('pages.edit_with_attr', ['attribute' => 'Role']) : trans('pages.add_with_attr', ['attribute' => 'Role'])}}</h4>
                </div>

                <div class="card-body">
                    @csrf
                    <fieldset>

                        <div class="row">

                            <input type="hidden" name="id" class="form-control" id="role_id" value="{{@$role_details->role_id}}">

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="" class="required">{{ trans('pages.user_role_list.role_name') }} </label>
                                    <input type="text" name="role_name" value="{{isset($role_details) ? $role_details->role_name : '' }}" class="form-control" id="" required>
                                </div>
                            </div>

                            <!-- <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="" class="">{{ trans('pages.user_role_list.role_code') }} </label>
                                    <input type="text" name="role_code" class="form-control" id="">
                                </div>
                            </div> -->

                            {{-- <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="" class="required">{{ trans('pages.display_name') }} </label>
                                    <input type="text" name="display_name" class="form-control" id="" required>
                                </div>
                            </div> --}}

                            {{-- <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="required">{{ trans('pages.user_role_list.user_type') }}</label>

                                    <select name="UserType_Term" class="form-control user_type" id="user_type_id" data-element-ref="select2">
                                        <option value="">{{ trans('pages.please_select') }}</option>
                                        @foreach($user_type as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div> --}}

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="">{{ trans('pages.user_role_list.role_detail') }}</label>
                                    <textarea name="role_detail" class="form-control" rows="3" required>{!! isset($role_details) ? $role_details->role_name : '' !!}</textarea>
                                </div>
                            </div>

                            <div class="col-md-4 form-group">
                                <label class="d-block required">{{ trans('pages.active') }}</label>
                                <div class="custom-control-inline">
                                    <div class="radio mr-1 mt-1">
                                        <input type="radio" name="is_active" id="yes" value="1" checked="">
                                        <label for="yes">{{ trans('pages.yes') }}</label>
                                    </div>
                                    <div class="radio mt-1">
                                        <input type="radio" name="is_active" id="no" value="0">
                                        <label for="no">{{ trans('pages.no') }}</label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary" id="saveRoleBtn">{{ trans('pages.save') }}</button>
                            <!-- <button type="button" class="btn btn-danger ml-1">{{ trans('pages.cancel') }}</button>  -->
                            <a href="{{ url()->previous() }}" class="btn btn-danger ml-1">{{ trans('pages.cancel') }}</a>
                        </div>

                    </fieldset>
                </div>

            </div>

            <input type="hidden" name="role_right" class="form-control" id="role_right_id" value="">

            <div id="rights_container">
            </div>

        </form>



    </section>
@endsection


{{-- page scripts --}}
@section('page-scripts')
    @include('scripts.role.role_js')
@endsection
