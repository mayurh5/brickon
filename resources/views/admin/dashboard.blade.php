@extends('layouts.contentLayoutMaster')

{{-- title --}}
@section('title','Dashboard')
{{-- venodr style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/charts/apexcharts.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/dragula.min.css')}}">
@endsection

{{-- page style --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/widgets.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/dashboard-analytics.css')}}">
@endsection

@section('content')
<!-- Dashboard Analytics Start -->
<section id="dashboard-analytics">
  <div class="row">
    <!-- Website Analytics Starts-->
    <div class="col-xl-4 col-md-6 col-sm-12 dashboard-referral-impression">

      <div class="card">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center">
            <div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2">
              <div class="avatar-content">
                <i class="bx bx-group text-primary font-medium-2"></i>
              </div>
            </div>
            <div class="total-amount">
              <h5 class="mb-0">{{$data['user']}}</h5>
             <a href="{{ route('users.index') }}"><span class="text-primary">Total Users</span></a>
            </div>
          </div>

        </div>
      </div>

    </div>

    <div class="col-xl-4 col-md-6 col-sm-12 dashboard-referral-impression">

      <div class="card">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center">
            <div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2">
              <div class="avatar-content">
                <i class="bx bx-group text-primary font-medium-2"></i>
              </div>
            </div>
            <div class="total-amount">
              <h5 class="mb-0">{{$data['product']}}</h5>
              <a href="{{ route('product.index')}}"><span class="text-primary">Products</span></a>
            </div>
          </div>

        </div>
      </div>

    </div>

    <div class="col-xl-4 col-md-6 col-sm-12 dashboard-referral-impression">

      <div class="card">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center">
            <div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2">
              <div class="avatar-content">
                <i class="bx bx-group text-primary font-medium-2"></i>
              </div>
            </div>
            <div class="total-amount">
              <h5 class="mb-0">₹ {{$data['lead_total']}}</h5>
              <span class="text-primary">Leads Amount</span>
            </div>
          </div>

        </div>
      </div>

    </div>
    <div class="col-md-12 col-sm-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center p-1">
          <h4 class="card-title text-primary">Users</h4>
          <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary glow"> All </a>
        </div>
        <div class="card-body pb-1" >
          <div class="table-responsive">
            <table id="users-list-tbl" class="table table-hover" width="100%">
              <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>email</th>
                    <th>mobile</th>
                    <th>GST No.</th>
                    <th>Pan No.</th>
                </tr>
              </thead>

                @foreach ($data['members'] as $key => $item)
                <tr>
                  <td>{{$key+1}}</td>
                  <td>{{$item->first_name}} {{$item->last_name}}</td>
                  <td>{{isset($item->email) ? $item->email : '-'}}</td>
                  <td>{{isset($item->phone) ? $item->phone : '-'}}</td>
                  <td>{{isset($item->gst_number) ? $item->gst_number : '-'}}</td>
                  <td>{{isset($item->pan_number)  ? $item->pan_number : '-'}}</td>
                </tr>
                @endforeach

              <tbody>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-12 col-sm-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center p-1">
          <h4 class="card-title text-primary">Leads</h4>
          <a href="{{ route('leads.index') }}" class="btn btn-sm btn-primary glow"> All </a>
        </div>
        <div class="card-body pb-1" >
          <div class="table-responsive">
            <table id="leads-list-tbl" class="table table-hover" width="100%">
              <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Order No</th>
                    <th>Primary </th>
                    <th>Total</th>
                    <th>Order Date</th>
                </tr>
              </thead>

                @foreach ($data['leads'] as $key => $item)
                <tr>
                  <td>{{$key+1}}</td>
                  <td>{{$item->first_name}} {{$item->last_name}}</td>
                  <td>{{$item->order_code}}</td>
                  <td>{{isset($item->primary_product_price) ? $item->primary_product_price : '-'}}</td>
                  <td>{{isset($item->final_total) ? $item->final_total : '-'}}</td>
                  <td>{{isset($item->order_date) ? $item->order_date : '-'}}</td>
                </tr>
                @endforeach


              <tbody>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>











  </div>
</section>
<!-- Dashboard Analytics end -->
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
{{-- <script src="{{asset('vendors/js/charts/apexcharts.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/dragula.min.js')}}"></script> --}}
@endsection

@section('page-scripts')
{{-- <script src="{{asset('js/scripts/pages/dashboard-analytics.js')}}"></script> --}}
@endsection
