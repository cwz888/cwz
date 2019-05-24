<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //设置表名
	protected $table = 'brand';
    //设置主键
	protected $primaryKey="brand_id";
    //开启自动时间戳
	public $timestamps = false;
    //改变时间戳字段名
    const CREATED_AT = 'create_time';
 	const UPDATED_AT = 'update_time';
 	//白名单 可以被赋值的属性 静态调用时可以用
 	// protected $fillable = [
 	// 	'brand_name',
 	// 	'brand_logo',
 	// 	'brand_url',
 	// 	'brand_desc',
 	// 	'create_time'
 	// ];
 	//黑名单
 	// protected $guarded = [
 	// 	'brand_name',
 	// 	'brand_logo',
 	// 	'brand_url',
 	// 	'brand_desc',
 	// 	'create_time',
 	// 	'update_time',
 	// ];
}
