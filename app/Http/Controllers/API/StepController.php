<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\StepResource;
use App\Step;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Null_;

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
        $validatedAttributes = $this->validateModels($request->all());
        if (!\is_array($validatedAttributes)) {
            return $validatedAttributes;
        }

        // TODO make in one model
        list($stepAttributes, $formAttributes) = $validatedAttributes;

        if (array_has($formAttributes, 'data')) {
            $formAttributes['data'] = json_encode($formAttributes['data']);
        }

        $step = new Step();
        $step->setRawAttributes($stepAttributes);
        $saved = $step->save();
        $form = null;

        if ($saved) {
            $form = $step->form()->create($formAttributes);
        }

        $saved = ($form !== null);

        $success = [
            'success' => $saved,
            'data' => [
                'step' => $step->getAttributes(),
                'form' => $form ? $form->getAttributes() : [],
            ],
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
        $validatedAttributes = $this->validateModels($request->all());
        if (!\is_array($validatedAttributes)) {
            return $validatedAttributes;
        }

        list($stepAttributes, $formAttributes) = $validatedAttributes;

        if (array_has($formAttributes, 'data')) {
            $formAttributes['data'] = json_encode($formAttributes['data']);
        }

        $saved = $step->fill($stepAttributes)->save();
        $emptyFormAttributes = empty($formAttributes);
        $formSaved = $emptyFormAttributes ? true : false;

        if ($saved && !$emptyFormAttributes) {
            $formSaved = $step->form
                ? $step->form->fill($formAttributes)->save()
                : $step->form()->create($formAttributes)->save();
        }

        $saved = $formSaved;

        return response([
            'success' => $saved,
            'data' => [
                'step' => $step->getAttributes(),
                'form' => $step->form ? $step->form->getAttributes() : [],
            ],
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
        $deleted = false;

        if ($step->form) {
            $deleted = $step->form->delete();
        }

        $deleted = $deleted && $step->delete();

        return response([
            'success' => $deleted,
        ]);
    }

    private function validateModels(array $all)
    {
        $step = array_get($all, 'step', []);
        $form = array_get($all, 'form', []);

        $validatedStepAttributesOrErrors = $this->validateStepModel($step);
        if (!\is_array($validatedStepAttributesOrErrors)) {
            return $validatedStepAttributesOrErrors;
        }

        $validatedFormAttributesOrErrors = $this->validateFormModel($form);
        if (!\is_array($validatedFormAttributesOrErrors)) {
            return $validatedFormAttributesOrErrors;
        }

        $stepAttributes = $validatedStepAttributesOrErrors;
        $formAttributes = $validatedFormAttributesOrErrors;

        return [$stepAttributes, $formAttributes];
    }

    private function validateStepModel($step)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'step_order' => 'numeric|min:0',
            'healing_methods' => 'nullable|string',
        ];

        return $this->validateModel($step, $rules);
    }

    private function validateFormModel($form)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'data' => 'required',
        ];

        return $this->validateModel($form, $rules);
    }

    private function validateModel($attributes, $rules)
    {
        $validator = Validator::make($attributes, $rules);

        if ($validator->fails()) {
            $failed = [
                'success' => false,
                'errors' => $validator->errors(),
            ];
            return response($failed);
        }

        return $validator->validate();
    }
}
