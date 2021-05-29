@extends('layouts.navbar')
@section('title')
Request App | Request
@endsection
@section("content")
<style type="text/css">
 .select2-container--default .select2-selection--multiple {      
    padding: 0px 10px;
}
.inputDisable{
  background-color: white !important;
}
</style>
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Request</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Request</a></li>
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
          <h4 class="m-b-0">Form Request</h4></div>
        <div class="card-body">
          <form action="{{url('/request/processForm')}}" id="formRequest" method="post" enctype="multipart/form-data">
            <input type="hidden" name="idRequest" value="{{isset($data->idRequest)?$data->idRequest:''}}">
            @csrf
            <div class="row">                
              <div class="col-md-12">
                <div class="form-group">
                  <label>Judul Request</label>
                  <input type="text" name="judulRequest" class="form-control form-control-sm" placeholder="Masukkan Judul request..." value="{{isset($data->judulRequest)?$data->judulRequest:''}}" required {{Auth::user()->role != "Programmer" ? '' :'disabled'}}>
                </div>
              </div>
              @if (Auth::user()->role != "User" && isset($data))
                <div class="col-md-6">
                  <div class="form-group">
                    <label>User Request</label>
                    <input type="text" name="userRequest" class="form-control form-control-sm" placeholder="Masukkan nama..." value="{{isset($data->namaUser)?$data->namaUser:''}}" required disabled>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Tgl Request</label>
                    <input type="text" name="tglRequest" class="form-control form-control-sm" placeholder="Tanggal Request" value="{{isset($data->tglRequest)?$data->tglRequest:''}}" disabled>
                  </div>
                </div>
              @endif
              <div class="col-md-12">
                <div class="form-group">
                  <label>Deskripsi</label>
                  <textarea id="konten" class="form-control" name="deskripsi" rows="20" cols="50">{{ isset($data->deskripsi)?$data->deskripsi:''}}</textarea>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Pilih Project</label>
                  <select name="project" id="project" class="form-control form-control-sm" required {{Auth::user()->role != "Programmer" ? '' :'disabled'}}>
                    <option value="all">Pilih Project</option>
                    @foreach ($project as $itemProject)
                      <option value="{{$itemProject->idProject}}" {{isset($data->idProject) ? ($data->idProject == $itemProject->idProject ? 'selected' : '') : ''}}>{{$itemProject->namaProject}}</option>  
                    @endforeach
                  </select>
                </div>
              </div>
              @if (Auth::user()->role === "User")
                <input type="hidden" name="id" value="{{isset($data->status)?$data->status:'0'}}">
              @else
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Pilih TIM</label>
                    <select name="tim" id="tim" class="form-control form-control-sm" required {{Auth::user()->role === "Admin" ? '' :'disabled'}}>
                      <option value="all">Pilih Team</option>
                      @foreach ($tim as $itemTim)
                        <option value="{{$itemTim->idTeam}}" {{isset($data->idTeam) ? ($data->idTeam == $itemTim->idTeam ? 'selected' : '') : ''}}>{{$itemTim->namaUser}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              @endif
              @if (Auth::user()->role === "Admin")
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Penjadwalan</label>
                    <input type="text" class="form-control inputDisable" id="penjadwalan" value="{{isset($data->tglPenjadwalan) ? date('M Y', strtotime($data->tglPenjadwalan)) : date('M Y')}}" readonly>
                  </div>
                </div>
                <input type="hidden" name="tglPenjadwalan" id="tampungPenjadwalan" value="{{isset($data->tglPenjadwalan)?$data->tglPenjadwalan:date('Y-m-d')}}">
              @else
                <input type="hidden" name="penjadwalan" value="{{isset($data->tglPenjadwalan)?$data->tglPenjadwalan:''}}">
              @endif

              @if (Auth::user()->role == "Admin" || Auth::user()->role == "Programmer" )
              <div class="col-md-6">
                <div class="form-group">
                  <label>Status</label>
                  <select name="status" id="status" class="form-control form-control-sm" required>
                    <option value="all">Pilih Status</option>
                    <option value="0"{{isset($data->status) ? ($data->status == "0" ? 'selected' : '') : ''}}>Baru</option>  
                    <option value="1"{{isset($data->status) ? ($data->status == "1" ? 'selected' : '') : ''}}>Proses</option>
                    <option value="2"{{isset($data->status) ? ($data->status == "2" ? 'selected' : '') : ''}}>Testing</option>
                    <option value="3"{{isset($data->status) ? ($data->status == "3" ? 'selected' : '') : ''}}>Revisi</option>
                    <option value="4"{{isset($data->status) ? ($data->status == "4" ? 'selected' : '') : ''}}>Terselesaikan</option>
                    <option value="5"{{isset($data->status) ? ($data->status == "5" ? 'selected' : '') : ''}}>Publish</option>
                  </select>
                </div>
              </div>
              @else
                  
              @endif

              <div class="col-md-12">
                <hr>
              </div>
              <div class="col-md-12">
                <div class="float-right">
                  <div class="btn-group">
                    <button type="submit" class="btn btn-success">Simpan</button>
                  </div>
                  <div class="btn-group">
                    @if(Auth::User()->role != "Programmer")
                      <a href="{{url('/request')}}" class="btn btn-danger">Batal</a>
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
<script src="{{url('/js/request/form.js')}}"></script>
<script src="{{asset('editor/ckeditor/ckeditor.js')}}"></script>
<link href="{{ asset('editor/ckeditor/plugins/codesnippet/lib/highlight/styles/default.css') }}" rel="stylesheet">
<script src="{{ asset('editor/ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js') }}"></script>
<script>
  $(document).ready(function(){
    var konten = document.getElementById("konten");
      CKEDITOR.replace(konten,{
      language:'en-gb',
      filebrowserBrowseUrl: link+'/editor/ckfinder/ckfinder.html',
      filebrowserImageBrowseUrl: link+'/editor/ckfinder/ckfinder.html?Type=Images',
      filebrowserUploadUrl: link+'/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
      filebrowserImageUploadUrl: link+'/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
      filebrowserWindowWidth : '1000',
      filebrowserWindowHeight : '700'
    });
    CKEDITOR.config.allowedContent = true;
    $("#penjadwalan").datepicker( {
        format: "M yyyy",
        viewMode: "months", 
        minViewMode: "months"
    }).on('changeDate', function (ev) {
        $(this).blur();
        $(this).datepicker('hide');
        setDateValue(ev.date);
    });
  })
</script>
<script>hljs.initHighlightingOnLoad();</script>
@endsection