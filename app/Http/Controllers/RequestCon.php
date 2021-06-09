<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Requests;
use App\AgixFunc;
use App\Project;
use App\Tim;
use App\Revisi;
use Auth;

class RequestCon extends Controller
{
    public function index(){
      return view('request.index');
    }

    public function addRequest(Request $req){
      $project    = new Project;
      $tim        = new Tim;
      $request    = new Requests;
      $revisi     = new Revisi;
      $id         = $req->id;
      $allProject = $project->selectAllProject();
      $data       = $request->selectDetailRequest($id);
      $dataRevisi = $revisi->selectRevisi($id);

      $kdProject = '';
      if ($data != NULL) {
        $kdProject = $data->idProject;
      }
      $allTim     = $tim->selectTimByRequest($kdProject);
      
      return view('request.form')
        ->with('project', $allProject)
        ->with('tim', $allTim)
        ->with('data', $data)
        ->with('revisi', $dataRevisi);
    }

    public function processForm(Request $req){
      $obj = new Requests;
      $agix = new AgixFunc;
      if($req->idRequest != NULL && $req->idRequest != ''){
        // update
        $result = $obj->updateRequest($req);
      } else{
        // insert
        $result = $obj->insertRequest($req);
      }

      return $agix->jsonEncode($result);
    }

    public function jsonListRequest(Request $req){
      $obj = new Requests;
      $agix = new AgixFunc;
      $param = [
        'idTim'   => $req->idTim,
        'page'    => $req->page,
        'search'  => $req->search,
        'status'  => $req->status
      ];
      $countRequest = $obj->jsonListRequest(1, $param)->count();
      $dataRequest = $obj->jsonListRequest(0, $param);
      $role         = Auth::user()->role;

      $result = [
        $countRequest, $dataRequest, $role
      ];

      return $agix->jsonEncode($result);
    }

    public function deleteRequest(Request $req){
      $id = $req->id;
      $obj = new Requests;
      $agix = new AgixFunc;

      $result = $obj->deleteRequest($id);

      return $agix->jsonEncode($result);
    }

    public function loadRequestUser(Request $req){
      $id = $req->id;
      $periode = $req->periode;
      $obj = new Requests;
      $agix = new AgixFunc;

      $result = $obj->loadRequestUser($id, $periode);

      return $agix->jsonEncode($result);
    }

    public function download(){
      $obj = new Requests;
      $agix = new AgixFunc;
      $param = [
        'page'    => 1,
        'search'  => '',
        'status'  => 'all'
      ];

      $result = $obj->jsonListRequest(1, $param);

      return view('request.rekap')
        ->with('data', $result);
    }
}
