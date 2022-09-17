@extends('layouts.contentLayoutMaster')

@section('title','User View')

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
             <div class="row col-8">
                <div class="col-4">
                <div class="form-group">
                    <label class="text-primary">First Name</label>
                      <p>Mayur</p>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group">
                      <label class="text-primary">Last Name</label>
                        <p>Patel</p>
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
                    <label class="text-primary">Company Name:</label>
                      <p>Brickon</p>
                  </div>
                </div>
            </div>
            <div class="row col-4">
              <div class="col-md-4 ">
                  <img src="" alt="avatar" class="users-avatar-shadow rounded-square image-preview" style="object-fit: cover;" height="210" width="170" onerror="this.src = 'https://admin.click2cure.com/no_image.jpg';">
              </div>
            </div>
          </div>


            <div class="row">

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
            </div>



        </div>
    </div>
</section>

@endsection
