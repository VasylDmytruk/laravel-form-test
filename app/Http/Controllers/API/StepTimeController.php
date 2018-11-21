<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\StepTimeResource;
use App\StepTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StepTimeController extends Controller
{
    /**
     * @var StepTime
     */
    private $stepTimes;


    /**
     * StepTimeController constructor.
     *
     * @param StepTime $stepTime
     */
    public function __construct(StepTime $stepTime)
    {
        $this->stepTimes = $stepTime;
    }

    private function validateModel($all)
    {
        $validator = Validator::make($all, [
            'step_id' => 'required',
            'user_id' => 'required',
            'spent_time' => 'required',
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
        return StepTimeResource::collection($this->stepTimes::orderBy('created_at', 'desc')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $stepTimeData = $request->all();
        $stepTimeData['user_id'] = Auth::guard('api')->id();

        $validatedAttributes = $this->validateModel($stepTimeData);
        if (!\is_array($validatedAttributes)) {
            return $validatedAttributes;
        }

        $stepTime = new StepTime();
        $stepTime->setRawAttributes($validatedAttributes);
        $saved = $stepTime->save();

        $success = [
            'success' => $saved,
            'data' => $stepTime->getAttributes(),
        ];

        return response($success);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
