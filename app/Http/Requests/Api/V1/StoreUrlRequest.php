<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreUrlRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'data.attributes.longUrl' => 'required|active_url',
            'data.relationships.user.data.id' => 'required|numeric|size:' . auth()->id()
        ];
    }

    public function mappedAttributes()
    {
        $attributes = [
            'longUrl' => 'data.attributes.longUrl',
            'user_id' => 'data.relationships.user.data.id'
        ];
        $mappedAttributes = [];

        foreach ($attributes as $key => $value) {
            $mappedAttributes[$key] = rtrim($this[$value], '/');
        }
        return $mappedAttributes;
    }
}
