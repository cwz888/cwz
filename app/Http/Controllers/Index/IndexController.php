<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Redis;
class IndexController extends Controller
{
    public function index()
    {
      // Redis::set('name','张三');
      // print_r(Redis::get('name'));exit;
    	$data=DB::table('goods')->get();
    	$brand=DB::table('brand')->get();
    	$u_id=session('u_id');
    	if($u_id){
    		$res=DB::table('register')->where('u_id',$u_id)->first();
    		$u_name=$res->u_email;
    	}else{
    		$u_name="请登录";
    	}
    	// dd($data);
    	return view('index.index',['data'=>$data,'u_name'=>$u_name,'brand'=>$brand]);
    }
    //全部商品
   public function prolist()
   {
      $data=cache('prolist');
      // dd($data);
      if(!$data){
        echo 11;
        $data=DB::table('goods')->get();
        cache(['prolist'=>$data],12*60);
      }
   		return view('index.prolist.prolist',['data'=>$data]);
   }
   //商品详情
   public function proinfo($goods_id)
   {
        $data=cache('list'.$goods_id);
        if(!$data){
          echo 111;
          $data=DB::table('goods')->where('goods_id',$goods_id)->first();
          cache(['list'.$goods_id=>$data],1);
        }
          $comment=DB::table('comment')->where('goods_id',$goods_id)->get();
   		    return view('index.prolist.proinfo',['data'=>$data,'comment'=>$comment]);
   }

   //评论添加
   public function comment()
   {
      $data=request()->post();
      $data['create_time']=time();
      $goods_id=$data['goods_id'];
      $res=DB::table('comment')->insert($data);
      if($res){
        $comment=DB::table('comment')->where('goods_id',$goods_id)->get();
        return ['code'=>1,'content'=>'评论成功','comment'=>$comment];
      }else{
        return ['code'=>2,'content'=>'评论失败'];
      }
   }
}
