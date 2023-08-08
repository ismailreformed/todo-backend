<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'numeric',
            'name' => 'string',
            'email' => 'string',
            'local' => 'string|in:bn,en',
        ];
    }
}
