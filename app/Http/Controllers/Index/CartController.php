<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Index\Address;
class CartController extends Controller
{
	//加入购物车
    public function create()
    {
    	$data=request()->input();
    	$goods_id=$data['goods_id'];
    	$goods_price=$data['goods_price'];
    	$buy_num=$data['buy_number'];
    	$u_id=session('u_id');
    	$create_time=time();
      $where=[
        ['u_id','=',$u_id],
        ['goods_id','=',$goods_id]
      ];
    	$bob=DB::table('cart')->where($where)->first();
    	if($bob){
      		$buy_num1=$bob->buy_num+$buy_num;
      		$bobo=DB::table('cart')->where($where)->update(['buy_num'=>$buy_num1]);
      		if($bobo){
        			$goods=DB::table('goods')->where('goods_id',$goods_id)->first();
        			$goods_num=$goods->goods_num-$buy_num;
        			$bobob=DB::table('goods')->where('goods_id',$goods_id)->update(['goods_num'=>$goods_num]);
        			if($bobob){
        				return ['code'=>1,'content'=>'加入购物车成功'];
        			}else{
        				return ['code'=>2,'content'=>'加入购物车失败'];
        			}
      		}
    	}else{
    		$cartInfo=[
	    		'goods_id'=>$goods_id,
	    		'u_id'=>$u_id,
	    		'buy_num'=>$buy_num,
	    		'create_time'=>$create_time,
	    		'goods_price'=>$goods_price,
    		];
    		$res=DB::table('cart')->insert($cartInfo);
    		if($res){
	    		$goods=DB::table('goods')->where('goods_id',$goods_id)->first();
	    		$goods_num=$goods->goods_num-$buy_num;
	    		$bobo=DB::table('goods')->where('goods_id',$goods_id)->update(['goods_num'=>$goods_num]);
	    		if($bobo){
	    			return ['code'=>1,'content'=>'加入购物车成功'];
	    		}else{
	    			return ['code'=>2,'content'=>'加入购物车失败'];
	    		}
	    	}
    	}
    }

    //购物车列表
    public function index()
    {
      $u_id=session('u_id');
    	$data=DB::table('cart')
		 ->join('goods', 'cart.goods_id', '=', 'goods.goods_id')
     ->where('u_id',$u_id)
		 ->get();
    	$num=DB::table('cart')->where('u_id',$u_id)->count();
    	// dd($num);
    	return view('index.cart.cartlist',['data'=>$data,'num'=>$num]);
    }

    //点击-改变购物车表里数量
    public function buynum()
    {
    	$data=request()->input();
    	$goods_id=$data['goods_id'];
    	$buy_num=$data['buy_num']-1;
    	$u_id=session('u_id');
    	$where=[
    		['u_id','=',$u_id],
    		['goods_id','=',$goods_id]
    	];
    	DB::table('cart')->where($where)->update(['buy_num'=>$buy_num]);
    }

    //点击+改变购物车表里数量
    public function buynums()
    {
    	$data=request()->input();
    	$goods_id=$data['goods_id'];
    	$buy_num=$data['buy_num']+1;
    	$u_id=session('u_id');
    	$where=[
    		['u_id','=',$u_id],
    		['goods_id','=',$goods_id]
    	];
    	DB::table('cart')->where($where)->update(['buy_num'=>$buy_num]);
    }

    //获取总价
    public function price()
    {
    	$goods_id=request()->goods_id;
    	$goods_id=explode(',',$goods_id);
    	$u_id=session('u_id');
    	$where=[
    		['u_id','=',$u_id]
    	];
    	$data=DB::table('cart')
    	->whereIn('cart.goods_id',$goods_id)
    	->where($where)
    	->join('goods', 'cart.goods_id', '=', 'goods.goods_id')
		  ->get();
  		$price=0;
  		foreach($data as $k=>$v){
  			$price+=$v->goods_price*$v->buy_num;
  		}
  		return $price;
    }

    //确认订单
   	public function dingd()
   	{
   		 $goods_id=request()->goods_id;
   		 if(empty($goods_id)){
   		 	return ['code'=>1,'content'=>'请至少选择一件商品结算'];
   		 }else{
   		 	$goods_id=explode(',',$goods_id);
   		 	return ['code'=>2,'content'=>$goods_id];
   		 }
   	} 

   	//订单详情页
   	public function pay($goods_id)
   	{
   		$data=$this->cha($goods_id);
   		$u_id=session('u_id');
   		$where=[
   			['u_id','=',$u_id],
   			['a_static','=',1]
   		];
   		$address=Address::where($where)->get();
      if(!empty($address)){
        foreach($address as $k=>$v){
          $address[$k]['province']=DB::table('area')->where('id',$v['province'])->value('name');
          $address[$k]['city']=DB::table('area')->where('id',$v['city'])->value('name');
          $address[$k]['area']=DB::table('area')->where('id',$v['area'])->value('name');
        }
      }
   		$price=0;
  		foreach($data as $k=>$v){
  			$price+=$v->goods_price*$v->buy_num;
  		}
     		return view('index.pay.pay',['data'=>$data,'price'=>$price,'address'=>$address]);
   	}


   	//获取数据
   	public function cha($goods_id)
   	{
   		 	$goods_id=explode(',',$goods_id);
   		 	$u_id=session('u_id');
   		 	$where=[
   		 		['u_id','=',$u_id]
   		 	];
   		 	$data=DB::table('cart')
   		 	->whereIn('cart.goods_id',$goods_id)
   		 	->where($where)
   		 	->join('goods','cart.goods_id','=','goods.goods_id')
   		 	->get();
   		 	return $data;
   	}
}
