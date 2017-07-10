<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schools extends Model
{
	protected $table = 'schools';
	protected $fillable = [
		'name',
		'c_person_name',
		'c_person_phone',
		'c_person_email',
		'short_name',
		'pic',
	]; 	
    //
}
