<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = [
        'title',
        'data',
    ];

    public function step()
    {
        return $this->belongsTo(Step::class);
    }
}
