<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreDocumentRequest extends FormRequest
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
            "document_file" => "required|mimetypes:application/pdf|mimes:pdf|max:10000|clamav"
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if ($validator->fails()) {
            Log::info($validator->errors());
            throw new HttpResponseException(response()->json(['data'=>$validator->errors(),'hasErrors'=>true]));
            
        }
    }
}
