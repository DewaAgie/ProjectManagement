<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManagerStatic as Image;
use DB;

class AgixFunc extends Model
{
  public function nextCode($primary, $table){
		$result = DB::table($table)->select($primary)->orderBy($primary,'desc')->first();
		$kode = 0;
		if(is_null($result) ){
			$kode = 0;
		} else{
			$kode = $result->$primary;
		}
		$kode = $kode+1;
		$kodeString = $kode . "";
		return $kodeString;
	}

  public function uploadFoto($foto){
    $extension = "";
    $extension = $foto->getClientOriginalExtension();
    //$image = explode(".",$foto);
    //$extension = end($image);
    $filename = rand(11111,99999).'.'.$extension;
    $image = $foto;
    $destinationPath = 'uploadgambar/thumbnail';
    //$destinationPath = '../subnet/uploadgambar/thumbnail';
    $img = Image::make($image->getRealPath());

    $img->resize(600, 600, function ($constraint) {
      $constraint->aspectRatio();
    })->save($destinationPath.'/'.$filename);

    $destinationPath = 'uploadgambar';
    //$destinationPath = '../subnet/uploadgambar';
    $foto->move($destinationPath, $filename);

    return $filename;
  }

  public function jsonEncode($val, $opt = 0){
    if (version_compare(PHP_VERSION, '5.4', '>=')) {
        $opt |= JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;
    }
    return json_encode($val, $opt);

  }
}
