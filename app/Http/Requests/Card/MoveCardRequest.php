<?php

namespace App\Http\Requests\Card;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MoveCardRequest extends FormRequest
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
            'board_list_id' => [
                'required',
                Rule::exists('board_lists', 'id')->where('board_id', $this->board->id),
            ],
            'position' => ['required', 'integer', 'min:0'],
        ];
    }
}
