<form action="{{url('/goods/do_add')}}" method="post" enctype="multipart/form-data">
			@csrf
	<table border="1" align="center">
		<tr>
			<td>名字：</td>
			<td><input type="text" class="input1" name="goods_name" id="name"/></td>
		</tr>
		<tr>
			<td>分类：</td>
			<td>
				<select name="c_id">
					<option>--请选择--</option>
				@foreach($res as $v)
					<option class="c_pid" value="{{$v->c_id}}">@php echo str_repeat('~',$v->c_lev) @endphp {{$v->c_name}}</option>
				@endforeach
				</select>
			</td>
		</tr>
		<tr>
			<td>牌分类：</td>
			<td>
				<select name="brand_id">
					<option>--请选择--</option>
				@foreach($data1 as $v)
					<option class="c_pid" value="{{$v->brand_id}}"> {{$v->brand_name}}</option>
				@endforeach
				</select>
			</td>
		</tr>
		<tr>
			<td>是否显示:</td>
			<td>
				<input type="radio" name="goods_show" value="1" class="radio" checked/>是
				<input type="radio" name="goods_show" value="2" class="radio">否
			</td>
		</tr>
		<tr>
			<td>库存</td>
			<td><input type="text" class="input1" name="goods_num" id="position"/></td>
		</tr>
		<tr>
			<td>价格</td>
			<td><input type="text" class="input1" name="goods_price" id="position"/></td>
		</tr>
		
		<tr>
			<td>描述: </td>
			<td>
				<textarea name="goods_desc" cols="30" rows="4"></textarea>
			</td>
		</tr>
		<tr>
			<td>文件上传: </td>
			<td>
				 <input type="file" name="goods_img" />
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><button>添加</button></td>
		</tr>
	</table>
</form>