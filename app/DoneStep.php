<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoneStep extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['step_id', 'form_data_value', 'spent_time'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stepProcedure()
    {
        return $this->belongsTo(StepProcedure::class);
    }
}
