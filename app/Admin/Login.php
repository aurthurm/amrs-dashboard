<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class Login extends Model
{
    //
    public function validateLogin($request)
    {
        $data = $request->all();
        $result = DB::table('users')
            ->join('roles', 'roles.role_id', '=', 'users.role_id')
            ->where(['username'=> $data['username'],'status'=>'active' ])
            ->get();
        $result = $result->toArray();
        if(count($result)>0){
            $hashedPassword = $result[0]->password;
            if (Hash::check($data['password'], $hashedPassword)) {
                $configFile =  "acl.config.json";
                if(file_exists(getcwd() . DIRECTORY_SEPARATOR . $configFile))
                    $config = json_decode(File::get( getcwd() . DIRECTORY_SEPARATOR . $configFile),true);
                session(['username' => $result[0]->username]);
                session(['name' => $result[0]->name]);
                session(['email' => $result[0]->email]);
                session(['phone' => $result[0]->phone]);
                session(['userId' => $result[0]->user_id]);
                session(['roleType' => 'user']);
                session(['roleId' => $result[0]->role_id]);
                session(['role' => $config[$result[0]->role_code]]);
                session(['login' => true]);
                return 1;
            }
        }
        else
        {
            return 0;
        }
    }

    public function updatePassword($request){
        $data = $request->all();
        if ($request->input('password')!=null && trim($request->input('password')) != '') {
            $id = DB::table('users')
                    ->where('user_id', session('userId'))
                    ->update(
                        ['password' => Hash::make($data['password'])]
                    );
            // DB::table('user')->insert($data);
        }
    }

}
