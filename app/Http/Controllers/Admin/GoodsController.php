<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Admin\Cate;
class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=cate::get();
        $data1=DB::table('brand')->get();
        $res=$this->cateInfo($data);
        return view('admin.goods.create',['res'=>$res,'data1'=>$data1]);
    }
    public function cateInfo($data,$c_pid=0,$c_lev=1)
    {
        static $arr=[];
        foreach($data as $k=>$v){
            if($v['c_pid']==$c_pid){
                $v['c_lev']=$c_lev;
                $arr[]=$v;
                $this->cateInfo($data,$v['c_id'],$c_lev+1);
            }
        }
        return $arr;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->except('_token');
        if($request->hasFile('goods_img')){
            $imgurl=$this->upload($request,'goods_img');
            if($imgurl['code']){
                $data['goods_img']=$imgurl['imgurl'];
            }
        }
        $data['create_time']=time();
        DB::table('goods')->insert($data);
    }
     public function upload(Request $request,$file)
    {
        //检测文件上传是否有错误
        if($request->file($file)->isValid()){
            //获取文件上传信息
            $photo=$request->file($file);
            //将路径改为设定的路径 第一个参数为文件名 第二个参数为文件名字
            $imgurl = $photo->store(date('Ymd'));

            return ['code'=>1,'imgurl'=>$imgurl];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
