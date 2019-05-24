<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>支付方式</title>
    <script src="/index/js/jquery.min.js"></script>
</head>
<body>
    <p>订单号:&nbsp;&nbsp;&nbsp;<i id="order_no" style="color:blue">{{$order->order_no}}</i></p>
    <p>订单金额:&nbsp;&nbsp;&nbsp;{{$order->order_amount}}&nbsp;&nbsp;<b style="color:red">RMB</b></p>
    <p>订单生成时间:&nbsp;&nbsp;&nbsp;<i style="color:blue">{{date('Y-m-d H:i:s',$order->create_time)}}</i></p>
    <input type="button" id="pcalipay" value="电脑端支付">
    <input type="button" id="scalipay" value="手机端支付">
</body>
</html>
<script>
    //点击电脑
    $('#pcalipay').click(function(){
        var order_no=$('#order_no').text();
        location.href="{{url('/pay/pcalipay')}}/"+order_no;
    });

    //点击手机
    $('#scalipay').click(function(){
        alert('手机');
    });
</script>