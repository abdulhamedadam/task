<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;

class ValidateMultipleImages implements Rule
{
    public function passes($attribute, $value)
    {
        if (!is_array($value)) {
            return false;
        }

        foreach ($value as $file) {
            if (!$file instanceof UploadedFile) {
                return false;
            }

            if (!$file->isValid()) {
                return false;
            }

            // Add your custom validation logic here
            // For example, check file size, dimensions, etc.
        }

        return true;
    }

    public function message()
    {
        return 'The :attribute field contains invalid images.';
    }
}
