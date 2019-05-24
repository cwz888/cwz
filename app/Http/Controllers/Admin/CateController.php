<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin\Cate;
use DB;
class CateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=cate::get();
        $data=$this->cateInfo($data);
        return view('admin.cate.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=cate::get();
        $data=$this->cateInfo($data);
        return view('admin.cate.create',compact('data'));
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
        // dd($arr);
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
        $data=$request->all();
        $res=cate::insert($data);
        if($res){
            return ['code'=>1,'content'=>'添加成功'];
        }else{
            return ['code'=>2,'content'=>'添加失败'];
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
