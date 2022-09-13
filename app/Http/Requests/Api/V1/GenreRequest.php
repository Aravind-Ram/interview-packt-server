<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Requests\Api\Request;
use Illuminate\Validation\Rule;


class GenreRequest extends Request
{

    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

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
        $genreId = request()->genre;
        $rules = [
            'genre_name' => ['required', 'max: 150'],
            'description' => ['nullable', 'max: 200'],
        ];
        $uniqueRule = Rule::unique('genres', 'genre_name')->whereNull('deleted_at');
        if($genreId) {
            $rules['genre_name'][] = $uniqueRule->ignore(request()->genre, 'uuid');
        } else {
            $rules['genre_name'][] = $uniqueRule;
        }
        return $rules;
    }

    
}
