<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Step
 *
 * @property Form $form
 */
class Step extends Model
{
    protected $fillable = [
        'title',
        'step_order',
        'healing_methods',
    ];

    public function form()
    {
        return $this->hasOne(Form::class);
    }
}
