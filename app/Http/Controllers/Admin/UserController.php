<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\StoreUserPost;
use App\Admin\User;
use Illuminate\Validation\Rule;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page=config('app.pageSize');
        $query=request()->all();
        $where=[];
        if($query['user_name']??''){
            $where=[
                ['user_name','like',"%$query[user_name]%"],
            ];
        }
        if($query['user_position']??''){
            $where=[
                ['user_position','=',$query['user_position']],
            ];
        }
        $data=user::where($where)->paginate($page);
        return view('admin.user.index',['data'=>$data,'query'=>$query]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserPost $request)
    {
        $data=$request->except('user_pswd','_token');
        $data['create_time']=time();
        $data['user_pwd']=md5($data['user_pwd']);
        $res=user::insert($data);
        if($res){
            echo json_encode(['code'=>1]);
        }else{
            echo json_encode(['code'=>2]);
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
    public function edit($user_id)
    {
        $data=user::where('user_id',$user_id)->first();
        return view('admin.user.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$user_id)
    {
        $data=$request->except('_token');
        $data['user_pwd']=md5($data['user_pwd']);
        $res=user::where('user_id',$user_id)->update($data);
        if($res){
            return redirect('user/list');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $user_id=request()->post();
        $res=user::destroy($user_id);
        if($res){
            return ['code'=>1];
        }
    }
}
