<?php

declare(strict_types=1);

namespace App\Http\Requests\Posts;

use App\Http\DTO\Posts\NewPostDTO;
use Illuminate\Foundation\Http\FormRequest;

final class StorePostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tags' => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'O título é obrigatório.',
            'title.string' => 'O título deve ser uma string.',
            'title.max' => 'O título não pode ter mais de 255 caracteres.',
            'content.required' => 'O conteúdo é obrigatório.',
            'content.string' => 'O conteúdo deve ser uma string.',
            'tags.required' => 'As tags são obrigatórias.',
            'tags.array' => 'As tags devem ser um array.',
        ];
    }

    public function toDTO(string $userId): NewPostDTO
    {
        return NewPostDTO::fromRequest(data: [
            'title' => $this->string('title')->toString(),
            'content' => $this->string('content')->toString(),
            'tags' => $this->get('tags'),
            'user_id' => $userId
        ]);
    }
}
