<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    public function form()
    {
        return $this->hasOne(Form::class);
    }
}
