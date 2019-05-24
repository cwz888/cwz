@extends('layouts/shop')
@section('title')
@section('contents')
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>收货地址</h1>
      </div>
      <meta name="csrf-token" content="{{ csrf_token() }}">
     </header>
     <div class="head-top">
      <img src="/index/images/head.jpg" />
     </div><!--head-top/-->
     <form action="login.html" method="get" class="reg-login">

      <div class="lrBox">
       <div class="lrList"><input type="text" name="a_name" placeholder="收货人" id="a_name"/></div>
       <div class="lrList">
        <select class="area" id="province">
         <option>省份/直辖市</option>
        @foreach($data as $v)
         <option value="{{$v->id}}">{{$v->name}}</option>
        @endforeach
        </select>
       </div>
       <div class="lrList">
        <select class="area" id="city">
         <option>区县</option>
        </select>
       </div>
       <div class="lrList">
        <select class="area" id="area">
         <option>详细地址</option>
        </select>
       </div>
       <div class="lrList"><input type="text" name="a_address" placeholder="具体地址" id="a_address"/></div>
       <div class="lrList"><input type="text" name="a_tel" placeholder="手机" id="a_tel"/></div>
       <div class="lrList2"><input type="hidden" name="a_static" placeholder="设为默认地址" id="a_static"/><input type="button" class="eq" value="设为默认"></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="button" class="sub" value="保存">
      </div>
     </form><!--reg-login/-->
     
     <div class="height1"></div>
     <script>
        //三级循环
        $('.area').change(function(){
          var _this=$(this);
          var id=_this.val();
          $.ajaxSetup({
             headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
          });
          $.post(
              "/address/shi",
              {id:id},
              function(res){
                var _option="<option>--请选择--</option>";
                  for(var i=0;i<res.length;i++){
                    _option+="<option value='"+res[i]['id']+"'>"+res[i]['name']+"</option>";
                  }
                 _this.parent('div').next('div').children('select').html(_option);
              },
              'json'
            );
        });

        //设置默认
        $('.eq').click(function(){
          var _this=$(this);
          _this.parents('div .lrList2').addClass('border:1px solid red');
          _this.prev('input').val(1);
        });

        //点击保存
        $('.sub').click(function(){
          var data={};
          data.a_name=$('#a_name').val();
          data.province=$('#province').val();
          data.city=$('#city').val();
          data.area=$('#area').val();
          data.a_address=$('#a_address').val();
          data.a_tel=$('#a_tel').val();
          data.a_static=$('#a_static').val();
           $.ajaxSetup({
             headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
          });
           $.post(
              "/address/add",
              data,
              function(res){
                alert(res.content);
                if(res.code==1){
                  history.go(-1);
                }
              },
              'json'
            );
        });
     </script>
     @include('public/footer')
@endsection