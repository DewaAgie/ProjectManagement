<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\AgixFunc;
use DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function detailUser($id){
      $data = DB::table('users')->where('id',$id)->first();
      return $data;
    }

    public function prosesUsers($req){
      $agix = new AgixFunc;
    	$id 			= $req->id;
    	$nama 		= $req->namaLengkap;
    	$telepon 	= $req->telepon;
    	$email		= $req->email;

    	if ($req->password != null && $req->password != "") {
    		$password = bcrypt($req->password);    		
    	}else{
    		$password = null;
    	}
    	$role 		= $req->role;
      $foto			= $req->fotoProfile;

    	// upload foto terlebih dahulu    	
    	if ($foto != null && $foto != "") {
    		$foto = $agix->uploadFoto($foto);    		
    	}else{
    		$foto = null;
      }

    	$data = [
        'name'    => $nama,
        'email'   => $email,
        'noTelp'  => $telepon,
        'role'    => $role
      ];

    	if ($id != null && $id != "") {
    		$data["updated_at"] = date('Y-m-d H:i:s');
    		if ($foto != null) {
    			$data["foto"] = $foto;
        }
        
    		if ($password != null) {
    			$data["password"] = $password;
    		}
        // cek data sebelumnya
        $dataUser = DB::table('users')->where('id',$id)->first();
    		DB::table('users')->where('id',$id)->update($data);
    		// response
    		$response["error"] = 0;
    		$response["message"] = "success mengupdate data user";
    		$response["data"] = $data;
    	}else{
    		$id = $agix->nextCode('id','users');

    		$data["id"] = $id;
    		$data["foto"] = $foto;
    		$data["password"] = $password;
    		$data["created_at"] = date('Y-m-d H:i:s');
    		$data["updated_at"] = date('Y-m-d H:i:s');    		
    		DB::table('users')->insert($data);
    		// response
    		$response["error"] = 0;
    		$response["message"] = "success menambah user data";
    		$response["data"] = $data;
    	}

    	return $response; 
    }

    public function jsonListUser($seluruh = 0, $param){
      $search = $param['search'];
      $page   = $param['page'];
      $role   = $param['role'];

      $data = DB::table('users')
        ->where('deleted', 0);
      if($search != '' && $search != NULL){
        $data = $data->where(function($query) use ($search){
          $query = $query->where('name', 'LIKE', '%'.$search.'%')
            ->orWhere('email', 'LIKE', '%'.$search.'%')
            ->orWhere('noTelp', 'LIKE', '%'.$search.'%');
        });
      }

      if ($role != 'Seluruh') {
        $data = $data->where('role', $role);
      }

      // getting data
			if ($seluruh == 1) {
    		$data = $data->get();
    	}else{
    		$data = $data->skip($page*20)->take(20)->get();
    	}

      return $data;
    }

    public function deleteUser($id){
      $process = DB::table('users')
        ->where('id', $id)
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

    public function selectAllProgrammer(){
      $result = DB::table('users')
        ->where('role', 'Programmer')
        ->where('deleted', 0)
        ->get();
      return $result;
    }

    public function setThemeUser($dark, $idUser){
      $process = DB::table('users')
        ->where('id', $idUser)
        ->update(['dark_mode' => $dark]);

      if($process){
        $message  = 'Update Theme Berhasil';
        $error    = false;
      } else{
        $message  = 'Update Theme Gagal';
        $error    = true;
      }

      $result = [
        'message' => $message,
        'error'   => $error
      ];
      return $result;
    }
}
