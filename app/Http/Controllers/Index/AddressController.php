<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class AddressController extends Controller
{
   //收货地址列表
    public function index()
    {
        $res=DB::table('area')->get();
        //获取省份信息
        $data=$this->sanadd($res);
        return view('index.address.list',['data'=>$data]);
    }


    //获取省份信息
    public function sanadd($data,$pid=0){
        foreach($data as $k=>$v){
            static $arr=[];
            if($v->pid==$pid){
                $arr[]=$v;
            }
        }
        return $arr;
    }


    //获取市区信息
    public function city()
    {
        $id=request()->post();
        $city=DB::table('area')->where('pid',$id)->get();
        return $city;
    }

    //添加入库
    public function create()
    {
        $data=request()->post();
        $u_id=session('u_id');
        $data['u_id']=$u_id;
        if(!empty($data)){
            if($data['a_static']==1){
                 DB::table('address')->where(['u_id'=>$u_id])->update(['a_static'=>0]);
                 $data['create_time']=time();
                 $res=DB::table('address')->insert($data);
                 if($res){
                    return ['code'=>1,'content'=>'保存地址成功'];
                 }else{
                    return ['code'=>2,'content'=>'保存地址失败'];
                 }
            }else{
                $data['u_id']=session('u_id');
                $data['create_time']=time();
                $res=DB::table('address')->insert($data);
                if($res){
                    return ['code'=>1,'content'=>'保存地址成功'];
                }else{
                    return ['code'=>2,'content'=>'保存地址失败'];
                }
            }
        }else{
            return ['code'=>2,'content'=>'请填写完整信息'];
        }
    } 
}
