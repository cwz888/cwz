
<table border="1" align="center">
	<th>
		<a href="/brand/add">添加</a>
	</th>
	<tr>
		<th>品牌id</th>
		<th>品牌名称</th>
		<th>品牌logo</th>
		<th>品牌描述</th>
		<th>品牌网址</th>
		<th>操作</th>
	</tr>
	@if($data)
	@foreach($data as $v)
	<tr>
		<th>{{$v->brand_id}}</th>
		<th>{{$v->brand_name}}</th>
		<th><img src="{{config('app.img_url')}}{{$v->brand_logo}}" width="40"></th>
		<th>{{$v->brand_desc}}</th>
		<th>{{$v->brand_url}}</th>
		<th>
			<a href="{{url('brand/del')}}?brand_id={{$v->brand_id}}">删除</a>
			<a href="/brand/edit/{{$v->brand_id}}">修改</a>
		</th>
	</tr>
	@endforeach
	@endif
</table>
<div align="center">
	{{$data->appends($query)->links()}}
</div>
