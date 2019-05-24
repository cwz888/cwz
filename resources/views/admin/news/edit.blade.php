<form action="/news/update" method="post" enctype="multipart/form-data">
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
	<input type="hidden" name="n_id" value="{{$res->n_id}}">
		<tr>
			<td>文章标题：</td>
			<td><input type="text" class="input1" name="n_title" id="name" value="{{$res->n_title}}"/></td>
		</tr>
		<tr>
			<td>文章分类：</td>
			<td>
				<select name="c_id" id="">
				@foreach($c as $v)
				
					<option value="{{$v->c_id}}" @if($res->c_id==$v->c_id) selected @endif>{{$v->c_name}}</option>
				
				@endforeach
				</select>
			</td>
		</tr>
		<tr>
			<td>文章重要性：</td>
			<td>
				<input type="radio" name="n_static" value="1" class="radio" @if($res->n_static==1) checked @endif/>普通
				<input type="radio" name="n_static" value="2" class="radio" @if($res->n_static==2) checked @endif>置顶
			</td>
		</tr>
		<tr>
			<td>是否显示:</td>
			<td>
				<input type="radio" name="n_statics" value="1" class="radio" @if($res->n_statics==1) checked @endif/>是
				<input type="radio" name="n_statics" value="2" class="radio" @if($res->n_statics==2) checked @endif>否
			</td>
		</tr>
		<tr>
			<td>文章作者：</td>
			<td><input type="text" class="input1" name="n_man" id="position" value="{{$res->n_man}}"/></td>
		</tr>
		<tr>
			<td>作者email：</td>
			<td><input type="text" class="input1" name="n_email" id="position" value="{{$res->n_email}}"/></td>
		</tr>
		<tr>
			<td>关键字：</td>
			<td><input type="text" class="input1" name="n_guan" id="position" value="{{$res->n_guan}}"/></td>
		</tr>
		<tr>
			<td>网页描述: </td>
			<td>
				<textarea name="n_desc" cols="30" rows="4">{{$res->n_desc}}</textarea>
			</td>
		</tr>
		<tr>
			<td>文件上传: </td>
			<td>
				 <input type="file" name="n_img"/>
				 <img src="{{config('app.img_url')}}{{$res->n_img}}" width="40">
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><button>添加</button></td>
		</tr>
	</table>
</form>