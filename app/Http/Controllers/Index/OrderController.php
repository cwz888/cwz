<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class OrderController extends Controller
{
    public function create()
    {
    	$data=request()->post();
    	$data['create_time']=time();
    	$data['u_id']=session('u_id');
    	$data['order_no']=rand(111111111,999999999);
    	$res=DB::table('order')->insert($data);
    	if($res){
    		return ['code'=>1,'content'=>'订单提交成功'];
    	}else{
    		return ['code'=>2,'content'=>'订单提交失败'];
    	}
    }
}
