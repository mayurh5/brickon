@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title', 'Contact Us')

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
                        <h4 class="card-title text-primary">Web Settings </h4>
                    </div>
                    <hr class="m-0">
                    <div class="card-body">

                        <form method="POST" action="{{route('contact_us.update')}}" id="web-settings-frm">
                            @csrf

                            <div class="row">

                                <div class="form-group col-sm-4">
                                    <div class="controls">
                                        <label>Email</label>
                                        <input type="text" class="form-control" placeholder="Email"
                                            value="{{ @$web_setting->email }}" name="email" required>
                                    </div>
                                </div>

                                <div class="form-group col-sm-4">
                                    <div class="controls">
                                        <label>Mobile</label>
                                        <input type="text" class="form-control" placeholder="Mobile"
                                            value="{{ @$web_setting->mobile }}" name="mobile" required>
                                    </div>
                                </div>

                                <div class="form-group col-sm-4">
                                    <div class="controls">
                                        <label>WebSite</label>
                                        <input type="text" class="form-control" placeholder="WebSite" name="website"
                                            value="{{ @$web_setting->website }}">
                                    </div>
                                </div>

                                <div class="form-group col-sm-3">
                                    <div class="controls">
                                        <label>FACEBOOK</label>
                                        <input type="text" class="form-control" placeholder="FACEBOOK" name="facebook"
                                            value="{{ @$web_setting->facebook }}">
                                    </div>
                                </div>

                                <div class="form-group col-sm-3">
                                    <div class="controls">
                                        <label>twitter</label>
                                        <input type="text" class="form-control" placeholder="twitter" name="twitter"
                                            value="{{ @$web_setting->twitter }}">
                                    </div>
                                </div>

                                <div class="form-group col-sm-3">
                                    <div class="controls">
                                        <label>linkedin</label>
                                        <input type="text" class="form-control" placeholder="linkedin" name="linkedin"
                                            value="{{ @$web_setting->linkedin }}">
                                    </div>
                                </div>

                                <div class="form-group col-sm-3">
                                    <div class="controls">
                                        <label>instagram</label>
                                        <input type="text" class="form-control" placeholder="instagram" name="instagram"
                                            value="{{ @$web_setting->instagram }}">
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12">
                                    <div class="form-group">
                                        <label>
                                            <h5><strong>Location :</strong></h5>
                                        </label>
                                        <textarea class="ckeditor form-control" name="address">
                                            {!! isset($web_setting->address) ? $web_setting->address : '' !!}
                                        </textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="{{@$web_setting->id}}">

                                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                                    <button id="web-settings-frm-btn"
                                        class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Update</button>
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
        $('#web-settings-frm-btn').on('click', function(e) {
            showLoadingDialog();
            submitForm('#web-settings-frm', '', true, (response) => {}, (response) => {});
        });
    </script>

@endsection
