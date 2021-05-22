<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AgixFunc;
use DB;

class Tim extends Model
{
    public function getJsonListTim($seluruh, $page, $search, $project){
      $select = [
        'tr_tim.idTeam as idTeam',
        'tr_tim.idUser as idUser',
        'tr_tim.idProject as idProject',
        'ms_project.namaProject as namaProject',
        'users.name as namaUser'
      ];
      $data = DB::table('tr_tim')
        ->join('users', 'tr_tim.idUser', '=', 'users.id')
        ->join('ms_project', 'tr_tim.idProject', '=', 'ms_project.idProject')
        ->select($select)
        ->where('tr_tim.deleted', 0);
      if($search != '' && $search != NULL){
        $data = $data->where(function($query) use ($search){
          $query = $query->where('ms_project.namaProject', 'LIKE', '%'.$search.'%')
            ->orWhere('users.name', 'LIKE', '%'.$search.'%');
        });
      }

      if($project != ''){
        $data = $data->where('tr_tim.idProject', $project);
      }

      // getting data
			if ($seluruh == 1) {
    		$data = $data->get();
    	}else{
    		$data = $data->skip($page*20)->take(20)->get();
    	}

      return $data;
    }

    public function processForm($param){
      $agix = new AgixFunc;
      $idTim = $param['idTim'];
      $arrProcess = [
        'idUser'    => $param['idProgrammer'],
        'idProject' => $param['idProject']
      ];

      if($idTim != "" && $idTim != NULL){
        // update
        $namaProses = 'Update';
        $process = DB::table('tr_tim')
          ->where('idTeam', $idTim)
          ->update($arrProcess);
      } else{
        // insert
        $namaProses = 'Insert';
        $idTim = $agix->nextCode('idTeam', 'tr_tim');
        $arrProcess['idTeam'] = $idTim;
        $process = DB::table('tr_tim')
          ->insert($arrProcess);
      }

      if($process){
        $message  = $namaProses.' Data Berhasil';
        $error    = false;
      } else{
        $message  = $namaProses.' Data Gagal';
        $error    = true;
      }
      $result = [
        'message' => $message,
        'error'   => $error
      ];

      return $result;
    }

    public function jsonDetailTim($id){
      $select = [
        'tr_tim.idTeam as idTim',
        'users.id as idUser',
        'users.name as namaUser',
        'ms_project.idProject as idProject',
        'ms_project.namaProject as namaProject'
      ];

      $result = DB::table('tr_tim')
        ->join('users', 'users.id', '=', 'tr_tim.idUser')
        ->join('ms_project', 'tr_tim.idProject', '=', 'ms_project.idProject')
        ->select($select)
        ->where('tr_tim.idTeam', $id)
        ->first();

      return $result;
    }

    public function deleteTim($id){
      $process = DB::table('tr_tim')
        ->where('idTeam', $id)
        ->update(['deleted' => 1]);

      if($process){
        $message  = 'Hapus Data Berhasil';
        $error    = false;
      } else{
        $message  = 'Hapus Data Gagal';
        $error    = true;
      }
      
      $result = [
        'message' => $message,
        'error'   => $error
      ];

      return $result;
    }

    public function selectAllTim(){
      $select = [
        'tr_tim.idTeam as idTeam',
        'tr_tim.idUser as idUser',
        'tr_tim.idProject as idProject',
        'ms_project.namaProject as namaProject',
        'users.name as namaUser'
      ];
      
      $data = DB::table('tr_tim')
        ->join('users', 'tr_tim.idUser', '=', 'users.id')
        ->join('ms_project', 'tr_tim.idProject', '=', 'ms_project.idProject')
        ->select($select)
        ->where('tr_tim.deleted', 0)
        ->get();

      return $data;
    }
}
