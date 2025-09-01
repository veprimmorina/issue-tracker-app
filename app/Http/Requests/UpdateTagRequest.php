<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $tagId = $this->route('tag')->id;

        return [
            'name'  => 'required|unique:tags,name,' . $tagId,
            'color' => 'required|string',
        ];
    }
}
