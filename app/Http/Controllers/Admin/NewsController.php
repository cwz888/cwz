<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;
class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query=request()->all();
        $c_name=$query['c_name']??'';
        $n_title=$query['n_title']??'';
        $page=$query['page']??1;
        // Redis::del('news_'.$c_name.'_'.$n_title.'_'.$page);exit;
        $res=Redis::get('news_'.$c_name.'_'.$n_title.'_'.$page);
        if(!$res){
            echo 111;
            $where=[];
            $where=[
                ['c_name','like',"%$c_name%"],
            ];
            if($n_title??''){
                $where['n_title']=$query['n_title'];
            }
            $res=$users = DB::table('cates')
            ->join('news', 'cates.c_id', '=', 'news.c_id')
            ->where($where)
            ->orderby('n_time','asc')
            ->paginate(2);
            $res=serialize($res);
            // dd($res);exit;
            Redis::set('news_'.$c_name.'_'.$n_title.'_'.$page,$res);
        }
        $res=unserialize($res);
        return view('admin.news.index',['res'=>$res,'query'=>$query]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=DB::table('cates')->get();
        
        return view('admin.news.create',['data'=>$data]);
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
        $validator=validator::make($data,[
             'n_title' => 'required|unique:news|max:10',
             'brand_logo' => 'required',
             'brand_desc' => 'required',
             'brand_url' => 'required',
        ],[

        ]);
        if($request->hasFile('n_img')){
            $imgurl=$this->upload($request,'n_img');
            if($imgurl['code']){
                $data['n_img']=$imgurl['imgurl'];
            }
        }else{
                echo '文件上传错误';
                return redirect('news/add');
        }
        $data['n_time']=time();
        $res=DB::table('news')->insert($data);
        if($res){
            return redirect('/news/list');
        }
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
    public function edit($n_id)
    {
         $c=DB::table('cates')->get();
         $res=$users = DB::table('cates')
        ->join('news', 'cates.c_id', '=', 'news.c_id')
        ->where('n_id',$n_id)
        ->first();
        return view('admin.news.edit',['res'=>$res,'c'=>$c]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data=$request->except('_token');
        if($request->hasFile('n_img')){
            $imgurl=$this->upload($request,'n_img');
            if($imgurl['code']){
                $data['n_img']=$imgurl['imgurl'];
            }
        }
        $res=DB::table('news')->where('n_id',$data['n_id'])->update($data);
        if($res){
            return redirect('news/list');
        }else{
            return redirect('news/edit');
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
        $n_id=request()->post();
        $res=DB::table('news')->where('n_id',$n_id)->delete();
        if($res){
            return ['code'=>1,'content'=>'删除成功'];
        }
    }
}
