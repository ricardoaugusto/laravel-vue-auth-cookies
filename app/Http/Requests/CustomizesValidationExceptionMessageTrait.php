<?php

namespace App\Http\Requests\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Trait CustomizesValidationExceptionMessageTrait
 * @package App\Http\Requests\Traits
 *
 * https://blog.rockett.pw/post/how-to-add-a-custom-validation-message-in-laravel-5.5-form-requests
 */
trait CustomizesValidationExceptionMessageTrait
{
    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $message = (method_exists($this, 'message'))
            ? $this->container->call([$this, 'message'])
            : 'The given data was invalid.';

        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'message' => $message,
        ], 422));
    }
}
