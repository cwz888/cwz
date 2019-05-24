<script type="text/javascript" src="/js/jquery.js"></script>
	<table border="1" align="center">
	<meta name="csrf-token" content="{{ csrf_token() }}">
		<tr>
			<td>分类名称</td>
			<td><input type="text" name="c_name" id="c_name"></td>
		</tr>
		<tr>
			<td>所属分类</td>
			<td>
				<select name="c_pid">
					<option>--请选择--</option>
				@foreach($data as $v)
					<option class="c_pid" value="{{$v->c_id}}">@php echo str_repeat('~',$v->c_lev) @endphp {{$v->c_name}}</option>
				@endforeach
				</select>
			</td>
		</tr>
		<tr>
			<td>是否显示</td>
			<td>
				<input type="radio" class="c_show" name="c_show" value="1" checked>是
				<input type="radio" class="c_show" name="c_show" value="2">否
			</td>
		</tr>
		<tr>
			<td>是否开启</td>
			<td>
				<input type="radio" class="c_static" name="c_static" value="1" checked>开
				<input type="radio" class="c_static" name="c_static" value="2">关
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input type="button" id="sub" value="提交"></td>
		</tr>
	</table>
<script type="text/javascript">
	$.ajaxSetup({
		 headers: {
		 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		 }
	});
	$('#sub').click(function(){
		var c_name=$('#c_name').val();
		var c_pid=$('.c_pid:selected').val();
		var c_show=$('.c_show:checked').val();
		var c_static=$('.c_static:checked').val();
		$.post(
			"/cate/do_add",
			{c_name:c_name,c_pid:c_pid,c_show:c_show,c_static:c_static},
			function(res){
				alert(res.content);
				location.href="/cate/list";
			},
			'json'
		);
	});
</script>