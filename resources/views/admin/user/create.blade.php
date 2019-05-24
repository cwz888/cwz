<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>头部-有点</title>
<link rel="stylesheet" type="text/css" href="/css/css.css" />
<script type="text/javascript" src="/js/jquery.min.js"></script>
</head>
<body>
				@if ($errors->any())
				 <div class="alert alert-danger">
				 <ul>
				 @foreach ($errors->all() as $error)
				 <li>{{ $error }}</li>
				 @endforeach
				 </ul>
				 </div>
				@endif
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="/img/coin02.png" /><span><a href="/">首页</a>&nbsp;-&nbsp;<a
					href="/user/list">管理员列表</a>&nbsp;
			</div>
		</div>
		<div class="page ">
			<!-- 上传广告页面样式 -->
			<div class="banneradd bor">
				<div class="baTop">
					<span>管理员添加</span>
				</div>
				<div id="lp">
					<meta name="csrf-token" content="{{ csrf_token() }}">
				</div>
				<div class="baBody">
					<div class="bbD">
						管理员名称：<input type="text" class="input1" name="user_name" id="name"/>
					</div>
					<div class="bbD">
						管理员密码：<input type="password" class="input1" name="user_pwd" id="pwd"/>
					</div>
					<div class="bbD">
						确认密码**：<input type="password" class="input1" name="user_pswd" id="pswd"/>
					</div>
					<div class="bbD">
						管理员职位：<input type="text" class="input1" name="user_position" id="position"/>
					</div>
					<div class="bbD">
						是否停职：
						<label><input type="radio" name="user_static" value="1" class="radio" checked/>是</label>
						<label><input type="radio" name="user_static" value="2" class="radio"/>否</label>
					</div>
					<div class="bbD">
						<p class="bbDP">
							<button class="btn_ok btn_yes" id="submit">添加</button>
							<a class="btn_ok btn_no" href="#">取消</a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<script>
	$.ajaxSetup({
		 headers: {
		 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		 }
	});
	$('#submit').click(function(){
		var user_name=$('#name').val();
		if(user_name==''){
			alert('名称不可为空');
			return false;
		}
		var user_pwd=$('#pwd').val();
		if(user_pwd==''){
			alert('密码不可为空');
			return false;
		}
		var user_position=$('#position').val();
		if(user_position==''){
			alert('职位不可为空');
			return false;
		}
		var user_pswd=$('#pswd').val();
		if(user_pswd==''){
			alert('确认密码不可为空');
			return false;
		}
		if(user_pwd!=user_pswd){
			alert('两次密码请保持一致');
			return false;
		}
		var user_static=$('.radio:checked').val();
		$.post(
			'do_add',
			{user_name:user_name,user_pwd:user_pwd,user_pswd:user_pswd,user_static:user_static,user_position:user_position},
			function(res){
				if(res.code==1){
					alert('添加成功');
					location.href="list";
				}else{
					alert('添加失败');
					return false;
				}
			},
			'json'
		);
	});
</script>