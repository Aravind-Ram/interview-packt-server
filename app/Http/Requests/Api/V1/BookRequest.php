<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Requests\Api\Request;
use Illuminate\Validation\Rule;

class BookRequest extends Request
{
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $bookId = request()->book;
        $rules = [
            'title' => ['required', 'max: 200'],
            'author_id' => ['required', Rule::exists('authors', 'uuid')],
            'genre_id' => ['required', Rule::exists('genres', 'uuid')],
            'publisher_id' => ['nullable', Rule::exists('publishers', 'uuid')],
            
            'description' => ['nullable', 'max: 200'],
            'isbn' => ['required', 'max: 20'],
            'published_at' => ['required'],
        ];
        $uniqueBook = Rule::unique('books', 'isbn')->whereNull('deleted_at');
        if($bookId) {
            $rules['isbn'][] = $uniqueBook->ignore($bookId, 'uuid');
            $rules['gallery_id'] = ['nullable', Rule::exists('galleries', 'uuid')];
        } else {
            $rules['isbn'][] = $uniqueBook;
            $rules['gallery_id'] = ['required', Rule::exists('galleries', 'uuid')];
        }
        return $rules;
    }
}
