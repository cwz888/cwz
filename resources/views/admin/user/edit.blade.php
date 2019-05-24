<form action="/user/update/{{$data->user_id}}" method="post">
	<table border="1" align="center">
	@csrf
		<tr>
			<td>管理员名称</td>
			<td><input type="text" name="user_name" value="{{$data->user_name}}"></td>
		</tr>
		<tr>
			<td>管理员密码</td>
			<td><input type="password" name="user_pwd" value="{{$data->user_pwd}}"></td>
		</tr>
		<tr>
			<td>职位</td>
			<td><input type="text" name="user_position" value="{{$data->user_position}}"></td>
		</tr>
		<tr>
			<td>是否在职</td>
			<td>
				<input type="radio" name="user_static" value="1" @if($data->user_static==1) checked @endif>是
				<input type="radio" name="user_static" value="2" @if($data->user_static==2) checked @endif>否
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><button>修改</button></td>
		</tr>
	</table>
</form>