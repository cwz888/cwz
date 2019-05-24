<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	session(['user_id'=>88]);
    return view('welcome',['name'=>'知曰']);
});
// 发送邮件
// Route::get('/form',function(){
// 	return "<form action='send' method='post'>".csrf_field()."<input type='text' name='email'><button>发送</button></form>";
// });
// 手动用户登录认证
// Route::get('/form',function(){
// 	return "<form action='logindo' method='post'>".csrf_field()."<input type='text' name='email'><input type='password' name='password'><button>登录</button></form>";
// });
// Route::post('logindo',"BrandController@logindo");

Route::prefix('/brand')->middleware('checklogin')->group(function(){
	Route::get('add','BrandController@create');
	Route::post('add_do','BrandController@store');
	Route::get('list','BrandController@index');
	Route::get('del','BrandController@destroy');
	Route::get('edit/{brand_id}','BrandController@edit');
	Route::post('update/{brand_id}','BrandController@update');
	Route::get('upload','BrandController@upload');
});
Route::prefix('/user')->middleware('checklogin')->group(function(){
	Route::get('add','Admin\UserController@create');
	Route::post('do_add','Admin\UserController@store');
	Route::get('list','Admin\UserController@index');
	Route::post('del','Admin\UserController@destroy');
	Route::get('edit/{user_id}','Admin\UserController@edit');
	Route::post('update/{user_id}','Admin\UserController@update');
});
Route::prefix('/news')->middleware('checklogin')->group(function(){
	Route::get('add','Admin\NewsController@create');
	Route::post('do_add','Admin\NewsController@store');
	Route::get('list','Admin\NewsController@index');
	Route::post('del','Admin\NewsController@destroy');
	Route::get('edit/{n_id}','Admin\NewsController@edit');
	Route::post('update','Admin\NewsController@update');
});
Route::prefix('/cate')->middleware('checklogin')->group(function(){
	Route::get('add','Index\LoginController@create');
	Route::post('do_add','Index\LoginController@store');
	Route::get('list','Index\LoginController@index');
	Route::post('del','Index\LoginController@destroy');
	Route::get('edit/{n_id}','Index\LoginController@edit');
	Route::post('update','Index\LoginController@update');
});
Route::prefix('/goods')->middleware('checklogin')->group(function(){
	Route::get('add','Admin\GoodsController@create');
	Route::post('do_add','Admin\GoodsController@store');
	Route::get('list','Admin\GoodsController@index');
	Route::post('del','Admin\GoodsController@destroy');
	Route::get('edit/{n_id}','Admin\GoodsController@edit');
	Route::post('update','Admin\GoodsController@update');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// Route::get('/','Index\IndexController@index');

// //登录
// Route::prefix('/login')->group(function(){
// 	Route::get('login','Index\LoginController@login');
// 	Route::post('do_add','Index\LoginController@create');
// });
// //注册
// Route::prefix('/register')->group(function(){
// 	Route::get('register','Index\RegisterController@register');
// 	Route::post('add','Index\RegisterController@telyan');
// 	Route::post('do_add','Index\RegisterController@create');
// 	Route::post('checkName','Index\RegisterController@checkName');
// });
// //商品展示
// Route::prefix('/index')->group(function(){
// 	Route::get('brand/{brand_id}','Index\IndexController@brand');
// 	Route::get('prolist','Index\IndexController@prolist');
// 	Route::get('proinfo/{goods_id}','Index\IndexController@proinfo');
// 	Route::post('comment','Index\IndexController@comment');//评论添加
// });
// //购物车
// Route::prefix('/cart')->group(function(){
// 	Route::post('add','Index\CartController@create');
// 	Route::get('list','Index\CartController@index');
// 	Route::post('num','Index\CartController@buynum');//-
// 	Route::post('nums','Index\CartController@buynums');//+
// 	Route::post('price','Index\CartController@price');//总价
// 	Route::post('dingd','Index\CartController@dingd');//确认订单
// 	Route::get('pay/{goods_id}','Index\CartController@pay');//订单详情表
// });
// //收货地址
// Route::prefix('/address')->group(function(){
// 	Route::get('list','Index\AddressController@index');
// 	Route::post('shi','Index\AddressController@city');
// 	Route::post('add','Index\AddressController@create');
// });
// //订单
// Route::prefix('/order')->group(function(){
// 	Route::post('add','Index\OrderController@create');
// });
// //手机支付宝
// Route::prefix('/pay')->group(function(){
// 	Route::get('pay','Index\PayController@pay');
// 	Route::get('pcalipay/{order_no}','Index\PayController@pcalipay');
// 	Route::get('returnpay','Index\PayController@returnpay');//同步跳转
// });