<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AgixFunc;
use DB;
use Auth;

class Revisi extends Model
{
    public function selectRevisi($id){
      $select = DB::table('tr_revisi')
        ->select('*')
        ->where('tr_revisi.idRequest', $id)
        ->where('deleted', 0)
        ->get();

      return $select;
    }

    public function updateRevisi($id, $checkRevisi, $keteranganRevisi){
      if(Auth::user()->role == 'User'){
        return false;
      }
      $agix   = new AgixFunc;
      $status = '';
      $delete = DB::table('tr_revisi')
        ->where('idRequest', $id)
        ->update(['deleted' => 1]);
      foreach ($checkRevisi as $key => $value) {
        $idRevisi = $agix->nextCode('idRevisi', 'tr_revisi');
        if($value == "on"){
          $status = 1;
        } else{
          $status = 0;
        }
        $insert = [
          'idRevisi' => $idRevisi,
          'idRequest' => $id,
          'idUser' => Auth::user()->id,
          'revisi' => $keteranganRevisi[$key],
          'status' => $status,
          'tglRevisi' => date('Y-m-d'),
          'deleted' => 0
        ];

        if($status == 1){
          $insert['tglSelesai'] = date('Y-m-d');
        } else{
          $insert['tglSelesai'] = NULL;
        }

        $proses = DB::table('tr_revisi')
          ->insert($insert);
      }

    }
}
