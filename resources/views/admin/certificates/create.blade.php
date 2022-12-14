@extends('layouts.contentLayoutMaster')
{{-- page title --}}
@section('title','Certifiacte Create')

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
                <li class="breadcrumb-item"><a href="{{route('certifiactes.index')}}">Certifiactes List</a> </li>
                <li class="breadcrumb-item active">{{ isset($data) ? 'Update' : 'Add' }}</li>
            </ol>
        </p>

        <div class="card-header pt-75">
            <h4 class="card-title text-primary">Certifiacte {{ isset($data) ? 'Update' : 'Add' }}</h4>
        </div>

        <div class="card-body">

            <form method="post" action="{{route('certifiactes.store')}}" class="form" id="certificate_form_id" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ isset($data) ? $data->id : ''}}">
                <div class="form-body">

                    <div class="tab-content">

                        <div class="tab-pane active fade show" id="basic" aria-labelledby="basic-tab" role="tabpanel">

                            <div class="row">

                                <div class="col-12 col-md-12">
                                    <div class="col-md-12 col-12">
                                        <div class="card border shadow-none mb-1 app-file-info">
                                        <div class="card-body p-1 text-center">
                                            <div id="certificate_doc_1_preview" class="image-fixed"><img src="{{ isset($data) && !empty($data->path) ? asset($data->path) : ''}}" alt="" style="object-fit: cover;" height="110" width="110" onerror="this.src = '{{Helper::defaultImage()}}';"></div>
                                        </div>
                                        <div class="ccard-footer pl-1 pr-1">
                                            <div class="form-group add-new-file text-center">
                                                <label>Add Pdf</label>
                                                <label for="certificate_doc_1" class="btn btn-primary btn-block glow  add-file-btn text-capitalize">{{ trans('pages.select') }}</label>
                                                <input type="file" name="certificate_doc" class="d-none" id="certificate_doc_1">
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 form-group">
                                  <div class="controls">
                                    <label>Title</label>
                                    <input type="text" class="form-control" value="{{ isset($data) ? $data->title : ''}}" name="title" required>
                                  </div>
                              </div>


                            </div>

                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary" id="saveCertificateBtn">{{ trans('pages.save') }}</button>
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
@include('scripts.certificates.index_js')
@endsection
