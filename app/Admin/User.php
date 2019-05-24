<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //设置表名
	protected $table = 'user';
	protected $primaryKey="user_id";
	//开启自动时间戳
	public $timestamps = false;
    //改变时间戳字段名
    const CREATED_AT = 'create_time';
 	const UPDATED_AT = 'update_time';
}
