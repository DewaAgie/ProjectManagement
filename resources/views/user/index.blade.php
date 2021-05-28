@extends('layouts.navbar')
@section('title')
Request App | User
@endsection
@section("content")
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">User</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
            <li class="breadcrumb-item active">Index</li>
        </ol>
    </div>      
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container">
  <div class="row">
    <div class="col-12">
      <div class="card card-default">
        <div class="card-header">
          <div class="card-actions">
              <a class="" data-action="collapse"><i class="ti-minus"></i></a>
              <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>
          </div>
          <h4 class="card-title m-b-0">List User</h4></div>
        <div class="card-body collapse show">
          <div class="row">              
            <div class="col-12">
              <div class="btn-group float-right">
                @if(Auth::user()->role == "Admin")
                <a href="{{url('/users/form')}}" class="btn btn-sm btn-info btn-modal-user">
                  <i class="fa fa-plus"></i> Tambah User
                </a>
                @endif
              </div>
            </div>
            <div class="col-md-12">
              <br>
            </div>
            <div class="col-md-12 tableUser">
              <div class="row">
                <div class="col-md-2">
                  <select class="form-control form-control-sm" id="roleStaff" onchange="cariUser()">
                    <option value="Seluruh">Seluruh</option>
                    <option value="Admin">Admin</option>
                    <option value="Programmer">Programmer</option>
                    <option value="Staff">Staff</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <div class="input-group">
                    <input type="text" class="form-control form-control-sm" placeholder="Cari User..." id="cariUser">
                    <div class="input-group-append">
                      <button type="button" class="btn btn-info btn-sm" onclick="cariUser()"><i class="fa fa-search"></i></button>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                   <div class="mailbox-controls">
                      <div class="float-right">                    
                      <span id="displayPage">0-0/0</span>
                        <div class="btn-group" id="btnPaging1">
                          
                        </div>
                      </div>
                    </div>
                  </div>
                <div class="col-12">
                  <div class="table-responsive">
                    <table class="table table-striped table-hover small">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama User</th>
                          <th>Email</th>
                          <th>No Telp</th>
                          <th>Role</th>
                          {{-- <th>Bonus</th> --}}
                          @if(Auth::user()->role == "Admin")
                          <th>Actions</th>
                          @endif
                        </tr>
                      </thead>
                      <tbody id="tbodyListUser">
                        
                      </tbody>
                    </table>
                  </div>
                </div>
                 <div class="col-md-12">
                    <div class="mailbox-controls">
                        <div class="float-right">                    
                        <span id="displayPage2">0-0/0</span>
                          <div class="btn-group" id="btnPaging2">
                          
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section("javascript")
<script src="{{url('js/user/user.js')}}"></script>
@endsection