<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Cookie;
class RegisterController extends Controller
{
     public function register()
    {
    	return view('index.register.register');
    }
	//执行注册
	public function create()
	{
		$data=request()->all();
		$telya=Cookie::get('tely');
		if($data['yan']!=$telya){
			return ['code'=>2,'content'=>'验证码错误'];
		}
		$data['u_pwd']=md5($data['u_pwd']);
		$data['create_time']=time();
		$res=DB::table('register')->insert($data);
		if($res){
			return ['code'=>1,'content'=>'注册成功'];
		}else{
			return ['code'=>2,'content'=>'注册失败'];
		}
	}

    //发送验证码
    public function telyan()
    {
    	$u_email=request()->u_email;
    	$text=rand(1000,9999);
    	if(substr_count($u_email,'@')){
    		// dd(88888888);
    		$this->send($u_email,$text);
    		return ['content'=>'验证码发送至邮箱'];
    	}else{
    		// dd(99999);
    		$this->tely($u_email,$text);
    		return ['content'=>'验证码发送至手机'];
    	}
    }
    //手机发送验证码
    public function tely($u_email,$text)
    {

    	$host = "http://dingxin.market.alicloudapi.com";
	    $path = "/dx/sendSms";
	    $method = "POST";
	    $appcode = "234f4f1bcaa2485fb9aca4828d135eea";
	    $headers = array();
	    array_push($headers, "Authorization:APPCODE " . $appcode);
	    $querys = "mobile=$u_email&param=code%3A$text&tpl_id=TP1711063";
	    $bodys = "";
	    $url = $host . $path . "?" . $querys;

	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($curl, CURLOPT_FAILONERROR, false);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_HEADER, false);
	    if (1 == strpos("$".$host, "https://"))
	    {
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	    }
	    var_dump(curl_exec($curl));
	    cookie::queue('tely',"$text",3);
	}

	//验证唯一性
	public function checkName()
	{
		$u_email=request()->input();
		$res=DB::table('register')->where('u_email',$u_email)->count();
		if($res){
			return ['code'=>2,'content'=>'账号已用'];
		}
	}


	//发送邮件
	public function send($u_email,$text){
		//$message是\Mail的实例化 use($email)引用$email
        \Mail::raw($text,function($message)use($u_email){
        //设置主题
            $message->subject("欢迎注册知曰珠宝");
        //设置接收方
            $message->to($u_email);
        });
        cookie::queue('tely',"$text",3);
	}
}
