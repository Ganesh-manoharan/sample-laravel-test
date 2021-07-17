<?php

namespace App\Http\Requests;

use App\Rules\ImageDocumentType;
use App\Rules\EncodedDocumentType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateClientRequest extends FormRequest
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
        $rules['clientName']='required';
        $rules['clientEmail']='required';
        $rules['clients_departments']='required';
        $rules['clients_fundgroups']='required';
        $rules['department-icon']=['max:2048',new ImageDocumentType];
        $rules['upload_icon']=new EncodedDocumentType;
        return $rules;
    }
    protected function failedValidation(Validator $validator)
    {
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json(['data'=>$validator->errors(),'hasErrors'=>true]));
            
        }
    }

}
