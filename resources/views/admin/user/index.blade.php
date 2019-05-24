<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="/css/css.css" />
<link rel="stylesheet" type="text/css" href="/css/page.css" />
<script type="text/javascript" src="/js/jquery.min.js"></script>
<!-- <script type="text/javascript" src="js/page.js" ></script> -->
</head>

<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="/img/coin02.png" /><span><a href="/">首页</a>
			</div>
		</div>
		<div class="add">
			<form>
				<input type="text" name="user_name" value="{{$query['user_name']??''}}"/>
				<input type="text" name="user_position" value="{{$query['user_position']??''}}"/>
				<button>搜索</button>
			</form>
		</div>
		<div class="page">
			<!-- banner页面样式 -->
			<div class="banner">
				<div class="add">
					<a class="addA" href="/user/add">添加管理员&nbsp;&nbsp;+</a>
				</div>
				<meta name="csrf-token" content="{{ csrf_token() }}">
				<!-- banner 表格 显示 -->
				<div class="banShow">
					<table border="1" cellspacing="0" cellpadding="0">
						<tr>
							<td width="66px" class="tdColor tdC">序号</td>
							<td width="315px" class="tdColor">管理员名称</td>
							<td width="308px" class="tdColor">职位</td>
							<td width="308px" class="tdColor">是否在职</td>
							<td width="308px" class="tdColor">注册时间</td>
							<td width="125px" class="tdColor">操作</td>
						</tr>
						@foreach($data as $v)
						<tr user_id="{{$v->user_id}}">
							<td>{{$v->user_id}}</td>
							<td>{{$v->user_name}}</td>
							<td>{{$v->user_position}}</td>
							<td>
							@if($v->user_static==1)
								是
							@else
								否
							@endif
							</td>
							<td>{{date('Y-m-d H:i:s',$v->create_time)}}</td>
							<td>
									<a href="/user/edit/{{$v->user_id}}"><img class="operation" src="/img/update.png"></a> 
									<img class="operation del" src="/img/delete.png" >
							</td>
						</tr>
						@endforeach
					</table>
					<div  align="center">{{ $data->appends($query)->links() }}</div>
				</div>
				<!-- banner 表格 显示 end-->
			</div>
			<!-- banner页面样式end -->
		</div>

	</div>
</body>
</html>
<script type="text/javascript">
$.ajaxSetup({
	 headers: {
	 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	 }
});
$('.del').click(function(){
	var _this=$(this);
	var user_id=_this.parents('tr').attr('user_id');
		$.post(
			"del",
			{user_id:user_id},
			function(res){
				if(res.code==1){
					history.go(0);
				}
			},
			'json'
		);
});

</script>