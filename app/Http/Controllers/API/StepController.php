<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\StepResource;
use App\Step;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StepController extends Controller
{
    /**
     * @var Step
     */
    protected $steps;

    /**
     * StepController constructor.
     * @param Step $steps
     */
    public function __construct(Step $steps)
    {
        $this->steps = $steps;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return StepResource::collection($this->steps::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedAttributes = $this->validateModel($request->all());
        if (!\is_array($validatedAttributes)) {
            return $validatedAttributes;
        }

        $step = new Step();
        $step->setRawAttributes($validatedAttributes);
        $saved = $step->save();

        $success = [
            'success' => $saved,
            'data' => $step->getAttributes(),
        ];

        return response($success);
    }

    /**
     * Display the specified resource.
     *
     * @param Step $step
     * @return StepResource
     */
    public function show(Step $step)
    {
        return new StepResource($step);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Step $step
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Step $step)
    {
        $validatedAttributesOrErrors = $this->validateModel($request->all());
        if (!\is_array($validatedAttributesOrErrors)) {
            return $validatedAttributesOrErrors;
        }

        $step->setRawAttributes($validatedAttributesOrErrors);
        $saved = $step->save();

        return response([
            'success' => $saved,
            'data' => $step->getAttributes(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Step $step
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Step $step)
    {
        $deleted = $step->delete();

        return response([
            'success' => $deleted,
        ]);
    }

    private function validateModel(array $all)
    {
        $validator = Validator::make($all, [
            'title' => 'required|string|max:255',
            'step_order' => 'numeric|min:0',
            'healing_methods' => 'nullable|string',
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
}
