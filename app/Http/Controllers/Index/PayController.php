<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class PayController extends Controller
{
	//选择支付
    public function pay()
    {
    	$order=DB::table('order')->where('u_id',session('u_id'))->first();
    	return view('index.alipay.pay',['order'=>$order]);
    }

    //手机支付
    public function scalipay()
    {

    }

    //电脑支付
    public function pcalipay($order_no)
    {
    	$data=DB::table('order')->where('order_no',$order_no)->first();
    	$order_amount=$data->order_amount;

    	$config=config('pay');
    	require_once app_path('pay\pcalipay\pagepay\service\AlipayTradeService.php');
		require_once  app_path('pay\pcalipay\pagepay\buildermodel\AlipayTradePagePayContentBuilder.php');

	    //商户订单号，商户网站订单系统中唯一订单号，必填
	    $out_trade_no = trim($order_no);

	    //订单名称，必填
	    $subject = trim("粉红的诱惑");

	    //付款金额，必填
	    $total_amount = trim($order_amount);

	    //商品描述，可空
	    $body = trim('良家花田清溪澈鱼');

		//构造参数
		$payRequestBuilder = new \AlipayTradePagePayContentBuilder();
		$payRequestBuilder->setBody($body);
		$payRequestBuilder->setSubject($subject);
		$payRequestBuilder->setTotalAmount($total_amount);
		$payRequestBuilder->setOutTradeNo($out_trade_no);

		$aop = new \AlipayTradeService($config);

		/**
		 * pagePay 电脑网站支付请求
		 * @param $builder 业务参数，使用buildmodel中的对象生成。
		 * @param $return_url 同步跳转地址，公网可以访问
		 * @param $notify_url 异步通知地址，公网可以访问
		 * @return $response 支付宝返回的信息
	 	*/
		$response = $aop->pagePay($payRequestBuilder,$config['return_url'],$config['notify_url']);

		//输出表单
		var_dump($response);
    }


    //同步通知
    public function returnpay()
    {
    	echo 'ok';
    }
}
