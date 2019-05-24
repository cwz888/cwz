@extends('layouts.shop')
@section('title','珠宝大盗')
@section('contents')
    <div class="maincont">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>会员登录</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/index/images/head.jpg" />
     </div><!--head-top/-->
     <form action="{{url('/login/do_add')}}" method="post" class="reg-login">
     @csrf
      <h3>还没有三级分销账号？点此<a class="orange" href="/register/register">注册</a></h3>
      <div class="lrBox">
       <div class="lrList"><input type="text" name="u_email" id="u_email" placeholder="输入手机号码或者邮箱号" /></div>
       <div class="lrList"><input type="password" name="u_pwd" id="u_pwd" placeholder="输入密码" /></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="submit" id="sub" value="立即登录" />
      </div>
     </form>
     <script type="text/javascript">
         $('#sub').click(function(){
          var u_email=$('#u_email').val();
          var u_pwd=$('#u_pwd').val();
          if(u_email==''){
            alert('账号不可为空');
            return false;
          }
          if(u_pwd==''){
            alert('密码不可为空');
            return false;
          }
         });
     </script>
     @endsection