<?php

namespace App;

use App\Exceptions\ModelSaveException;
use Illuminate\Database\Eloquent\Model;

class StepProcedure extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'total_spent_time'];

    /**
     * @param $attributes
     * @return StepProcedure
     * @throws ModelSaveException
     */
    public static function createByAttributes($attributes)
    {
        $stepProcedure = new self($attributes);
        if (!$stepProcedure->save()) {
            throw new ModelSaveException('Can not save ' . self::class);
        }

        return $stepProcedure;
    }

    public function doneSteps()
    {
        return $this->hasMany(DoneStep::class);
    }
}
