@extends('layouts/shop')
@section('contents')
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>产品详情</h1>
      </div>
<meta name="csrf-token" content="{{ csrf_token() }}">
     </header>
     <div id="sliderA" class="slider">

      <img src="{{config('app.img_url')}}{{$data->goods_img}}" />
      
     </div><!--sliderA/-->
     <table class="jia-len">
      <tr>
       <th><strong class="orange" id="goods_price">{{$data->goods_price}}</strong></th>
       <td>
            <div class="des_join">
                <div class="j_nums">
                    <input type="hidden" id="goods_num" value="{{$data->goods_num}}">
                    <input type="button" id="add" value="-" class="n_btn_1" />
                    <input type="text" value="1" id="buy_number" class="n_ipt" />
                    <input type="button" id="less" value="+" class="n_btn_2" />   
                </div>
                <input type="hidden" id="goods_id" value="{{$data->goods_id}}">

       </td>
      </tr>
      <tr>
       <td>
        <strong>{{$data->goods_name}}</strong>
        <p class="hui">{{$data->goods_desc}}</p>
       </td>
       <td align="right">
        <a href="javascript:;" class="shoucang"><span class="glyphicon glyphicon-star-empty"></span></a>
       </td>
      </tr>
     </table>
     <div class="height2"></div>
     <div class="height2"></div>
     <div class="zhaieq">
      <a href="javascript:;" class="zhaiCur">商品简介</a>
      <a href="javascript:;">商品参数</a>
      <a href="javascript:;" style="background:none;">订购列表</a>
      <div class="clearfix"></div>
     </div><!--zhaieq/-->
     <div class="proinfoList">
      <img src="{{config('app.img_url')}}{{$data->goods_img}}" width="636" height="822" />
     </div><!--proinfoList/-->
        <table>
          <tr>
            <td>用户名:</td>
            <td>星级:</td>
            <td>账号:</td>
            <td>内容:</td>
            <td>时间</td>
          </tr>
          @foreach($comment as $k=>$v)
          <tr>
            <td>{{$v->c_name}}</td>
            <td>{{$v->c_rad}}星</td>
            <td>{{$v->c_email}}</td>
            <td>{{$v->c_desc}}</td>
            <td>{{date('Y-m-d',$v->create_time)}}</td>
          </tr>
          @endforeach
        </table>
       <table border="1" background-color="pink">
         <tr>
           <td>用户名:</td>
           <td><input type="text" name="c_name" id="c_name"></td>
         </tr>
         <tr>
           <td>E-email:</td>
           <td><input type="text" name="c_email" id="c_email"></td>
         </tr>
         <tr>
           <td>评价等级:</td>
           <td>
             <input type="radio" name="c_rad" id="" class="nbn" value="1">1级
             <input type="radio" name="c_rad" id="" class="nbn" value="2">2级
             <input type="radio" name="c_rad" id="" class="nbn" value="3">3级
             <input type="radio" name="c_rad" id="" class="nbn" value="4">4级
             <input type="radio" name="c_rad" id="" class="nbn" value="5">5级
           </td>
         </tr>
         <tr>
           <td>评论内容:</td>
           <td><textarea name="c_desc" id="c_desc" cols="30" rows="3"></textarea></td>
         </tr>
         <tr goods_id="{{$data->goods_id}}">
           <td colspan="2"><input type="button" value="提交评论" id="subp"></td>
         </tr>
       </table>
     
     <div class="proinfoList">
      暂无信息....
     </div><!--proinfoList/-->
     <div class="proinfoList">
      暂无信息......
     </div><!--proinfoList/-->
     <table class="jrgwc">
      <tr>
       <th>
        <a href="index.html"><span class="glyphicon glyphicon-home"></span></a>
       </th>
       <td><a href="javascript:;" id="addCart">加入购物车</a></td>
      </tr>
     </table>
     <script>

        //点击+号
        $('#less').click(function(){
              var goods_num =$('#goods_num').val();
              //console.log(goods_num);
              var buy_number=parseInt($('#buy_number').val());
              //console.log(buy_number);
                  if(buy_number>=goods_num){
                      $('#buy_number').val(goods_num);
                      //+号失效
                      $(this).prop('disabled',true);
                  }else{
                       buy_number=buy_number+1;
                      $('#buy_number').val(buy_number);
                      //-号生效
                      $(this).next('input').prop('disabled',false);
                  }   
        });


        //点击-号
        $('#add').click(function(){
                var buy_number=parseInt($('#buy_number').val());
                  if(buy_number<=1){
                      $('#buy_number').val(1);
                      //-号失效
                      $(this).prop('disabled',true);
                  }else{
                       buy_number=buy_number-1;
                      $('#buy_number').val(buy_number);
                      //+号生效
                      $(this).prev('input').prop('disabled',false);
                  }   
        });


        //失去焦点
        $('.n_ipt').blur(function(){
            var _this=$(this);
            var buy_number=_this.val();

            var goods_num=$('#goods_num').val();
            var reg=/^\d+$/;
            if(buy_number==''){
                _this.val(1);
            }
            if(buy_number<=1){
                _this.val(1);
            }
            if(!reg.test(buy_number)){
                _this.val(1);
            }
            if(buy_number>=goods_num){
                _this.val(goods_num);
            }else{
                buy_number=parseInt(buy_number);
                _this.val(buy_number);
            }
        });
        

        //点击加入购物车
        $('#addCart').click(function(){
            //获取商品id
            var goods_id=$('#goods_id').val();
            //获取购买数量
            var buy_number=$('#buy_number').val();
            var goods_price=$('#goods_price').text();
            $.ajaxSetup({
               headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
            });
           $.post(
                "{{url('/cart/add')}}",
                {goods_id:goods_id,buy_number:buy_number,goods_price:goods_price},
                function(res){ 
                    alert(res.content);                 
                    if(res.code==1){
                      location.href="{{url('/cart/list')}}";
                    }else{
                      history.go(0);
                    }           
                },
                'json'
            );
        });

        //点击提交评论
        $('#subp').click(function(){
          var _this=$(this);
          var c_name=$('#c_name').val();
          var c_email=$('#c_email').val();
          var c_rad=$('.nbn:checked').val();
          var c_desc=$('#c_desc').val();
          var goods_id=_this.parents('tr').attr('goods_id');
          $.ajaxSetup({
             headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
            });
          $.post(
              '/index/comment',
              {c_name:c_name,c_email:c_email,c_rad:c_rad,c_desc:c_desc,goods_id:goods_id},
              function(res){
                if(res.code==1){
                  history.go(0);
                }
              },
              'json'
            );
        });
  </script>
        @include('public/footer')
@endsection