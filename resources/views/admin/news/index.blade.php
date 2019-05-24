<script type="text/javascript" src="/js/jquery.js"></script>
<link rel="stylesheet" href="{{asset('css/page.css')}}">
<form align="center">
	<input type="text" name="c_name" value="{{$query['c_name']??''}}" placeholder="请输入分类关键字">
	<input type="text" name="n_title" value="{{$query['n_title']??''}}" placeholder="请输入名称关键字">
	<button>搜索</button>
</form>

<table align="center" border="1">
<meta name="csrf-token" content="{{ csrf_token() }}">
	<tr>
		<td>编号</td>
		<td>文章标题</td>
		<td>文章分类</td>
		<td>文章重要性</td>
		<td>是否显示</td>
		<td>添加时间</td>
		<td>文章图片</td>
		<td>操作</td>
	</tr>
	@foreach($res as $v)
	<tr n_id="{{$v->n_id}}">
		<td>{{$v->n_id}}</td>
		<td>{{$v->n_title}}</td>
		<td>{{$v->c_name}}</td>
		<td>
		@if($v->n_static==1)
			置顶
		@else
			普通
		@endif
		</td>
		<td>
		@if($v->n_statics==1)
			是
		@else
			否
		@endif
		</td>
		<td>{{date('Y-m-d H:i:s',$v->n_time)}}</td>
		<td><img src="{{config('app.img_url')}}{{$v->n_img}}" width="40"></td>
		<td>
			<a href="javascript:;" class="del">删除</a>
			<a href="/news/edit/{{$v->n_id}}">修改</a>
		</td>
	</tr>
	@endforeach
</table>
<div align="center">{{$res->appends($query)->links()}}</div>
<script type="text/javascript">

	$.ajaxSetup({
		 headers: {
		 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		 }
	});

	$('.del').click(function(){
		var _this=$(this);
		var n_id=_this.parents('tr').attr('n_id');
		$.post(
			"/news/del",
			{n_id:n_id},
			function(res){
				if(res.code==1){
					alert(res.content);
					history.go(0);
				}
			},
			'json'
		);
	});
</script>
