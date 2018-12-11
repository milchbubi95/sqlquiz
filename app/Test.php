<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    public function question()
    {
        return $this->hasMany('App\Question');
    }
}
