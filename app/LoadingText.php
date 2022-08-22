<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoadingText extends Model
{
    //
    public $table = 'loading_text';
    protected $fillable = [
        'text'
    ];
}
