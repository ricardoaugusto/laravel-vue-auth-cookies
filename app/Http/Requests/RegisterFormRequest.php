<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\CustomizesValidationExceptionMessageTrait;
use Illuminate\Foundation\Http\FormRequest;

class RegisterFormRequest extends FormRequest
{
    use CustomizesValidationExceptionMessageTrait;

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
     * @return string
     */
    public function message()
    {
        return 'Could not register you:';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
        ];
    }
}
