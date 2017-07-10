<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
	protected $table = 'members';
	protected $fillable = [
			'full_name',
			'email',
			'team_id',
			'avatar', 
			'gender',
			'birthday',
			'mobile_number',
		]
    //
}
