<?php

namespace App\Http\Controllers\API;

use App\DoneStep;
use App\Exceptions\ModelSaveException;
use App\Http\Resources\StepProcedureResource;
use App\StepProcedure;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StepProcedureController extends Controller
{
    public const ATTR_USER_ID = 'user_id';
    public const ATTR_TOTAL_SPENT_TIME = 'total_spent_time';
    public const ATTR_DONE_STEPS = 'done_steps';

    /**
     * @var StepProcedure
     */
    private $stepProcedure;

    public function __construct(StepProcedure $stepProcedure)
    {
        $this->stepProcedure = $stepProcedure;
    }

    private function validateModel($all)
    {
        $validator = Validator::make($all, [
            static::ATTR_USER_ID => 'required',
            static::ATTR_TOTAL_SPENT_TIME => 'required',
            static::ATTR_DONE_STEPS => 'required',
        ]);

        if ($validator->fails()) {
            $failed = [
                'success' => false,
                'errors' => $validator->errors(),
            ];

            return response($failed);
        }

        $validatedAttributes = $validator->validate();

        return $validatedAttributes;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return StepProcedureResource::collection($this->stepProcedure::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $request->all();
        $attributes['user_id'] = Auth::guard('api')->id();

        $validatedAttributes = $this->validateModel($attributes);
        if (!\is_array($validatedAttributes)) {
            return $validatedAttributes;
        }

        $saved = false;
        $data = null;
        try {
            DB::beginTransaction();

            $stepProcedure = StepProcedure::createByAttributes($attributes);

            $doneStepAttributes = array_get($attributes, static::ATTR_DONE_STEPS, []);
            foreach ($doneStepAttributes as $doneStepItemsAttribute) {
                $doneStep = new DoneStep($doneStepItemsAttribute);
                if (!$stepProcedure->doneSteps()->save($doneStep)) {
                    throw new ModelSaveException('Can not save ' . DoneStep::class);
                }
            }

            $data = $stepProcedure->getAttributes();
            $saved = true;

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
        }

        $result = [
            'success' => $saved,
            'data' => $data,
        ];

        return response($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
