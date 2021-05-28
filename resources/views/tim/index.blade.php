@extends('layouts.navbar')
@section('title')
Request App | TIM
@endsection
@section("content")
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Tim</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Tim</a></li>
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
          <h4 class="card-title m-b-0">List Tim</h4></div>
        <div class="card-body collapse show">
          <div class="row">              
            <div class="col-12">
              <div class="btn-group float-right">
                @if(Auth::user()->role == "Admin")
                <a href="#!" class="btn btn-sm btn-info btn-modal-tim">
                  <i class="fa fa-plus"></i> Tambah Tim
                </a>
                @endif
              </div>
            </div>
            <div class="col-md-12">
              <br>
            </div>
            <div class="col-md-12 tableTim">
              <div class="row">
                <div class="col-md-2">
                  <select class="form-control form-control-sm" id="project" onchange="cariTim()" data-toggle="tooltip" data-placement="top" title="Pilih Project">
                    <option value="">Seluruh</option>
                    @if (isset($project))
                        @foreach ($project as $item)
                          <option value="{{$item->idProject}}">{{$item->namaProject}}</option>
                        @endforeach
                    @endif
                  </select>
                </div>
                <div class="col-md-4">
                  <div class="input-group">
                    <input type="text" class="form-control form-control-sm" placeholder="Cari Tim..." id="cariTim">
                    <div class="input-group-append">
                      <button type="button" class="btn btn-info btn-sm" onclick="cariTim()"><i class="fa fa-search"></i></button>
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
                          <th>Nama Programmer</th>
                          <th>Nama Project</th>
                          {{-- <th>Bonus</th> --}}
                          @if(Auth::user()->role == "Admin")
                          <th>Actions</th>
                          @endif
                        </tr>
                      </thead>
                      <tbody id="tbodyListTim">
                        
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

<div class="modal fade modal-tim" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{url('/tim/processForm')}}" method="post" id="form_tim">
          @csrf
          <input type="hidden" name="id_tim" id="id_tim" value="">
          <div class="modal-header">
              <h4 class="modal-title" id="myLargeModalLabel">Form tim</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Nama Programmer</label>
                  <div class="controls">
                    <select class="form-control form-control-sm" name="id_programmer" id="id_programmer">
                      <option value="">Seluruh</option>
                      @if (isset($programmer))
                          @foreach ($programmer as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                          @endforeach
                      @endif
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label>Pilih Project</label>
                  <div class="controls">
                    <select class="form-control form-control-sm" name="id_project" id="id_project">
                      <option value="">Seluruh</option>
                      @if (isset($project))
                          @foreach ($project as $item)
                            <option value="{{$item->idProject}}">{{$item->namaProject}}</option>
                          @endforeach
                      @endif
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
<script src="{{url('js/tim/tim.js?v=1')}}"></script>
@endsection