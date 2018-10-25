<?php

namespace App\Http\Controllers\API;

use App\Form;
use App\Http\Resources\FormCollection;
use App\Http\Resources\FormResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    private const PARAM_VUE_ID = 'vue_id';
    private const PARAM_NAME = 'name';
    private const PARAM_DATA = 'data';

    /**
     * @var Form
     */
    protected $forms;


    /**
     * FormController constructor.
     *
     * @param Form $forms
     */
    public function __construct(Form $forms)
    {
        $this->forms = $forms;

//        $this->middleware('auth:api');
    }

    private function validateModel($all)
    {
        $validator = Validator::make($all, [
            'name' => 'required|string|max:255',
            'data' => 'required',
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
     * @return FormCollection|\Illuminate\Http\Response
     */
    public function index()
    {
        //

        return new FormCollection($this->forms::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedAttributes = $this->validateModel($request->all());
        if (!is_array($validatedAttributes)) {
            return $validatedAttributes;
        }

        $form = new Form();
        $form->setRawAttributes($validatedAttributes);

        if (!empty($form->data)) {
            $form->data = json_encode($form->data);
        }

        $saved = $form->save();

        $success = [
            'success' => $saved,
            'data' => $form->getAttributes(),
        ];

        return response($success);
    }

    /**
     * Display the specified resource.
     *
     * @param Form $form
     * @return FormResource|\Illuminate\Http\Response
     */
    public function show(Form $form)
    {
        return new FormResource($form);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Form $form
     * @return array|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function update(Request $request, Form $form)
    {
        $validatedAttributes = $this->validateModel($request->all());
        if (!is_array($validatedAttributes)) {
            return $validatedAttributes;
        }

        $form->setRawAttributes($validatedAttributes);
        if (!empty($form->data)) {
            $form->data = json_encode($form->data);
        }
        $saved = $form->save();

        return response([
            'success' => $saved,
            'data' => $form->getAttributes(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Form $form
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     * @throws \Exception
     */
    public function destroy(Form $form)
    {
        $deleted = $form->delete();

        return response([
            'success' => $deleted,
        ]);
    }
}
