<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\AgixFunc;
use Auth;

class UserCon extends Controller
{
    public function index(){
      return view('user/index');
    }

    public function showForm(Request $req){
      $obj  = new User;
      $id   = $req->id;
      if (Auth::User()->role != "Admin" && Auth::user()->id != $id) {
          return redirect("/");
      }

      $data = $obj->detailUser($id);
      return view('user/form')
        ->with('data', $data);
    }

    public function processForm(Request $req){
      $obj = new User;
    	$data = $obj->prosesUsers($req);

      return json_encode($data);
    }

    public function jsonListUser(Request $req){
      $obj    = new User;
      $agix   = new AgixFunc;
      $param  = [
        'page'    => $req->page,
        'search'  => $req->search,
        'role'    => $req->role
      ];

      $userCount = $obj->jsonListUser(1, $param)->count();
      $data = $obj->jsonListUser(0, $param);
      $result = [$userCount, $data];

      return $agix->jsonEncode($result);
    }

    public function deleteUser(Request $req){
      $id = $req->id;
      $obj = new User;
      $agix = new AgixFunc;

      $result = $obj->deleteUser($id);

      return $agix->jsonEncode($result);
    }

    public function setThemeUser(Request $req){
      $obj = new User;
      $dark = $req->dark;
      $idUser = Auth::user()->id;
      $result = $obj->setThemeUser($dark, $idUser);

      return $result;
    }
}
