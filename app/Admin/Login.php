<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Redirect;

class Login extends Model
{
    //
    public function validateLogin($request)
    {
        $data = $request->all();
        $result = DB::table('users')
            ->where(['username'=> $data['username'],'password'=>$data['password'],'status'=>'active' ])
            ->get();
        $result = $result->toArray();
        if(count($result)>0){
            session(['username' => $result[0]->username]);
            session(['name' => $result[0]->name]);
            session(['email' => $result[0]->email]);
            session(['phone' => $result[0]->phone]);
            session(['userId' => $result[0]->user_id]);
            session(['role' => 'user']);
            session(['login' => true]);
        }
        // dd($result);
        // dd(Session::token());
        // dd(session('username'));
        return $result;
    }

    public function updatePassword($request){
        $data = $request->all();
        if ($request->input('password')!=null && trim($request->input('password')) != '') {
            $id = DB::table('users')
                    ->where('user_id', session('userId'))
                    ->update(
                        ['password' => $data['password']]
                    );
            // DB::table('user')->insert($data);
        }
    }

}
