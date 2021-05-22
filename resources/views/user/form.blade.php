@extends('layouts.navbar')
@section('title')
Request App | Users
@endsection
@section("content")
<style type="text/css">
 .select2-container--default .select2-selection--multiple {      
    padding: 0px 10px;
}
</style>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Users</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Users</a></li>
            <li class="breadcrumb-item active">Form</li>
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
      <div class="card">
        <div class="card-header">
          <h4 class="m-b-0">Form Users</h4></div>
        <div class="card-body">
          <form action="{{url('/users/processForm')}}" id="formStaff" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="{{isset($data->id)?$data->id:''}}">
            @csrf
            <div class="row">                
              <div class="col-md-12">
                <div class="form-group">
                  <label>Nama Lengkap</label>
                  <input type="text" name="namaLengkap" class="form-control form-control-sm" placeholder="Masukkan nama..." value="{{isset($data->name)?$data->name:''}}" required {{Auth::user()->role === "Admin" || Auth::user()->id == $data->id ? '' :'disabled'}}>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Nomor Telepon</label>
                  <input type="text" name="telepon" class="form-control form-control-sm" placeholder="Masukkan Telepon..." value="{{isset($data->noTelp)?$data->noTelp:''}}" required {{Auth::user()->role === "Admin" || Auth::user()->id == $data->id ? '' :'disabled'}}>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Email</label>
                  <div class="controls">
                    <input type="email" name="email" class="form-control form-control-sm" placeholder="Masukkan email..." value="{{isset($data->email)?$data->email:''}}" data-validation-required-message="This field is required" required {{Auth::user()->role === "Admin" || Auth::user()->id == $data->id ? '' :'disabled'}}>
                  </div> 
                </div>               
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Password</label>
                  <div class="controls">
                    <input type="password" name="password" class="form-control form-control-sm" {{isset($data->id)?'':'required'}} {{Auth::user()->role === "Admin" || Auth::user()->id == $data->id ? '' :'disabled'}}>
                  </div>
                </div>                
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Re-Password</label>
                  <div class="controls">
                    <input type="password" name="password2" data-validation-match-match="password" class="form-control form-control-sm" {{isset($data->id)?'':'required'}} {{Auth::user()->role === "Admin" || Auth::user()->id == $data->id ? '' :'disabled'}}>
                  </div>
                </div>
              </div>              
              <div class="col-md-6">
                <div class="form-group">
                  <label>Foto</label>
                  <div class="input-group">
                    <input type="file" target="fotoProfile_preview" name="fotoProfile" accept="image/*" class="form-control form-control-sm inputFoto" {{Auth::user()->role === "Admin" || Auth::user()->id == $data->id ? '' :'disabled'}}>
                     <div class="input-group-append fotoProfile_preview" style="display: {{isset($data->foto) && $data->foto != null?'':'none'}};">
                        <a href="{{isset($data->foto)?url('/uploadgambar/'.$data->foto):'#!'}}" class="btn btn-primary btn-sm fancybox"><i class="fa fa-image py-2"></i></a>
                      </div>
                  </div>
                </div>
              </div>
              @if(Auth::User()->role == "Admin")
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-control form-control-sm change-role">
                      @if(Auth::User()->role == 'Admin')
                      <option selected>Admin</option>
                      @endif
                      <option {{isset($data->role) && $data->role == "Programmer"?'selected':''}}>Programmer</option>
                      <option {{isset($data->role) && $data->role == "User"?'selected':''}}>User</option>
                    </select>
                  </div>
                </div>
              @else
              <input type="hidden" name="role" value="{{$data->role}}">
              @endif

              <div class="col-md-12">
                <hr>
              </div>
              <div class="col-md-12">
                <div class="float-right">
                  @if(Auth::User()->role == "Admin" || Auth::user()->id == $data->id)
                  <div class="btn-group">
                    <button type="submit" class="btn btn-success">Simpan</button>
                  </div>
                  @endif
                  <div class="btn-group">
                    @if(Auth::User()->role == "Admin")
                      <a href="{{url('/users')}}" class="btn btn-danger">Batal</a>
                    @else
                      <a href="javascript:history.back()" class="btn btn-danger">Batal</a>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section("javascript")
<script src="{{url('/js/user/form.js')}}"></script>
@endsection