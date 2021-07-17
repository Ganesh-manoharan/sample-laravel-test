<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SaveTaskCreationRequest extends FormRequest
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
         $abn='';
        if($this->customRadio1==1 || $this->customRadio1==2)
        {
            $abn='required';
        }
        else
        {
            $abn='nullable';
        }
        return [
            'comments'=>$abn
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json(['data'=>$validator->errors(),'hasErrors'=>true]));
            
        }
    }
}
