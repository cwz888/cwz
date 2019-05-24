<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Brand;//使用模型时需要导入模型的
use Illuminate\Support\Facades\Auth;//手动认证用户需要导入的
use Illuminate\Support\Facades\Cookie;
use App\Http\Requests\StoreBrandPost;
use Illuminate\Validation\Rule;//用来修改时验证用户唯一性
class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query=request()->all();
        $page=$query['page']??1;
        $brand_name=$query['brand_name']??'';
        $brand_url=$query['brand_url']??'';
        $data=cache('list_'.$page.'_'.$brand_name.'_'.$brand_url);
        if(!$data){
            $where=[];
            if($query['brand_name']??''){
                $where=[
                    ['brand_name','like',"%$brand_name%"]
                ];
            }
            if($query['brand_url']??''){
                $where['brand_url']=$brand_url;
            }
            $pageSize=config('app.pageSize');
            // DB::connection()->enableQueryLog();
            // $logs = DB::getQueryLog();
            // dd($logs);
            $data=brand::where($where)->orderby('brand_id','desc')->paginate($pageSize);
            cache(['list_'.$page.'_'.$brand_name.'_'.$brand_url=>$data],5);
        }
        if(request()->ajax()){
            return view('brand.ajax',['data'=>$data,'query'=>$query]); 
        }else{
            return view('brand.index',['data'=>$data,'query'=>$query]);
        }
        
    }

    //发送邮件
    // public function send()
    // {
    //     $email=request()->email;
    //     $this->email($email);
    // }
    // public function email($email)
    // {
    //     $res=\Mail::send('brand/email',['name'=>$email],function($message)use($email){
    //         $message->subject('哪家快递发货健康是多少');
    //         $message->to($email);//收件人
    //     });
    //     if(empty($res)){
    //         echo "发送成功";
    //     }
    //     // \Mail::raw('我好帅!',function($message)use($email){
    //     //     $message->subject('请注意查收');
    //     //     $message->to($email);
    //     // });
    // }


    //手动用户认证
    public function logindo()
    {
        $email=request()->email;
        $password=request()->password;
        if(Auth::attempt(['name'=>$email,'password'=>$password])){
            dump(Auth::user());//打印所有user()是辅助函数
            dump(Auth::id()); //获取当前用户登录的id          
            // dump()Auth::password();
            echo "登陆成功";
        }else{                                                                                             
            echo '登录失败';
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(request $request)
    {
        $data=$request->except('_token');
        
        //第二种验证方式创建一个控制器
        //public function store(StoreBrandPost $request) 
        
        //第一种validate验证方式
        // $validatedData = $request->validate([
        //  'brand_name' => 'required|unique:brand|max:10',
        //  'brand_logo' => 'required',
        //  'brand_desc' => 'required',
        //  'brand_url' => 'required',
        //  ],[
        //     'brand_name.required'=>'品牌名称不可为空',
        //     'brand_name.max'=>'品牌名称长度为10位',
        //     'brand_name.unique'=>'品牌名称已存在',
        //     'brand_logo.required'=>'品牌logo不可为空',
        //     'brand_desc.required'=>'品牌描述不可为空',
        //     'brand_url.required'=>'品牌网址不可为空',
        //  ]);
       //第三种验证方式使用门面 手动验证
         $validator = \Validator::make($data, [
             'brand_name' => 'required|unique:brand|max:10',
             'brand_logo' => 'required',
             'brand_desc' => 'required',
             'brand_url' => 'required',
         ],[
            'brand_name.required'=>'品牌名称不可为空',
            'brand_name.max'=>'品牌名称长度为10位',
            'brand_name.unique'=>'品牌名称已存在',
            'brand_logo.required'=>'品牌logo不可为空',
            'brand_desc.required'=>'品牌描述不可为空',
            'brand_url.required'=>'品牌网址不可为空',
         ]);
         //true为有错 false为没有错
         if ($validator->fails()) {
             return redirect('brand/add')->withErrors($validator)->withInput();
         }

        //检测上传的文件是否存在
        if($request->hasFile('brand_logo')){
            $imgurl=$this->upload($request,'brand_logo');
            if($imgurl['code']){
                $data['brand_logo']=$imgurl['imgurl'];
            }
        }else{
                echo '文件上传错误';
                return redirect('brand/add');
        }

        $data['create_time']=time();
        // dd($data);
        $res=brand::insert($data);//第一种查询构造器
        // $res=brand::create($data);//第二种 要使用白名单
        // $brand=new brand;
        // $res=$brand->brand_name=$data['brand_name'];
        // $brand->brand_logo=$data['brand_logo'];
        // $brand->brand_desc=$data['brand_desc'];
        // $brand->brand_url=$data['brand_url'];
        // $brand->save();
        if($res){
             return redirect('brand/list');
        }
    }
    //文件上传
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
    public function edit($brand_id)
    {
        $data=brand::where('brand_id',$brand_id)->first();//获取条件的第一条
        // $data=brand::find($brand_id);//批量
        return view('brand.edit',['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $brand_id)
    {
        $data=$request->except('_token');
         $validator = \Validator::make($data, [
             'brand_name' => [
                 'required',
                 'max:10',
                 Rule::unique('brand')->ignore($brand_id,'brand_id'),
             ],
             'brand_desc' => 'required',
             'brand_url' => 'required',
         ],[
            'brand_name.required'=>'品牌名称不可为空',
            'brand_name.max'=>'品牌名称长度为10位',
            'brand_name.unique'=>'品牌名称已存在',
            'brand_desc.required'=>'品牌描述不可为空',
            'brand_url.required'=>'品牌网址不可为空',
         ]);
         //true为有错 false为没有错
         if ($validator->fails()) {
             return redirect('brand/edit/'.$brand_id)->withErrors($validator)->withInput();
         }

        //检测上传的文件是否存在
        if($request->hasFile('brand_logo')){
            $imgurl=$this->upload($request,'brand_logo');
            if($imgurl['code']){
                $data['brand_logo']=$imgurl['imgurl'];
            }
        }
        $res=brand::where('brand_id',$brand_id)->update($data);
        if($res){
            return redirect('/brand/list');
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
        $brand_id=request()->get('brand_id');
        $res =brand::where('brand_id',$brand_id)->delete();
        // $res =brand::destroy($brand_id);
        if($res){
            return redirect('brand/list');
        }
    }

    // //上传文件
    // public function upload(Request $request)
    // {
    //    $brand_logo=$request->input();
    //    $logo=$brand_logo['brand_logo'];
    //    $img=
    // }
}
