<table border="1" align="center">
	<tr>
		<td colspan="5" align="center"><a href="/cate/add">添加</a></td>
	</tr>
	<tr>
		<td>id</td>
		<td>分类名称</td>
		<td>是否显示</td>
		<td>是否开启</td>
		<td>操作</td>
	</tr>
	@foreach($data as $k=>$v)
	<tr>
		<td>{{$v->c_id}}</td>
		<td>{{str_repeat('-',$v->c_lev)}}{{$v->c_name}}</td>
		<td>
			@if($v->c_show==1)
			是
			@else
			否
			@endif
		</td>
		<td>
			@if($v->c_static==1)
			是
			@else
			否
			@endif
		</td>
		<td>
			<a href="/cate/edit/{{$v->c_id}}">编辑</a>
			<a href="javascript:;" id="del">删除</a>
		</td>
	</tr>
	@endforeach
</table>