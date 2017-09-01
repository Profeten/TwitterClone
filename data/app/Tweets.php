<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Tweets extends Eloquent
{
    protected $collection = 'tweets';
    protected $fillable = ['messaged_by', 'message', 'mentions', 'channels'];
}
