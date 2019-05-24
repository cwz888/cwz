<form action="/news/do_add" method="post" enctype="multipart/form-data">
            @if ($errors->any())
				 <div class="alert alert-danger">
				 <ul>
				 @foreach ($errors->all() as $error)
				 <li>{{ $error }}</li>
				 @endforeach
				 </ul>
				 </div>
			@endif
			@csrf
	<table border="1" align="center">
		<tr>
			<td>文章标题：</td>
			<td><input type="text" class="input1" name="n_title" id="name"/></td>
		</tr>
		<tr>
			<td>文章分类：</td>
			<td>
				<select name="c_id" id="">
				@foreach($data as $v)
					<option value="{{$v->c_id}}">{{$v->c_name}}</option>
				@endforeach
				</select>
			</td>
		</tr>
		<tr>
			<td>文章重要性：</td>
			<td>
				<input type="radio" name="n_static" value="1" class="radio" checked/>普通
				<input type="radio" name="n_static" value="2" class="radio" >置顶
			</td>
		</tr>
		<tr>
			<td>是否显示:</td>
			<td>
				<input type="radio" name="n_statics" value="1" class="radio" checked/>是
				<input type="radio" name="n_statics" value="2" class="radio">否
			</td>
		</tr>
		<tr>
			<td>文章作者：</td>
			<td><input type="text" class="input1" name="n_man" id="position"/></td>
		</tr>
		<tr>
			<td>作者email：</td>
			<td><input type="text" class="input1" name="n_email" id="position"/></td>
		</tr>
		<tr>
			<td>关键字：</td>
			<td><input type="text" class="input1" name="n_guan" id="position"/></td>
		</tr>
		<tr>
			<td>网页描述: </td>
			<td>
				<textarea name="n_desc" cols="30" rows="4"></textarea>
			</td>
		</tr>
		<tr>
			<td>文件上传: </td>
			<td>
				 <input type="file" name="n_img" />
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><button>添加</button></td>
		</tr>
	</table>
</form>