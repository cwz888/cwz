@extends('layouts.shop')
@section('title')
@section('contents')
    <div class="maincont">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>会员注册</h1>
      </div>
      <meta name="csrf-token" content="{{ csrf_token() }}">
     </header>
     <div class="head-top">
      <img src="/index/images/head.jpg" />
     </div><!--head-top/-->
     <form action="/login/login" method="get" class="reg-login">
      <h3>已经有账号了？点此<a class="orange" href="/login/login">登陆</a></h3>
      <div class="lrBox">
       <div class="lrList"><input type="text" name="u_email" id="u_email" placeholder="输入手机号码或者邮箱号" /></div>
       <div class="lrList2"><input type="text" name="u_yan" id="yan" placeholder="输入验证码" /> <a id="u_yan"><h3>获取验证码</h3></a></div>
       <div class="lrList"><input type="password" name="u_pwd" id="u_pwd" placeholder="设置新密码（6-18位数字或字母）" /></div>
       <div class="lrList"><input type="password" name="u_pswd" id="u_pswd" placeholder="再次输入密码" /></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="button" id="sub" value="立即注册" />
      </div>
     </form><!--reg-login/-->
     <script type="text/javascript">
       $.ajaxSetup({
           headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
        });
            $('#u_email').blur(function(){
              var _this=$(this);
              var u_email=_this.val();
              if(u_email==''){
                alert('账号不可为空');
                return false;
              }
              var reg=/^(1[3|4|5|6|7|8][0-9])\d{8}$/;
              var regs=/^\w{5,11}@qq.com$/;
              if(!reg.test(u_email) && !regs.test(u_email)){
                  alert('请填写正确的邮箱和手机号');
                  $('#u_email').val('');
                  return false;
              }
              $.ajaxSetup({
                 headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
              });
              var flag='';
              $.ajax({
                url:"{{url('/register/checkName')}}",
                type:'POST',
                data:{u_email:u_email},
                async:false,
                success:function(res){
                  alert(res.content);
                  if(res.code==2){
                    flag="账号已被使用";
                  }
                },
                dataType:'json'
              });
              return flag;
            });
            $('#yan').blur(function(){
              var _this=$(this);
              var yan=_this.val();
              if(yan==''){
                alert('验证码不可为空');
                return false;
              }
            });
            $('#u_pwd').blur(function(){
              var _this=$(this);
              var u_pwd=_this.val();
              if(u_pwd==''){
                alert('密码不可为空');
                return false;
              }
              var reg=/^[A-Z0-9a-z]{6,18}$/;
              if(!reg.test(u_pwd)){
                alert('密码由6~18位数字字母组成');
                $('#u_pwd').val('');
                return false;
              }
            });
            $('#u_pswd').blur(function(){
              var _this=$(this);
              var u_pswd=_this.val();
              if(u_pswd==''){
                alert('确认密码不可为空');
                return false;
              }
              var u_pwd=$('#u_pwd').val();
              if(u_pswd!=u_pwd){
                alert('两次密码请保持一致');
              }
            });


            //发送验证码
            $('#u_yan').click(function(){
              var u_email=$('#u_email').val();
              $.post(
                  "{{url('/register/add')}}",
                  {u_email:u_email},
                  function(res){
                    alert(res.content);
                  },
                  'json'
                );
            });

            //点击添加
            $('#sub').click(function(){
              var u_email=$('#u_email').val();
              if(u_email==''){
                alert('账号不可为空');
                return false;
              }
              var yan=$('#yan').val();
              if(yan==''){
                alert('验证码不可为空');
                return false;
              }
              var u_pwd=$('#u_pwd').val();
              if(u_pwd==''){
                alert('密码不可为空');
                return false;
              }
             var u_pswd=$('#u_pswd').val();
              if(u_pswd==''){
                alert('密码不可为空');
                return false;
              }
              if(u_pwd!=u_pswd){
                alert('两次密码请保持一致');
                return false;
              }
              $.post(
                  '/register/do_add',
                  {u_email:u_email,yan:yan,u_pwd:u_pwd},
                  function(res){
                    alert(res.content);
                    if(res.code==1){
                      location.href="/login/login";
                    }else{
                      history.go(0);
                    }
                  },
                  'json'
                );
            });
     </script>
     @endsection
    