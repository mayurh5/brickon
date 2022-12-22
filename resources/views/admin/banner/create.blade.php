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
                <li class="breadcrumb-item active">{{ isset($data) ? 'Update' : 'Add' }}</li>
            </ol>
        </p>

        <div class="card-header pt-75">
            <h4 class="card-title text-primary">Banner {{ isset($data) ? 'Update' : 'Add' }}</h4>
        </div>

        <div class="card-body">

            <form method="POST" action="{{route('banner.store')}}" class="form" id="banner_form_id" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ isset($data) ? $data->id : ''}}">
                <div class="form-body">


                    <div class="tab-content">

                        <div class="tab-pane active fade show" id="basic" aria-labelledby="basic-tab" role="tabpanel">

                            <div class="row">

                                <div class="col-12 col-md-4">
                                    <div class="col-md-12 col-12">
                                        <div class="card border shadow-none mb-1 app-file-info">
                                        <div class="card-body p-1 text-center">
                                            <div id="profile_pic_1_preview" class="image-fixed"><img src="{{ isset($data) && !empty($data->path) ? asset($data->path) : ''}}" alt="" style="object-fit: cover;" height="110" width="110" onerror="this.src = '{{Helper::defaultImage()}}';"></div>
                                        </div>
                                        <div class="ccard-footer pl-1 pr-1">
                                            <div class="form-group add-new-file text-center">
                                                <label>Add Banner</label>
                                                <label for="profile_pic_1" class="btn btn-primary btn-block glow  add-file-btn text-capitalize">{{ trans('pages.select') }}</label>
                                                <input type="file" name="banner_image" class="d-none" id="profile_pic_1" accept="image/x-png, image/jpeg">
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-8 left-section">

                                  <div class="row mr-25">

                                    <div class="col-md-12 form-group">
                                        <div class="controls">
                                          <label>Title</label>
                                          <input type="text" class="form-control" value="{{ isset($data) ? $data->title : ''}}" name="title" required>
                                        </div>
                                    </div>

                                      <div class="col-md-6 form-group">
                                          <div class="controls">
                                            <label>Order Number</label>
                                            <input type="number" class="form-control" value="{{ isset($data) ? $data->order_no : ''}}" name="order_no" required>
                                          </div>
                                      </div>

                                      <div class="col-md-6 form-group">
                                          <div class="controls">
                                            <label>End Date</label>
                                            <input type="date" class="form-control" value="{{ isset($data) ? $data->expiry_date  : ''}}" name="end_time" required>
                                          </div>
                                      </div>
                                  </div>
                              </div>


                            </div>

                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary" id="saveBannerBtn">{{ trans('pages.save') }}</button>
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
@include('scripts.banner.create_js')
@endsection
