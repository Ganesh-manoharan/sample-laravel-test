<?php

namespace App\Rules;

use App\Http\Traits\Base64ToImage;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Validation\Rule;

class EncodedDocumentType implements Rule
{
    use Base64ToImage;
    const EXTENSION_TYPES = ["jpg", "jpeg", "JPG", "JPEG", "png", "PNG", "GIF", "gif", "bmp", "BMP"];
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
        if($value)
        {
            $image = self::base64todata($value);
            Log::info($image['extension']);
            return in_array($image['extension'],self::EXTENSION_TYPES);
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The uploaded encode document string is invalid.';
    }
}
