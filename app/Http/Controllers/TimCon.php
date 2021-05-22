<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tim;
use App\AgixFunc;
use App\Project;
use App\User;
use DB;


class TimCon extends Controller
{
    //
    public function index(){
      $project  = new Project();
      $user     = new User();
      $allProject     = $project->selectAllProject();
      $allProgrammer  = $user->selectAllProgrammer();

      return view('tim/index')
        ->with('programmer', $allProgrammer)
        ->with('project', $allProject);
    }

    public function jsonListTim(Request $req){
      $page     = $req->page;
      $search   = $req->search;
      $project  = $req->project;
      $obj      = new Tim;
      $agix     = new AgixFunc;

      $getCount = $obj->getJsonListTim(1, $page, $search, $project)->count();
      $data = $obj->getJsonListTim(0, $page, $search, $project);

      $result = [$getCount, $data];

      return $agix->jsonEncode($result);
    }

    public function processForm(Request $req){
      $obj = new Tim;
      $agix = new AgixFunc;
      $param = [
        'idTim'         => $req->id_tim,
        'idProgrammer'  => $req->id_programmer,
        'idProject'     => $req->id_project
      ];

      $result = $obj->processForm($param);

      return $agix->jsonEncode($result);
    }

    public function jsonDetailTim(Request $req){
      $id   = $req->id;
      $obj  = new Tim;
      $agix = new AgixFunc;

      $result = $obj->jsonDetailTim($id);

      return $agix->jsonEncode($result);
    }

    public function deleteTim(Request $req){
      $id     = $req->id;
      $obj    = new Tim;
      $agix   = new AgixFunc;

      $result = $obj->deleteTim($id);

      return $agix->jsonEncode($result);
    }
}
