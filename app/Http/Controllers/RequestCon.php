<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Requests;
use App\AgixFunc;
use App\Project;
use App\Tim;

class RequestCon extends Controller
{
    public function index(){
      return view('request.index');
    }

    public function addRequest(){
      $project  = new Project;
      $tim      = new Tim;
      $allProject = $project->selectAllProject();
      $allTim = $tim->selectAllTim();
      
      return view('request.form')
        ->with('project', $allProject)
        ->with('tim', $allTim);
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
        'search'  => $req->search
      ];
      $countRequest = $obj->jsonListRequest(1, $param)->count();
      $dataRequest = $obj->jsonListRequest(0, $param);

      $result = [
        $countRequest, $dataRequest
      ];

      return $agix->jsonEncode($result);
    }
}
