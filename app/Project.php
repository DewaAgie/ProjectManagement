<?php

namespace App;
use DB;
use App\AgixFunc;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function insertProject($arr){
      $obj      = new AgixFunc;
      $process  = DB::table('ms_project')
        ->insert($arr);

      if($process){
        $message  = 'Input Data Berhasil';
        $error    = false;
      } else{
        $message  = 'Input Data Gagal';
        $error    = true;
      }
      $result = [
        'message' => $message,
        'error'   => $error
      ];

      return $obj->jsonEncode($result);
    }

    public function updateProject($arr){
      $obj    = new AgixFunc;
      $update = [
        'namaProject' => $arr['namaProject'],
        'status'      => $arr['status']
      ];

      $process = DB::table('ms_project')
        ->where('idProject', $arr['idProject'])
        ->update($update);

      if($process){
        $message  = 'Edit Data Berhasil';
        $error    = false;
      } else{
        $message  = 'Edit Data Gagal';
        $error    = true;
      }
      $result = [
        'message' => $message,
        'error'   => $error
      ];

      return $obj->jsonEncode($result);
    }

    public function getJsonListProject($seluruh, $page, $search){
      $data = DB::table('ms_project')
        ->where('deleted', 0);
      if($search != '' && $search != NULL){
        $data = $data->where(function($query) use ($search){
          $query = $query->where('namaProject', 'LIKE', '%'.$search.'%');
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

    public function selectDetailProject($id){
      $result = DB::table('ms_project')
        ->where('idProject', $id)
        ->first();

      return $result;
    }

    public function deleteProject($id){
      $process = DB::table('ms_project')
        ->where('idProject', $id)
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

    public function selectAllProject(){
      $result = DB::table('ms_project')
        ->select('*')
        ->where('deleted', 0)
        ->get();

      return $result;
    }
}
