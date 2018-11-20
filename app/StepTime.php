<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StepTime extends Model
{
    public function step()
    {
        return $this->belongsTo(Step::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
