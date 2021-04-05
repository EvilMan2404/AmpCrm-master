<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Files implements Rule
{
    private string $files;

    /**
     * Create a new rule instance.
     *
     */
    public function __construct()
    {

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $files = explode(',', $value);
        return (\App\Models\Files::getListWhereIdIn($files)->count()) === count($files);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('rules.files');
    }
}
