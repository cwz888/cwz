<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class LoginController extends Controller
{
    public function login()
    {
    	return view('index.login.login');
    }
    public function create()
    {
    	$data=request()->except('_token');
    	$u_email=$data['u_email'];
    	$u_pwd=md5($data['u_pwd']);
    	$res=DB::table('register')->where('u_email',$u_email)->first();
    	$pwd=$res->u_pwd;
    	$u_id=$res->u_id;
    	if(!$res){
    		return '哦用户不存在';
    	}else{
    		if($pwd!=$u_pwd){
    			return "密码错误";
    		}else{
    			$dat=DB::table('register')->where('u_id',$u_id)->update(['login_time'=>time()]);
    			if($dat){
    				session(['u_id'=>$u_id]);
    				return redirect('/');
    			}
    		}
    	}
    }

}
