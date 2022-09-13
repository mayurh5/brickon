@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Banner Create')

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
                <li class="breadcrumb-item"><a href="{{route('banner.index')}}">Banner List</a> </li>
                <li class="breadcrumb-item active">{{ trans('pages.add_with_attr', ['attribute' => 'Banner']) }}</li>
            </ol>
        </p>

        <div class="card-header pt-75">
            <h4 class="card-title text-primary">{{ trans('pages.add_with_attr', ['attribute' => 'Banner']) }}</h4>
        </div>

        <div class="card-body">

            <form method="" action="#" class="form" id="hr_employee_form_id" enctype="multipart/form-data">
                @csrf
                <div class="form-body">


                    <div class="tab-content">

                        <div class="tab-pane active fade show" id="basic" aria-labelledby="basic-tab" role="tabpanel">

                            <div class="row">

                                <div class="col-12 col-md-4">
                                    <div class="col-md-12 col-12">
                                        <div class="card border shadow-none mb-1 app-file-info">
                                        <div class="card-body p-1 text-center">
                                            <div id="profile_pic_1_preview" class="image-fixed"><img src="#" alt="" style="object-fit: cover;" height="110" width="110" onerror="this.src = '{{Helper::defaultImage()}}';"></div>
                                        </div>
                                        <div class="ccard-footer pl-1 pr-1">
                                            <div class="form-group add-new-file text-center">
                                                <label>Add Banner</label>
                                                <label for="profile_pic_1" class="btn btn-primary btn-block glow  add-file-btn text-capitalize">{{ trans('pages.select') }}</label>
                                                <input type="file" name="profile_pic" class="d-none" id="profile_pic_1">
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-8 left-section">

                                  <div class="row mr-25">

                                    <div class="col-md-6 form-group">
                                        <div class="controls">
                                          <label>Title</label>
                                          <input type="text" class="form-control" name="title" required>
                                        </div>
                                    </div>
                                      <div class="col-md-6 form-group">
                                          <div class="controls">
                                            <label>Position Number</label>
                                            <input type="number" class="form-control" name="position_no" required>
                                          </div>
                                      </div>
                                      <div class="col-md-6 form-group">
                                          <div class="controls">
                                            <label>Order Number</label>
                                            <input type="number" class="form-control" name="order_no" required>
                                          </div>
                                      </div>
                                      <div class="col-md-6 form-group">
                                          <div class="controls">
                                            <label>Start Date</label>
                                            <input type="date" class="form-control start-end-date" name="start_time" required>
                                          </div>
                                      </div>
                                      <div class="col-md-6 form-group">
                                          <div class="controls">
                                            <label>End Date</label>
                                            <input type="date" class="form-control start-end-date" name="end_time" required>
                                          </div>
                                      </div>




                                  </div>
                              </div>


                            </div>

                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary" id="saveHrEmployeeBtn">{{ trans('pages.save') }}</button>
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
@include('scripts.users.index_js')
@endsection
