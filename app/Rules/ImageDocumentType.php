<?php

namespace App\Rules;

use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Validation\Rule;

class ImageDocumentType implements Rule
{
    const MIME_TYPES = [
        'image/gif',
        'image/jpeg',
        'image/png'
    ];
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return in_array($value->getMimeType(),self::MIME_TYPES);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Check uploaded image document type';
    }
}
