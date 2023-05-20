@extends('layouts.contentLayoutMaster')

{{-- title --}}
@section('title', 'User View')

@section('vendor-styles')
@endsection


@section('content')

    <section>
        <div class="card">

            <p>
            <ol class="breadcrumb p-0 mb-0 pl-1 bg-white mt-0">
                <li class="breadcrumb-item"><a href="/"><i class="bx bx-home-alt"></i></a></li>

                <li class="breadcrumb-item"><a
                        href="{{route('users.index')}}">User List</a>
                </li>
                <li class="breadcrumb-item active">View User Details</li>
            </ol>
            </p>

            <div class="card-header pt-75">
                <h4 class="card-title text-primary">View User </h4>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-12 col-md-8 left-section">
                        <div class="row ml-1">
                            <ul class="nav nav-tabs mb-2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link flex-column align-items-center active" id="basic-tab"
                                        data-toggle="tab" href="#basic" aria-controls="basic" role="tab"
                                        aria-selected="true">
                                        <span>{{ trans('pages.basic_information') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link flex-sm-column align-items-center" id="raw-materials-tab"
                                        data-toggle="tab" href="#raw-materials" aria-controls="raw-materials" role="tab"
                                        aria-selected="false">
                                        <span>KYC</span>
                                    </a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a class="nav-link flex-sm-column align-items-center" id="order-tab" data-toggle="tab"
                                        href="#order" aria-controls="order" role="tab" aria-selected="false">
                                        <span>Purchase Orders</span>
                                    </a>
                                </li> --}}
                            </ul>
                        </div>
                    </div>

                </div>

                <div class="tab-content">

                    <div class="tab-pane active fade show" id="basic" aria-labelledby="basic-tab" role="tabpanel">

                        <div class="border-primary p-1 mb-2">

                            <div class="row col-md-12 mb-1">
                                <div class="col-12 p-0 mb-1">
                                    <blockquote class="blockquote pl-1 border-left-primary border-left-3 float-left">
                                        <h4 class="mb-0 shop-title float-left">User Details</h4>
                                    </blockquote>

                                </div>

                                <dl class="col-12 row">
                                    <dt class="col-sm-3">Name</dt>
                                    <dd class="col-sm-3">{{@$member_details->first_name}} {{@$member_details->last_name}}</dd>
                                    <dt class="col-sm-3">Email</dt>
                                    <dd class="col-sm-3"><a
                                            href="mailto:{{@$member_details->email}}">{{@$member_details->email}}</a>
                                    </dd>
                                    <!-- </dl> -->

                                    <!-- <dl class="col-12 row"> -->
                                    <dt class="col-sm-3">Contact No.</dt>
                                    <dd class="col-sm-3"><a
                                            href="tel:{{@$member_details->phone}}">{{@$member_details->phone}}</a>
                                    </dd>
                                    <dt class="col-sm-3">Created Date</dt>
                                    <dd class="col-sm-3">{{Helper::display_date(@$member_details->created_at)}}</dd>
                                    <!-- </dl> -->

                                    <!-- <dl class="col-12 row"> -->
                                    <dt class="col-sm-3">Address</dt>
                                    <dd class="col-sm-3">{{@$member_details->address->address_line_1}} {{@$member_details->address->address_line_2}}</dd>
                                    <dt class="col-sm-3">City</dt>
                                    <dd class="col-sm-3">{{isset($member_details->address->city) ? $member_details->address->city : '-'}}</dd>
                                    <dt class="col-sm-3">State</dt>
                                    <dd class="col-sm-3">{{isset($member_details->address->state) ? $member_details->address->state : '-'}}</dd>
                                    <dt class="col-sm-3">Country</dt>
                                    <dd class="col-sm-3">{{isset($member_details->address->country) ? $member_details->address->country : '-'}}</dd>
                                    <dt class="col-sm-3">Postal Code</dt>
                                    <dd class="col-sm-3">{{isset($member_details->address->postal_code) ? $member_details->address->postal_code : '-'}}</dd>
                                    <dt class="col-sm-3">Latitide</dt>
                                    <dd class="col-sm-3"> {{isset($member_details->address->lat) ? $member_details->address->lat : '-'}}</dd>
                                    <dt class="col-sm-3">Longitude</dt>
                                    <dd class="col-sm-3">{{isset($member_details->address->long) ? $member_details->address->long : '-'}}</dd>
                                    <dt class="col-sm-3">Image</dt>
                                    <dd class="col-sm-3"> <a href="/{{@$member_details->profile_pic}}" target="_blank">Click Here</a> </dd>
                                </dl>
                            </div>

                        </div>

                    </div>

                    <div class="tab-pane fade show" id="raw-materials" aria-labelledby="raw-materials-tab" role="tabpanel">
                        <div class="col-md-12 col-sm-12">

                            <div class="card border-primary">
                                <div class="card-header">
                                    <div class="col-12 p-0 mb-1">
                                        <blockquote class="blockquote pl-1 border-left-primary border-left-3 float-left">
                                            <h4 class="mb-0 shop-title float-left">Kyc Details</h4>
                                        </blockquote>

                                    </div>
                                </div>
                                <dl class="col-12 row">
                                  <dt class="col-sm-3">Customer Name</dt>
                                  <dd class="col-sm-3">{{isset($member_details->kyc->customer_name) ? $member_details->kyc->customer_name : '-'}}</dd>
                                  <dt class="col-sm-3">Gst Number</dt>
                                  <dd class="col-sm-3">{{isset($member_details->kyc->gst_number) ? $member_details->kyc->gst_number : '-'}}</dd>

                                  <dt class="col-sm-3">GST File</dt>
                                  <dd class="col-sm-3"> <a href="/{{@$member_details->kyc->gst_file}}" target="_blank">Click Here</a> </dd>

                                  <dt class="col-sm-3">Pan Number</dt>
                                  <dd class="col-sm-3">{{isset($member_details->kyc->pan_number) ? $member_details->kyc->pan_number : '-'}}</dd>

                                  <dt class="col-sm-3">Pan File</dt>
                                  <dd class="col-sm-3"> <a href="/{{@$member_details->kyc->pan_file}}" target="_blank">Click Here</a> </dd>
                                  <!-- </dl> -->

                                  <!-- <dl class="col-12 row"> -->
                                  <dt class="col-sm-3">Office Address</dt>
                                  <dd class="col-sm-3">{{isset($member_details->kyc->office_address) ? $member_details->kyc->office_address : '-'}}</dd>
                                  <dt class="col-sm-3">Bank</dt>
                                  <dd class="col-sm-3">{{isset($member_details->kyc->bank_name) ? $member_details->kyc->bank_name : '-'}}</dd>
                                  <dt class="col-sm-3">Account Number</dt>
                                  <dd class="col-sm-3">{{isset($member_details->kyc->ac_number) ? $member_details->kyc->ac_number : '-'}}</dd>
                                  <dt class="col-sm-3">IFSC</dt>
                                  <dd class="col-sm-3">{{isset($member_details->kyc->ifsc_code) ? $member_details->kyc->ifsc_code : '-'}}</dd>
                                  <dt class="col-sm-3">Bank Address</dt>
                                  <dd class="col-sm-3">{{isset($member_details->kyc->bank_address) ? $member_details->kyc->bank_address : '-'}}</dd>

                              </dl>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>

@endsection

{{-- page scripts --}}
{{-- @section('page-scripts')
    <script src="{{ asset('js/scripts/datatables/datatable.js') }}"></script>
@endsection --}}
