<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FormValidationRequest extends FormRequest
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
        if($this->variable=="funddetails")
        {
            $rules['fundName'] = 'required';
            $rules['registeredAddress']='required|max:100';
           
        }
        else if($this->variable=="subfunddetails")
        {
            $rules['subfundName']='required';
            $rules['investment_manager']='required|max:100';
            $rules['initial_launch_date']='required';
        }
        else if($this->variable=="clientdetails")
        {
            $rules['clientName']='required';
            $rules['clientEmail']='required';
            $rules['clients_departments']='required';
            $rules['clients_fundgroups']='required';
        }
        else if($this->variable=="documentdetails")
        {
            $rules['document_title']='required';
            $rules['document_type']='required';
        }
        else if($this->variable=="userdetails")
        {
            $rules['name']='required';
            $rules['email']='required';
            $rules['company_role']='required';
            $rules['role_id']='required';
            $rules['department_clients_input']='required';
        }
        else if($this->variable=="deptdetails")
        {
            $rules['department_name']='required';
            $rules['department_all_input']='required';
            $rules['department_admin_input']='required';
        }
        else if($this->variable=="reportdetails")
        {
            $rules['report_type']='required';
            $rules['report_name']='required';
            $rules['frequency']='required';

           if($this->report_type==1)
           {
            $rules['report_documents']='required';
            $rules['clients']='required';
            $rules['report_departments']='required';
            $rules['clients_fundgroups']='required';
            $rules['subfunds']='required';
           }
           else if($this->report_type==2)
           {
               $rules['departments']='required';
               $rules['risk_category']='required';
               $rules['subcategory']='required';
           }
           else if($this->report_type==3)
           {
                $rules['clients']='required';
                $rules['report_departments']='required';
                $rules['clients_fundgroups']='required';
                $rules['subfunds']='required';
           }

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
