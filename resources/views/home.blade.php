@extends('layouts.navbar')
@section('title')
Request Apps | Dashboard
@endsection
@section('content')
<!-- ============================================================== -->
  <!-- Bread crumb and right sidebar toggle -->
  <!-- ============================================================== -->
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Dashboard</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div>
    {{-- <div>
        <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
    </div> --}}
</div>
<input type="hidden" value="{{Auth::user()->id}}" class="listStaff">
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container">
    <div class="row">
      
    <div class="col-md-12">
      <div class="row">
        <div class="dashboard-atas col-md-4">
              <!-- card -->
              <div class="card card-inverse card-primary">
                  <div class="card-body">
                      <div class="d-flex">
                          <div class="m-r-20 align-self-center">
                              <h1 class="text-white"><i class="ti-pie-chart"></i></h1></div>
                          <div>
                              <h4 class="card-title">Request Baru</h4>
                              <div class="card-subtitle form-material">
                                <input type="text" class="form-control" id="min-date" style="background-color: #0000ff00;color: white;" value="{{date('M Y')}}" readonly>
                              </div> 
                              <input type="hidden" id="timepicker1" value="{{date('Y-m')}}">
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-12 align-self-center">
                              <h2 class="font-light text-white requestBaru">
                                
                              </h2>
                          </div>
                      </div>
                  </div>
              </div>
              <!-- card -->
          </div>
          <div class="dashboard-atas col-md-4">
              <!-- card -->
              <div class="card card-inverse card-warning">
                  <div class="card-body">
                      <div class="d-flex">
                          <div class="m-r-20 align-self-center">
                              <h1 class="text-white"><i class="ti-pie-chart"></i></h1></div>
                          <div>
                              <h4 class="card-title">Sedang Dikerjakan</h4>
                              <div class="card-subtitle form-material">
                                 <input type="text" class="form-control" id="min-date2" style="background-color: #0000ff00;color: white;" value="{{date('M Y')}}" readonly>
                              </div> 
                              <input type="hidden" id="timepicker2" value="{{date('Y-m')}}">
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-12 align-self-center">
                              <h2 class="font-light text-white sedangDikerjakan">
                                
                              </h2>
                          </div>
                      </div>
                  </div>
              </div>
              <!-- card -->
          </div>
          <div class="dashboard-atas col-md-4">
              <!-- card -->
              <div class="card card-inverse card-danger">
                  <div class="card-body">
                      <div class="d-flex">
                          <div class="m-r-20 align-self-center">
                              <h1 class="text-white"><i class="ti-pie-chart"></i></h1></div>
                          <div>
                              <h4 class="card-title">Request Terselesaikan</h4>
                              <div class="card-subtitle form-material">
                                 <input type="text" class="form-control" id="min-date3" style="background-color: #0000ff00;color: white;" value="{{date('M Y')}}" readonly>
                              </div> 
                              <input type="hidden" id="timepicker3" value="{{date('Y-m')}}">
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-12 align-self-center">
                              <h2 class="font-light text-white requestTerselesaikan">
                                
                              </h2>
                          </div>
                      </div>
                  </div>
              </div>
              <!-- card -->
          </div>
          <!-- card -->
          
          <div class="col-md-4" >
            <!-- Column -->
              <div class="card" style="height:345px"> <img class="card-img-top" src="{{url('template/assets/images/background/user-info.jpg')}}" alt="Card image cap" style="max-height: 100px;">
                  <div class="card-body little-profile text-center">
                      <div class="pro-img">
                        <a href="{{Auth::User()->foto != null && Auth::User()->foto!=""?url('/uploadgambar/'.Auth::User()->foto):url('/img/user-icon.png')}}" class="user_profile_url fancybox">
                          <img class="user_profile" src="{{Auth::User()->foto != null && Auth::User()->foto!=""?url('/uploadgambar/'.Auth::User()->foto):url('/img/user-icon.png')}}" alt="user" />
                        </a>
                      </div>
                      <div>
                        <div class="users-title">
                          <a href="{{url('/users/form?id='.Auth::User()->id)}}">
                            <h3 class="m-b-0"><span class="user_name">{{Auth::User()->name}}</span>
                            </h3>
                          </a>
                        </div>
                      </div>
                      <p>
                        <span class="user_role">{{Auth::User()->role}}</span>
                        {{-- <a href="{{url('/users/form?id='.Auth::User()->id)}}"><i class="fa fa-edit"></i></a> --}}
                      </p>
                      <hr>               
                      
                      {{-- <a href="{{url('/users/form?id='.Auth::User()->id)}}" class="m-t-10 waves-effect waves-dark btn btn-info btn-rounded user_detail_href">View Profile</a> --}}
                      @if(Auth::User()->role == "Admin")
                        <a href="{{url('/request/add')}}" class="m-t-10 waves-effect waves-dark btn btn-sm btn-success btn-rounded user_detail_href"><i class="fa fa-plus"></i> Tambah Request</a>
                      @endif
                  </div>
              </div>
              <!-- Column -->
          </div>
          <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Request Sedang Dikerjakan : 
                      {{-- <a href="#!" style="float: right;">View All</a> --}}
                    </h5>
                    <hr>
                    <div class="amp-pxl m-t-5" style="height: 254px;overflow-y: auto;">
                      <ul id="requestSedangDikerjakan">
                        <li>
                          <a href="#">
                            <p>
                              <span>Data Tidak Ditemukan</span>
                            </p>
                          </a>
                        </li>
                      </ul>
                    </div>
                </div>
            </div>
          </div>
      </div>
    </div>

@section("javascript")
<script src="{{url('/template/assets/plugins/Chart.js/Chart.min.js')}}"></script>
<script src="{{url('/js/dashboard/index.js?v='.time())}}"></script>
@endsection
</div>
@endsection
