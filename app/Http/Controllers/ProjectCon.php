<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AgixFunc;
use App\Project;
use DB;

class ProjectCon extends Controller
{
    public function index(){
      return view('project/index');
    }

    public function processForm(Request $req){
      $kdProject    = $req->id_project;
      $namaProject  = $req->nama_project;
      $status       = $req->status_project;
      $obj          = new Project;
      $agix         = new AgixFunc;
      $data         = [
        'namaProject' => $namaProject
      ];

      if($kdProject != NULL && $kdProject != ''){
        // proses edit
        $arrInput   = [
          'idProject' => $kdProject,
          'status'    => $status
        ];
        $data       = array_merge($data, $arrInput);
        $result     = $obj->updateProject($data);
      } else{
        // proses input
        $kdProject  = $agix->nextCode('idProject', 'ms_project');
        $arrInput   = [
          'idProject' => $kdProject,
          'status'    => 0,
          'deleted'   => 0
        ];
        $data = array_merge($data, $arrInput);
        $result = $obj->insertProject($data);
      }

      return $result;
    }

    public function jsonlListProject(Request $req){
      $page   = $req->page;
      $search = $req->search;
      $obj    = new Project;
      $agix   = new AgixFunc;

      $getCount = $obj->getJsonListProject(1, $page, $search)->count();
      $data = $obj->getJsonListProject(0, $page, $search);

      $result = [$getCount, $data];

      return $agix->jsonEncode($result);
    }

    public function jsonDetailProject(Request $req){
      $id   = $req->id;
      $obj  = new Project;
      $agix = new AgixFunc;

      $result = $obj->selectDetailProject($id);
      return $agix->jsonEncode($result);
    }

    public function deleteProject(Request $req){
      $id = $req->id;
      $obj = new Project;
      $agix = new AgixFunc;

      $result = $obj->deleteProject($id);

      return $agix->jsonEncode($result);
    }
}
