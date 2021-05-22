@extends('layouts.navbar')
@section('title')
Request App | Project
@endsection
@section("content")
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Project</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Project</a></li>
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
          <h4 class="card-title m-b-0">List Project</h4></div>
        <div class="card-body collapse show">
          <div class="row">              
            <div class="col-12">
              <div class="btn-group float-right">
                @if(Auth::user()->role == "Admin")
                <a href="#!" class="btn btn-sm btn-info btn-modal-project">
                  <i class="fa fa-plus"></i> Tambah Project
                </a>
                @endif
              </div>
            </div>
            <div class="col-md-12">
              <br>
            </div>
            <div class="col-md-12 tableProject">
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group">
                    <input type="text" class="form-control form-control-sm" placeholder="Cari Project..." id="cariProject">
                    <div class="input-group-append">
                      <button type="button" class="btn btn-info btn-sm" onclick="cariProject()"><i class="fa fa-search"></i></button>
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
                          <th>Nama Project</th>
                          <th>Status</th>
                          {{-- <th>Bonus</th> --}}
                          @if(Auth::user()->role == "Admin")
                          <th>Actions</th>
                          @endif
                        </tr>
                      </thead>
                      <tbody id="tbodyListProject">
                        
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

<div class="modal fade modal-project" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{url('/project/processForm')}}" method="post" id="form_project">
          @csrf
          <input type="hidden" name="id_project" value="">
          <div class="modal-header">
              <h4 class="modal-title" id="myLargeModalLabel">Form Project</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Nama Project</label>
                  <div class="controls">
                    <input type="text" name="nama_project" class="form-control form-control-sm" placeholder="Masukkan nama project..." required>
                  </div>
                </div>
              </div>
              <div class="col-md-12" id="groupStatusProject">
                <div class="form-group">
                  <label>Status Project</label>
                  <div class="controls">
                    {{-- <input type="text" name="nama_project" class="form-control form-control-sm" placeholder="Masukkan nama project..." required> --}}
                    <select name="status_project" id="statusProject" class="form-control form-control-sm">
                      <option value="0">Baru</option>
                      <option value="1">Dalam Pengembangan</option>
                      <option value="2">Terselesaikan</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            @if(Auth::user()->role == "Admin")
              <button type="submit" class="btn btn-success waves-effect text-left">Simpan</button>
            @endif
            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
  </div>  
  <!-- /.modal-dialog -->
</div>
@endsection
@section("javascript")
<script src="{{url('js/project/project.js')}}"></script>
@endsection