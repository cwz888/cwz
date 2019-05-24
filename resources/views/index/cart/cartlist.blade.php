@extends('layouts.shop')
@section('title','珠宝大盗')
@section('contents')
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>购物车</h1>
      </div>
      <meta name="csrf-token" content="{{ csrf_token() }}">
     </header>
     <div class="head-top">
      <img src="/index/images/head.jpg" />
     </div><!--head-top/-->
     <table class="shoucangtab">
      <tr>
       <td width="75%"><span class="hui">购物车共有：<strong class="orange">{{$num}}</strong>件商品</span></td>
       <td width="25%" align="center" style="background:#fff url(/index/images/xian.jpg) left center no-repeat;">
        <span class="glyphicon glyphicon-shopping-cart" style="font-size:2rem;color:#666;"></span>
       </td>
      </tr>
     </table>
    
     <div class="dingdanlist">
        <table>
         <tr>
          <td width="100%" colspan="4"><a href="javascript:;"><input type="checkbox" id="checkbox" name="4" /> 全选</a></td>
         </tr>
          @foreach($data as $v)
         <tr>
          <td width="4%"><input type="checkbox" class="checkbox" name="1" value="{{$v->goods_id}}"/></td>
          <td class="dingimg" width="15%"><img src="{{config('app.img_url')}}{{$v->goods_img}}" /></td>
          <td width="50%">
           <h3>{{$v->goods_name}}</h3>
           <time>下单时间：{{date('Y-m-d H:i:s',$v->create_time)}}</time>
          </td>
          <td align="right">
           <div class="des_join">
                  <div class="j_nums">
                      <input type="hidden" class="goods_num" value="{{$v->goods_num}}">
                      <input type="button" id="add" value="-" class="n_btn_1" />
                      <input type="text" value="{{$v->buy_num}}" class="buy_number" class="n_ipt" />
                      <input type="button" id="less" value="+" class="n_btn_2" />
                      <input type="hidden" class="goods_id" value="{{$v->goods_id}}">   
                  </div>
          </td>
         </tr>
         <tr>
          <th colspan="4"><strong class="orange">{{$v->goods_price}}</strong></th>
         </tr>
          @endforeach
        </table>
     </div><!--dingdanlist/-->
    <div class="height1"></div>
     <div class="gwcpiao">
       <table>
        <tr>
         <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
         <td width="50%">总计：<strong class="oranges">0</strong></td>
         <td width="40%"><a href="javascript:;" class="jiesuan">去结算</a></td>
        </tr>
       </table>
    </div><!--gwcpiao/-->
    <script>
        //点击-
        $('.n_btn_1').click(function(){
          var _this=$(this);
          var goods_num=_this.siblings('.goods_num').val();
          var buy_number=parseInt(_this.siblings('.buy_number').val());
          var goods_id=_this.siblings('.goods_id').val();
          var goods_price=_this.parents('tr').next('tr').children('th').children('.orange').text();
          var orange=(buy_number-1)*goods_price;
          $('.oranges').text(orange);
          _this.parents('tr').children('td').children('.checkbox').prop('checked',true);
          // console.log(buy_number);
          if(buy_number<=1){
            _this.siblings('.buy_number').val(1);
          }else{
            _this.siblings('.buy_number').val(buy_number-1);
          }
          $.ajaxSetup({
             headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
            })
          $.post(
              "{{url('/cart/num')}}",
              {goods_id:goods_id,buy_num:buy_number},
              function(res){

              },
            );
        });

        //点击+
        $('.n_btn_2').click(function(){
          var _this=$(this);
          var goods_num=_this.siblings('.goods_num').val();
          var buy_number=parseInt(_this.siblings('.buy_number').val());
          _this.parents('tr').children('td').children('.checkbox').prop('checked',true);
          var goods_id=_this.siblings('.goods_id').val();
          var goods_price=_this.parents('tr').next('tr').children('th').children('.orange').text();
          var orange=(buy_number+1)*goods_price;
          $('.oranges').text(orange);
          if(buy_number>=goods_num){
            _this.siblings('.buy_number').val(goods_num);
          }else{
            _this.siblings('.buy_number').val(buy_number+1);
          }
          $.ajaxSetup({
             headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
            })
          $.post(
              "{{url('/cart/nums')}}",
              {goods_id:goods_id,buy_num:buy_number},
              function(res){

              },
            );
        });

        //点击全选 全不选
        $('#checkbox').click(function(){
          var _this=$(this);
          if(_this.prop('checked')==true){
            $(':checkbox').prop('checked',true);
            //获取多选框
            var checkbox=$('.checkbox:checked');
            //获取商品id
            var goods_id='';
            $(checkbox).each(function(index){
                goods_id+=$(this).val()+',';
            });
            goods_id=goods_id.substr(0,goods_id.length-1);
            $.ajaxSetup({
               headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
              })
             $.post(
                "{{url('/cart/price')}}",
                {goods_id:goods_id},
                function(res){
                  $('.oranges').text(res);
                },
              );
          }else{
            $(':checkbox').prop('checked',false);
          }
        });

        //获取总价
        $('.checkbox').click(function(){
          //获取多选框
          var checkbox=$('.checkbox:checked');
          //获取商品id
          var goods_id='';
          $(checkbox).each(function(index){
              goods_id+=$(this).val()+',';
          });
          goods_id=goods_id.substr(0,goods_id.length-1);
          $.ajaxSetup({
             headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
            })
           $.post(
              "{{url('/cart/price')}}",
              {goods_id:goods_id},
              function(res){
                $('.oranges').text(res);
              },
            );
        });

        //提交订单
        $('.jiesuan').click(function(){
           //获取多选框
            var checkbox=$('.checkbox:checked');
            //获取商品id
            var goods_id='';
            $(checkbox).each(function(index){
                goods_id+=$(this).val()+',';
            });
            goods_id=goods_id.substr(0,goods_id.length-1);
            $.ajaxSetup({
               headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
              })
             $.post(
                "{{url('/cart/dingd')}}",
                {goods_id:goods_id},
                function(res){
                  if(res.code==1){
                    alert(res.content);
                    history.go(0);
                  }else{
                    location.href='/cart/pay/'+res.content;
                  }
                },
              );
        });
    </script>
@endsection