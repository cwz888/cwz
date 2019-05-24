<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
    //设置表名
	protected $table = 'cate';
	protected $primaryKey="c_id";
	//开启自动时间戳
	public $timestamps = false;
}
