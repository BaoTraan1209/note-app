<?php

namespace App\Http\Requests\Note;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'content' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|max:4096',
            'password' => 'nullable|string',
            'is_pinned' => 'nullable|boolean',
            'font_size' => 'nullable|integer|min:14|max:28',
            'share_emails' => 'nullable|string',
            'share_permission' => 'nullable|in:read,edit',

            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string',
        ];
    }
}
