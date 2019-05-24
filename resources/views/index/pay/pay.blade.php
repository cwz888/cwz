@extends('layouts/shop')
@section('title')
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
     <div class="dingdanlist">
      <table>
       <tr onClick="window.location.href='/address/list'">
        <td class="dingimg" width="75%" colspan="2">新增收货地址</td>
        <td align="right"><img src="/index/images/jian-new.png" /></td>
       </tr>
       <tr>
           <td colspan="3" style="height:10px; background:#efefef;padding:0; color:green;">
           <select name="province" id="">
           @foreach($address as $k=>$v)
             <option value="{{$v->province}}">{{$v->province}}</option>
           @endforeach
           </select>
           <select name="city" id="">
           @foreach($address as $k=>$v)
             <option value="{{$v->city}}">{{$v->city}}</option>
           @endforeach
           </select>
           <select name="area" id="">
           @foreach($address as $k=>$v)
             <option value="{{$v->area}}">{{$v->area}}</option>
           @endforeach
           </select>
             @foreach($address as $k=>$v)
                {{$v->a_address}}
                <input type="hidden" value="{{$v->a_id}}">
             @endforeach
           </td>
       </tr>
       <tr>
        <td width="75%" colspan="2">支付方式</td>
        <td align="right">
            <select name="order_pay" id="order_pay">
              <option value="1">支付宝</option>
              <option value="2">微信支付</option>
              <option value="3">银行卡支付</option>
            </select>
        </td>
       </tr>
       <tr>
        <td class="dingimg" width="75%" colspan="3">商品清单</td>
       </tr>
       @foreach($data as $k=>$v)
       <tr>
        <td class="dingimg" width="15%"><img src="{{config('app.img_url')}}{{$v->goods_img}}" /></td>
        <td width="50%">
         <h3>{{$v->goods_name}}</h3>
         <time>下单时间：{{date('Y-m-d H:i',time())}}</time>
        </td>
        <td align="right"><span class="qingdan">X {{$v->buy_num}}</span></td>
       </tr>
       <tr>
        <th colspan="3"><strong class="orange">¥{{$v->goods_price}}</strong></th>
       </tr>
        @endforeach
      </table>
     </div><!--dingdanlist/-->
    </div><!--content/-->
    
    <div class="height1"></div>
    <div class="gwcpiao">
     <table>
      <tr>
       <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
       <td width="50%">总计：<strong class="oranges">{{$price}}</strong></td>
       <td width="40%"><a href="JavaScript:;" class="jiesuan">提交订单</a></td>
      </tr>
     </table>
    </div><!--gwcpiao/-->
    <script>
        $('.jiesuan').click(function(){
            var order_amount=$('.oranges').text();
            var order_pay=$('#order_pay').val();
            $.ajaxSetup({
               headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
            });
            $.post(
                "/order/add",
                {order_amount:order_amount,order_pay:order_pay},
                function(res){
                  alert(res.content);
                  if(res.code==1){
                    console.log(res.order);
                    location.href="{{url('/pay/pay')}}";
                  }
                },
                'json'
              );
        });
    </script>
    @endsection