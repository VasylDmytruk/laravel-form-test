<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\StepResource;
use App\Step;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StepController extends Controller
{
    private const MAX_STEP_ORDER = '1000000';

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
        $this->middleware('auth:api');

        $this->steps = $steps;
    }

    public function sort(Request $request)
    {
        $itemsToSort = $request->all();
        $ids = array_column($itemsToSort, 'id');
        $indexedItemsToSort = [];
        foreach ($itemsToSort as $item) {
            $indexedItemsToSort[$item['id']] = $item;
        }

        $steps = $this->steps::whereIn('id', $ids)->get();
        if (is_iterable($steps)) {
            foreach ($steps as $step) {
                /* @var $step Step */
                $step->step_order = $indexedItemsToSort[$step->id]['step_order']
                    ?? $indexedItemsToSort[$step->id]['step_order'];
                $step->save();
            }
        }

        $response = ['reordered' => true];

        return response($response);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return StepResource::collection($this->steps::orderBy('step_order')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedAttributes = $this->validateModels($request->all());
        if (!\is_array($validatedAttributes)) {
            return $validatedAttributes;
        }

        // TODO make in one model
        [$stepAttributes, $formAttributes] = $validatedAttributes;

        if (array_has($formAttributes, 'data')) {
            $formAttributes['data'] = json_encode($formAttributes['data']);
        }

        $stepOrder = array_get($stepAttributes, 'step_order');
        if ($stepOrder === null) {
            // TODO compute max value somehow
            $stepAttributes['step_order'] = self::MAX_STEP_ORDER;
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
            'step_order' => 'nullable|numeric|min:0',
            'healing_methods' => 'nullable|string',
        ];

        return $this->validateModel($step, $rules);
    }

    private function validateFormModel($form)
    {
        $rules = [
            'title' => 'nullable|string|max:255',
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
