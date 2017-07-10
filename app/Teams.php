<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{ 
	protected $table = 'teams';
	protected $fillable = [
		'team_id',
		'g_username',
		'password',
		'provider_id'
	];
    
}
