@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title', 'App Settings')

{{-- page styles --}}
@section('page-styles')
@endsection

@section('content')
<!-- Form wizard with step validation section start -->
<section id="validation">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title text-primary">App Settings </h4>
        </div>
        <hr class="m-0">
        <div class="card-body">

          <form method="POST" action="#" id="app-settings-frm">
            @csrf

            <div class="row">

                <div class="form-group col-sm-4">
                    <div class="controls">
                        <label>ANDROID VERSION</label>
                        <input type="text" class="form-control" placeholder="ANDROID VERSION"
                            value="1.0.0"  name="android_app_version" required>
                    </div>
                </div>

                <div class="form-group col-sm-4">
                    <div class="controls">
                        <label>IOS VERSION</label>
                        <input type="text" class="form-control" placeholder="IOS VERSION"
                            value="1.0.1"  name="ios_app_version" required>
                    </div>
                </div>

                <div class="form-group col-sm-4">
                    <label>UNDERMAINTENANCE</label>
                    <select class="custom-select" name="is_undermaintenance">
                      <option value="0" >NO</option>
                      <option value="1" >Yes</option>
                    </select>
                </div>

                <div class="form-group col-sm-4">
                    <label>FORCE UPDATE FOR ISO</label>
                    <select class="custom-select" name="is_force_update_ios" required>
                      <option value="0" >NO</option>
                      <option value="1" >Yes</option>
                    </select>
                </div>

                <div class="form-group col-sm-4">
                  <label>FORCE UPDATE FOR Android</label>
                  <select class="custom-select" name="is_force_update_android" required>
                    <option value="0" >NO</option>
                    <option value="1" >Yes</option>
                  </select>
              </div>




                <div class="form-group col-sm-4">
                    <div class="controls">
                        <label>Base Url</label>
                        <input type="text" class="form-control" placeholder="Base Url" name="base_url"
                        value="" >
                    </div>
                </div>

                <div class="form-group col-sm-4">
                    <div class="controls">
                        <label>Image Base Url</label>
                        <input type="text" class="form-control" placeholder="Image Base Url" name="image_base_url"
                        value="" >
                    </div>
                </div>



              <div class="col-12 col-sm-12">

                <div class="form-group">
                    <label><h5><strong>TERM CONDITION :</strong></h5></label>
                    <textarea class="ckeditor form-control" name="term_and_condition"></textarea>
                  </div>
              </div>

              <div class="col-12 col-sm-12">
                <div class="form-group">
                    <label><h5><strong>POLICY :</strong></h5></label>
                    <textarea class="ckeditor form-control" name="policy"></textarea>
                  </div>
              </div>

              <div class="col-12 col-sm-12">
                <div class="form-group">
                      <label><h5><strong>ABOUT US :</strong></h5></label>
                      <textarea class="ckeditor form-control" name="about_us"></textarea>
                  </div>
              </div>

              <div class="col-12 col-md-4">
                <div class="col-md-12 col-12">
                    <div class="card border shadow-none mb-1 app-file-info">
                    <div class="card-body p-1 text-center">
                        <div id="profile_pic_1_preview" class="image-fixed"><img src="#" alt="" style="object-fit: cover;" height="110" width="110" onerror="this.src = '{{Helper::defaultImage()}}';"></div>
                    </div>
                    <div class="ccard-footer pl-1 pr-1">
                        <div class="form-group add-new-file text-center">
                            <label>Brochure</label>
                            <label for="profile_pic_1" class="btn btn-primary btn-block glow  add-file-btn text-capitalize">{{ trans('pages.select') }}</label>
                            <input type="file" name="profile_pic" class="d-none" id="profile_pic_1">
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
              <div class="col-md-12 col-12">
                  <div class="card border shadow-none mb-1 app-file-info">
                  <div class="card-body p-1 text-center">
                      <div id="profile_pic_2_preview" class="image-fixed"><img src="#" alt="" style="object-fit: cover;" height="110" width="110" onerror="this.src = '{{Helper::defaultImage()}}';"></div>
                  </div>
                  <div class="ccard-footer pl-1 pr-1">
                      <div class="form-group add-new-file text-center">
                          <label>Product Quality</label>
                          <label for="profile_pic_2" class="btn btn-primary btn-block glow  add-file-btn text-capitalize">{{ trans('pages.select') }}</label>
                          <input type="file" name="profile_pic" class="d-none" id="profile_pic_2">
                      </div>
                  </div>
                  </div>
              </div>
          </div>


              <input type="hidden" name="app_settings_id"  value="">

              <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                  <button id="app-settings-frm-btn" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Update</button>
                  <a href="#" class="btn btn-light">Reset</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Form wizard with step validation section end -->

@endsection

@section('page-scripts')

<script src="{{ asset('ckeditor/ckeditor.js') }}" type="text/javascript"></script>
<script>
  $('#app-settings-frm-btn').on('click', function(e) {
      showLoadingDialog();
      submitForm('#app-settings-frm', '', true, (response) => {}, (response) => {});
  });
</script>

@endsection
