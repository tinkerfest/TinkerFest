<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'video';
    protected $fillable = [
       'provider_id',
       'p_id',
       'video_id',
       'video_name',
       'youtube_id',
       'thumbnail_url'
   ];
}
