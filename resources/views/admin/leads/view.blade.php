@extends('layouts.contentLayoutMaster')

@section('title','Leads View')

@section('content')

<section id="content-types">
    <div class="card" style="height: 100%; width: 100%">
        <div class="card-header">
          <div class="row">
            <blockquote class="blockquote pl-50 border-left-primary border-left-3 float-left">
                <h4 class="mb-0 shop-title float-left">User Detail</h4>
            </blockquote>
          </div>
        </div>
        <div class="card-body">

          <div class="row">
                <div class="col-4">
                <div class="form-group">
                    <label class="text-primary">Name</label>
                      <p>Kishan Savani</p>
                  </div>
                </div>

                <div class="col-4">
                  <div class="form-group">
                    <label class="text-primary">Mobile No:</label>
                      <p>9879446033</p>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group">
                    <label class="text-primary">Email:</label>
                      <p>mayur@gmail.com</p>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group">
                    <label class="text-primary">designation:</label>
                      <p>Developer</p>
                  </div>
                </div>

                <div class="col-4">
                  <div class="form-group">
                    <label class="text-primary">Rate(20mm):</label>
                      <p>500</p>
                  </div>
                </div>

                <div class="col-4">
                  <div class="form-group">
                    <label class="text-primary">Company Name:</label>
                      <p>Brickon</p>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group">
                    <label class="text-primary">City:</label>
                      <p>Ahemedabad</p>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group">
                      <label class="text-primary">State:</label>
                        <p>Gujrat</p>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                        <label class="text-primary">Country:</label>
                          <p>India</p>
                      </div>
                    </div>
                <div class="col-4">
                  <div class="form-group">
                    <label class="text-primary">Register On:</label>
                      <p>27-09-2022</p>
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-group">
                    <label class="text-primary">Delivery Address:</label>
                      <p>C-4, BIG SPLASH, 1ST FLR,TURBHE ROAD, SECTOR-17 VASHI, , N. BOMBAY NAVI MUMBAI 400 705 MH 000000 IN</p>
                  </div>
                </div>
          </div>


        </div>
    </div>

    <div class="card" style="height: 100%; width: 100%">
      <div class="card-header">
          <blockquote class="blockquote pl-50 border-left-primary border-left-3 float-left">
              <h4 class="mb-0 shop-title float-left">Leads Info</h4>
          </blockquote>

            <div class="table-responsive">
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
                    <tr>
                      <td>01</td>
                      <td>8</td>
                      <td>50</td>
                      <td>100</td>
                    </tr>
                    <tr>
                      <td>02</td>
                      <td>16</td>
                      <td>150</td>
                      <td>500</td>
                    </tr>

                    <tr>
                      <td>03</td>
                      <td>25</td>
                      <td>200</td>
                      <td>1000</td>
                    </tr>


                  </tbody>
              </table>
            </div>

        </div>
    </div>



</section>

@endsection
@section('page-scripts')
<script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>
@endsection
