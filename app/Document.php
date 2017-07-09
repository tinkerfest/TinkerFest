<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'document';
    protected $fillable = [
       'provider_id',
       'p_id',
       'document_id',
       'document_name',
       'googledrive_id',
       'googledrive_url',
       'thumbnail_url'
   ];
}
