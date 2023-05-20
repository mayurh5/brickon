@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title', isset($user_details) ? 'User Edit' : 'User Create' )

@section('vendor-styles')
@endsection

<style>
@media screen and (max-width: 600px) {
    ul.nav.nav-tabs.mb-2 {
        display: contents;
    }
}
</style>

@section('content')

<!-- users view start -->
<section>

    <div class="card">

        <p>
            <ol class="breadcrumb p-0 mb-0 pl-1 bg-white mt-0">
                <li class="breadcrumb-item "><a href="/"><i class="bx bx-home-alt"></i></a> </li>
                <li class="breadcrumb-item"><a href="{{route('users.index')}}">Users List</a> </li>
                <li class="breadcrumb-item active">{{  isset($user_details) ? trans('pages.edit_with_attr', ['attribute' => 'User']) : trans('pages.add_with_attr', ['attribute' => 'User'])  }}</li>
            </ol>
        </p>

        <div class="card-header pt-75">
            <h4 class="card-title text-primary">{{  isset($user_details) ? trans('pages.edit_with_attr', ['attribute' => 'User']) : trans('pages.add_with_attr', ['attribute' => 'User'])  }}</h4>
        </div>

        <div class="card-body">

            <form method="POST" action="{{route('users.store')}}" class="form" id="user_form_id" enctype="multipart/form-data">
                @csrf
                <div class="form-body">
                    <div class="tab-content">

                        <div class="tab-pane active fade show" id="basic" aria-labelledby="basic-tab" role="tabpanel">

                            <div class="row">

                              <input type="hidden" name="user_id" value="{{  isset($user_details) ? $user_details->id : ''  }}">
                                {{-- <div class="col-12 col-md-4">
                                    <div class="col-md-12 col-12">
                                        <div class="card border shadow-none mb-1 app-file-info">
                                        <div class="card-body p-1 text-center">
                                            <div id="profile_pic_1_preview" class="image-fixed"><img src="#" alt="" style="object-fit: cover;" height="110" width="110" onerror="this.src = '{{Helper::defaultImage()}}';"></div>
                                        </div>
                                        <div class="ccard-footer pl-1 pr-1">
                                            <div class="form-group add-new-file text-center">
                                                <label>Profiel Picture</label>
                                                <label for="profile_pic_1" class="btn btn-primary btn-block glow  add-file-btn text-capitalize">{{ trans('pages.select') }}</label>
                                                <input type="file" name="profile_pic" class="d-none" id="profile_pic_1" accept="image/x-png, image/jpeg">
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="col-12 col-md-12 left-section">

                                    <div class="row mr-25">

                                        <div class="col-md-6 form-group">
                                            <div class="controls">
                                                <label class="required">{{ trans('pages.first_name') }}</label>
                                                <input type="text" name="first_name" value="{{  isset($user_details) ? $user_details->first_name : ''  }}" class="form-control" id="fname-icon" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <div class="controls">
                                                <label class="required">{{ trans('pages.last_name') }}</label>
                                                <input type="text" name="last_name" class="form-control" value="{{  isset($user_details) ? $user_details->last_name : ''  }}" id="last-icon" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <div class="controls">
                                                <label class="required">{{ trans('pages.display_name') }}</label>
                                                <input type="text" name="display_name" class="form-control" value="{{  isset($user_details) ? $user_details->display_name : ''  }}" id="diaplay-icon" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <div class="controls">
                                                <label class="required">Email</label>
                                                <input type="email" name="email" class="form-control" value="{{  isset($user_details) ? $user_details->user_name : ''  }}" id="diaplay-icon" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <div class="controls">
                                                <label class="required">Whatsapp Number</label>
                                                <input type="number" name="mobile_no" class="form-control" value="{{  isset($user_details) ? $user_details->mobile_no : ''  }}" id="diaplay-icon" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 form-group">
                                          <div class="controls">
                                              <label class="required">Role</label>
                                              <select name="role_type" class="form-control" required>
                                                  <option value="">{{ trans('pages.please_select') }}</option>
                                                  @foreach($role_list as $key => $term)
                                                      <option value="{{$term->role_id}}" {{ isset($user_details) ? ($user_details->role_id == $term->role_id ? 'selected' : '') : '' }}>{{$term->role_name}}</option>
                                                  @endforeach
                                              </select>
                                        </div>
                                      </div>


                                      @if (empty($user_details))


                                        <div class="col-md-6 form-group">
                                            <div class="controls">
                                                <label class="required">password</label>
                                                <input type="password" name="password" class="form-control" id="diaplay-icon" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <div class="controls">
                                                <label class="required">confirm password</label>
                                                <input type="password" name="confirm_password" class="form-control" id="diaplay-icon" required>
                                            </div>
                                        </div>

                                      @endif




                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary" id="saveUserBtn">{{ trans('pages.save') }}</button>
                                    <button type="button" class="btn btn-danger ml-1">{{ trans('pages.cancel') }}</button>
                                </div>
                            </div>

                        </div>
                        {{-- end --}}



                    </div>

                </div>

            </form>

        </div>

    </div>

</section>


@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')

@endsection

{{-- page scripts --}}
@section('page-scripts')
    @include('scripts.users.create_js')
@endsection
