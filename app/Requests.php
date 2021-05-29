<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\AgixFunc;
use Auth;

class Requests extends Model
{
    public function updateRequest($req){
      $id           = $req->idRequest;
      $arrUpdate    = [
        'idProject'     => $req->project,
        'judulRequest'  => $req->judulRequest,
        'deskripsi'     => $req->deskripsi,
        'status'        => $req->status
      ];

      if($req->tim != 'all'){
        $arrUpdate['idTim'] = $req->tim;
      }

      if($req->tglPenjadwalan != '' && $req->tglPenjadwalan != NULL){
        $arrUpdate['tglPenjadwalan'] = $req->tglPenjadwalan;
      }
      
      $process = DB::table('tr_request')
        ->where('idRequest', $id)
        ->update($arrUpdate);

      if($process){
        $message  = 'Update Data Berhasil';
        $error    = false;
      } else{
        $message  = 'Update Data Gagal';
        $error    = true;
      }
      
      $result = [
        'message' => $message,
        'error'   => $error
      ];

      return $result;
    }

    public function insertRequest($req){
      $agix = new AgixFunc;
      $arrInsert    = [
        'idRequest'     => $agix->nextCode('idRequest', 'tr_request'),
        'idProject'     => $req->project,
        'judulRequest'  => $req->judulRequest,
        'deskripsi'     => $req->deskripsi,
        'status'        => 0,
        'idUser'        => Auth::user()->id,
        'tglRequest'    => date("Y-m-d")
      ];

      $process = DB::table('tr_request')
        ->insert($arrInsert);

      if($process){
        $message  = 'Insert Data Berhasil';
        $error    = false;
      } else{
        $message  = 'Insert Data Gagal';
        $error    = true;
      }
      
      $result = [
        'message' => $message,
        'error'   => $error
      ];

      return $result;
    }

    public function jsonListRequest($seluruh = 0, $param){
      $search = $param['search'];
      $select = [
        'tr_request.idRequest as idRequest',
        'tr_request.idTim as idTeam',
        'tr_request.idUser as idUser',
        'tr_request.idProject as idProject',
        'ms_project.namaProject as namaProject',
        'users.name as namaUser',
        'tr_request.judulRequest as judulRequest',
        'tr_request.status as status',
        DB::raw('DATE_FORMAT(tr_request.tglPenjadwalan, "%d/%m/%Y") as tglPenjadwalan')
      ];
      $data = DB::table('tr_request')
        ->leftJoin('ms_project', 'tr_request.idProject', '=', 'ms_project.idProject')
        ->leftJoin('tr_tim', 'tr_tim.idTeam', '=', 'tr_request.idTim')
        ->leftJoin('users', 'tr_tim.idUser', '=', 'users.id')
        ->select($select)
        ->where('tr_request.deleted', 0);

      if(Auth::user()->role == 'Programmer'){
        $data = $data->where('tr_tim.idUser', '=', Auth::user()->id);
      } else if(Auth::user()->role == 'User'){
        $data = $data->where('tr_request.idUser', '=', Auth::user()->id);
      }
      if($search != '' && $search != NULL){
        $data = $data->where(function($query) use ($search){
          $query = $query->where('tr_request.judulRequest', 'LIKE', '%'.$search.'%')
            ->orWhere('ms_project.namaProject', 'LIKE', '%'.$search.'%')
            ->orWhere('users.name', 'LIKE', '%'.$search.'%');
        });
      }

      if($param['status'] != 'all'){
        $data = $data->where('tr_request.status', $param['status']);
      }

      // getting data
			if ($seluruh == 1) {
    		$data = $data->get();
    	}else{
    		$data = $data->skip($param['page']*20)->take(20)->get();
    	}

      return $data;
    }

    public function selectDetailRequest($id = NULL){
      if ($id == NULL || $id == '') {
          return NULL;
      }

      $select = [
        'tr_request.idRequest as idRequest',
        'tr_request.idTim as idTeam',
        'tr_request.idUser as idUser',
        'tr_request.idProject as idProject',
        'ms_project.namaProject as namaProject',
        'users.name as namaUser',
        'tr_request.judulRequest as judulRequest',
        'tr_request.status as status',
        'tr_request.deskripsi as deskripsi',
        'tr_request.tglPenjadwalan as tglPenjadwalan',
        DB::raw('DATE_FORMAT(tr_request.tglRequest, "%d/%m/%Y") as tglRequest'),
      ];
      $data = DB::table('tr_request')
        ->leftJoin('users', 'tr_request.idUser', '=', 'users.id')
        ->leftJoin('ms_project', 'tr_request.idProject', '=', 'ms_project.idProject')
        ->leftJoin('tr_tim', 'tr_tim.idTeam', '=', 'tr_request.idTim')
        ->select($select)
        ->where('tr_request.idRequest', $id)
        ->first();

      return $data;
    }

    public function deleteRequest($id){
      $process = DB::table('tr_request')
        ->where('idRequest', $id)
        ->update(['deleted' => 1]);

      if($process){
        $message  = 'Delete Data Berhasil';
        $error    = false;
      } else{
        $message  = 'Delete Data Gagal';
        $error    = true;
      }
      
      $result = [
        'message' => $message,
        'error'   => $error
      ];

      return $result;
    }

    public function loadRequestUser($id, $periode){
      $requestBaru = $this->selectRequestBaru($id, $periode)->count();
      $sedangDikerjakan = $this->selectSedangDikerjakan($id, $periode)->count();
      $requestTerselesaikan = $this->selectRequestTerselesaikan($id, $periode)->count();
      $requestBlnIni = $this->selectSedangDikerjakan($id, $periode);

      $result = [
        'requestBaru' => $requestBaru,
        'sedangDikerjakan' => $sedangDikerjakan,
        'requestTerselesaikan' => $requestTerselesaikan,
        'data' => $requestBlnIni
      ];

      return $result;
    }

    public function selectRequestBaru($id, $periode){
      $result = DB::table('tr_request')
        ->leftJoin('tr_tim', 'tr_request.idTim', '=', 'tr_tim.idTeam')
        ->where('tglRequest', 'LIKE', '%'.$periode.'%')
        ->where('tr_request.deleted', 0);

      if(Auth::user()->role == 'Programmer'){
        $result = $result->where('tr_tim.idUser', $id);
      } else if(Auth::user()->role == 'User'){
        $result = $result->where('tr_request.idUser', $id);
      }

      $result = $result->get();
      return $result;
    }

    public function selectSedangDikerjakan($id, $periode){
      $select = [
        'tr_request.judulRequest as judulRequest',
        'tr_request.idRequest as idRequest'
      ];
      $result = DB::table('tr_request')
        ->leftJoin('tr_tim', 'tr_request.idTim', '=', 'tr_tim.idTeam')
        ->select($select)
        ->where('tglPenjadwalan', 'LIKE', '%'.$periode.'%');

      if(Auth::user()->role == 'Programmer'){
        $result = $result->where('tr_tim.idUser', $id);
      } else if(Auth::user()->role == 'User'){
        $result = $result->where('tr_request.idUser', $id);
      }

      $result = $result->get();
      return $result;
    }

    public function selectRequestTerselesaikan($id, $periode){
      $result = DB::table('tr_request')
        ->leftJoin('tr_tim', 'tr_request.idTim', '=', 'tr_tim.idTeam')
        ->where('tglSelesai', 'LIKE', '%'.$periode.'%');

      if(Auth::user()->role == 'Programmer'){
        $result = $result->where('tr_tim.idUser', $id);
      } else if(Auth::user()->role == 'User'){
        $result = $result->where('tr_request.idUser', $id);
      }

      $result = $result->get();
      return $result;
    }
}
