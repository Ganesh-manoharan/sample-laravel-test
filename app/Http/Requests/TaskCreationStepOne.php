<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TaskCreationStepOne extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    { 
        return [
            'task_name'=>'required|max:50',
            'task_description'=>'required',
            'date' => 'required|date|after_or_equal:today',
            'frequency' => 'required',
            'company'=>'required',
            'fund_groups'=>'required',
            'subfunds'=>'required',
            'departments'=>'required',
            'users' => 'required|array|min:1'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json(['data'=>$validator->errors(),'hasErrors'=>true]));
            
        }
    }
}
