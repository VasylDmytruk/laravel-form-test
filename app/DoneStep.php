<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DoneStep
 *
 * @property StepProcedure $stepProcedure
 * @property Step $step
 */
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function step()
    {
        return $this->belongsTo(Step::class);
    }
}
