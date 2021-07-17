<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreCompanyRequest extends FormRequest
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
       

        if($this->variable=="companydetails")
        {
            $rules['company_name'] = 'required|max:50';
            $rules['contact_number'] = 'required|max:10';
            $rules['contact_email'] = 'required';
            $rules['address_line_one'] = 'required';
        }
        else if($this->variable=="companyadmins")
        {
            //$rules['company_admin_username'] = 'required';
            //$rules['company_admin_email'] = 'required';
            $rules['account_admin_user']='required';
        }
        else if($this->variable=="companydepartments")
        {
            //$rules['departments'] = 'required';
            $rules['company_departments']='required';
        }
       
        return $rules;
    }
    protected function failedValidation(Validator $validator)
    {
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json(['data'=>$validator->errors(),'hasErrors'=>true]));
            
        }
    }
}
