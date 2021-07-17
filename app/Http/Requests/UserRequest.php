<?php

namespace App\Http\Requests;

use App\Rules\ImageDocumentType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
            $rules['name']='required';
            $rules['email']='required';
            $rules['company_role']='required';
            $rules['role_id']='required';
            $rules['department_clients_input']='required';
            $rules['department-icon']=['max:2048',new ImageDocumentType];
        return $rules;
    }
    
    protected function failedValidation(Validator $validator)
    {
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json(['data'=>$validator->errors(),'hasErrors'=>true]));
            
        }
    }
}
