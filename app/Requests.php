<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\AgixFunc;

class Requests extends Model
{
    public function processForm($param){
      
    }

    public function updateRequest($req){
      $id           = $req->id;
      $arrUpdate    = [
        'idProject'     => $req->project,
        'judulRequest'  => $req->judulRequest,
        'deskripsi'     => $req->deskripsi,
        'idTim'           => $req->tim
      ];

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
        'status'        => 0
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

    public function jsonListRequest($param){
      $search = $param['search'];
      $select = [
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
        ->join('users', 'tr_request.idUser', '=', 'users.id')
        ->join('ms_project', 'tr_tim.idProject', '=', 'ms_project.idProject')
        ->join('tr_tim', 'tr_tim.idTeam', '=', 'tr_project.idTim')
        ->select($select)
        ->where('tr_tim.deleted', 0);
      if($search != '' && $search != NULL){
        $data = $data->where(function($query) use ($search){
          $query = $query->where('tr_request.judulRequest', 'LIKE', '%'.$search.'%')
            ->orWhere('ms_project.namaProject', 'LIKE', '%'.$search.'%');
        });
      }

      // getting data
			if ($seluruh == 1) {
    		$data = $data->get();
    	}else{
    		$data = $data->skip($page*20)->take(20)->get();
    	}

      return $data;
    }
}
