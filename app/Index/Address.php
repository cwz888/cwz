<?php

namespace App\Index;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //设置表名
	protected $table = 'address';
	protected $primaryKey="a_id";
	//开启自动时间戳
	public $timestamps = false;
}
