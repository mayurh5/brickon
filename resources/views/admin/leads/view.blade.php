@extends('layouts.contentLayoutMaster')

@section('title','Leads View')

@section('content')

<section id="users-view">

  <div class="row">
    <div class="col-lg-12">
      <div class="row card-data-summary">
        <div class=" col-8">
          <div class="card">
            <div class="card-header">
              <div class="row">
                <blockquote class="blockquote pl-50 border-left-primary border-left-3 float-left">

                    <h4 class="mb-0 shop-title float-left">Customer Detail</h4>

                      <a class="btn btn-success float-right ml-1 lead_status" href="#" data-action="confirm" data-lead-order-id="{{$lead['id']}}">Confirm</a>
                      <a class="btn btn-danger float-right ml-2 lead_status" href="#" data-action="cancle" data-lead-order-id="{{$lead['id']}}">Cancel</a>

                </blockquote>
              </div>
            </div>
            <div class="card-body">

              <div class="row">

                  <div class="col-4">
                    <div class="form-group">
                      <label class="text-primary">Order Code:</label>
                        <p>{{@$lead['order_code']}}</p>
                    </div>
                  </div>

                    <div class="col-4">
                    <div class="form-group">
                        <label class="text-primary">Name</label>
                          <p>{{@$lead->user_details['first_name']}} {{@$lead->user_details['last_name']}}</p>
                      </div>
                    </div>

                    <div class="col-4">
                      <div class="form-group">
                        <label class="text-primary">Mobile No:</label>
                          <p>{{@$lead->user_details['phone']}}</p>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label class="text-primary">Email:</label>
                          <p>{{@$lead->user_details['email']}}</p>
                      </div>
                    </div>


                    <div class="col-4">
                      <div class="form-group">
                        <label class="text-primary">Default Price:</label>
                          <p>{{@$lead['primary_product_price']}}</p>
                      </div>
                    </div>

                    <div class="col-4">
                      <div class="form-group">
                        <label class="text-primary">Total Tons:</label>
                          <p>{{@$lead['total_tons']}}</p>
                      </div>
                    </div>


                    <div class="col-4">
                      <div class="form-group">
                        <label class="text-primary">Total:</label>
                          <p>{{@$lead['total']}}</p>
                      </div>
                    </div>

                    <div class="col-4">
                      <div class="form-group">
                          <label class="text-primary">Final Total:</label>
                            <p>{{@$lead['final_total']}}</p>
                        </div>
                      </div>

                    <div class="col-4">
                      <div class="form-group">
                        <label class="text-primary">Register On:</label>
                          <p>{{isset($lead['created_at']) ? \Helper::display_date($lead['created_at']) : '-'}}</p>
                      </div>
                    </div>

                    <div class="col-4">
                      <div class="form-group">
                        <label class="text-primary">Due Date:</label>
                        <p>{{isset($lead['due_date']) ? \Helper::display_date($lead['due_date']) : '-'}}</p>
                      </div>
                    </div>


                    <div class="col-12">
                      <div class="form-group">
                        <label class="text-primary">Billing Address:</label>
                          <p>{!! @$lead['billing_address'] !!}</p>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="form-group">
                        <label class="text-primary">Delivery Address:</label>
                          <p>{!! @$lead['delivery_address'] !!}</p>
                      </div>
                    </div>
              </div>
            </div>
          </div>
        </div>
        <div class=" col-4" >
          <div class="card">
            <div class="card-header">
              <div class="row">
                <blockquote class="blockquote pl-50 border-left-primary border-left-3 float-left">
                    <h4 class="mb-0 shop-title float-left">Order Summary</h4>
                </blockquote>
              </div>
            </div>
            <div class="card-body">
              <div class="data-order-summary">


                <div class="data d-inline-flex justify-content-between align-items-center w-100">
                  <div class="name-data">
                    <p class="m-0">Order Created</p>
                  </div>
                  <div class="amount data">
                    <p class="m-0">{{isset($lead['created_at']) ? \Helper::display_date($lead['created_at']) : '-'}}</p>
                  </div>
                </div>
                {{-- <div class="data d-inline-flex justify-content-between align-items-center w-100">
                  <div class="name-data">
                    <p class="m-0">Order Time</p>
                  </div>
                  <div class="amount data">
                    <p class="m-0">06:24 AM</p>
                  </div>
                </div> --}}
                <div class="data d-inline-flex justify-content-between align-items-center w-100">
                  <div class="name-data">
                    <p class="m-0">Sub Total</p>
                  </div>
                  <div class="amount data">
                    <p class="m-0">$ {{@$lead['total']}}</p>
                  </div>
                </div>
                <div class="data d-inline-flex justify-content-between align-items-center w-100">
                  <div class="name-data">
                    <p class="m-0">Delevery Fess</p>
                  </div>
                  <div class="amount data">
                    <p class="m-0">$ 0.00</p>
                  </div>
                </div>

                <div class="data d-inline-flex justify-content-between align-items-center w-100">
                  <div class="name-data">
                    <p class="m-0">Total Tax</p>
                  </div>
                  <div class="amount data">
                    <p class="m-0">$ {{@$lead['final_total'] - @$lead['total']}} </p>
                  </div>
                </div>


                <div class="data d-inline-flex justify-content-between align-items-center w-100">
                  <div class="name-data">
                    <p class="m-0">Final Total</p>
                  </div>
                  <div class="amount data">
                    <p class="m-0">${{@$lead['final_total']}}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-12">
          <div class="card" style="height: 100%; width: 100%">
            <div class="card-header">
                <blockquote class="blockquote pl-50 border-left-primary border-left-3 float-left">
                    <h4 class="mb-0 shop-title float-left">Leads Info</h4>
                </blockquote>

                  <div class="table-responsive table-lead-info">
                    <table class="table add-rows" id="stock_list_tbl">
                        <thead>
                            <tr>
                              <th>#</th>
                              <th>MM</th>
                              <th>QTY</th>
                              <th>rate</th>
                            </tr>
                        </thead>

                        <tbody>

                         @foreach ($lead['product'] as $key => $item)

                            <tr>
                              <td>{{$key+1}}</td>
                              <td>{{$item['product_details']['value']}}</td>
                              <td>{{$item->qty}}</td>
                              <td>{{$item->price}}</td>
                            </tr>

                         @endforeach

                        </tbody>
                    </table>
                  </div>

              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
@section('page-scripts')
<script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>
@include('scripts.leads.view_js')
@endsection
