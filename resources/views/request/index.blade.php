@extends('layouts.navbar')
@section('title')
Request App | Request
@endsection
@section("content")
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
          <h4 class="card-title m-b-0">List Request</h4></div>
        <div class="card-body collapse show">
          <div class="row">              
            <div class="col-6">
              <div class="btn-group">
                @if(Auth::user()->role == "Admin")
                <a href="{{url('/request/download')}}" class="btn btn-sm btn-info btn-modal-request">
                  <i class="fa fa-file"></i> Download
                </a>
                @endif
              </div>
            </div>
            <div class="col-6">
              <div class="btn-group float-right">
                @if(Auth::user()->role != "Programmer")
                <a href="{{url('/request/add')}}" class="btn btn-sm btn-info btn-modal-request">
                  <i class="fa fa-plus"></i> Tambah Request
                </a>
                @endif
              </div>
            </div>
            <div class="col-md-12">
              <br>
            </div>
            <div class="col-md-12 tableRequest">
              <div class="row">
                <div class="col-md-3">
                  <div class="input-group">
                    <select name="statusRequest" id="statusRequest" class="form-control form-control-sm">
                      <option value="all">All</option>
                      <option value="0">Request Baru</option>
                      <option value="1">Request Sedang Dikerjakan</option>
                      <option value="2">Testing</option>
                      <option value="3">Revisi</option>
                      <option value="4">Terselesaikan</option>
                      <option value="5">Publish</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-group">
                    <input type="text" class="form-control form-control-sm" placeholder="Cari Request..." id="cariRequest">
                    <div class="input-group-append">
                      <button type="button" class="btn btn-info btn-sm" onclick="cariRequest()"><i class="fa fa-search"></i></button>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
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
                          <th>Nama Request</th>
                          <th>Status</th>
                          @if (Auth::user()->role == 'Admin')
                            <th>Programmer</th>  
                          @endif
                          {{-- <th>Bonus</th> --}}
                          @if(Auth::user()->role == "Admin")
                          <th>Actions</th>
                          @endif
                        </tr>
                      </thead>
                      <tbody id="tbodyListRequest">
                        
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
<script src="{{url('js/request/request.js?v='.time())}}"></script>
@endsection