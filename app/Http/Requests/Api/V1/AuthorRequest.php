<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Requests\Api\Request;
use Illuminate\Validation\Rule;

class AuthorRequest extends Request
{

     /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = false;


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
        $authorId = request()->author;
        $rules = [
            'author_name' => ['required', 'max: 150'],
            'email' => ['required', 'email'],
            'phone_number' => ['required', 'numeric', 'digits: 10'],
            'address' => ['nullable', 'max: 200'],
        ];
        $uniqueRuleAuthor = Rule::unique('authors', 'author_name')->whereNull('deleted_at');
        $uniqueRuleEmail = Rule::unique('authors', 'email')->whereNull('deleted_at');
        $uniqueRulePhone = Rule::unique('authors', 'phone_number')->whereNull('deleted_at');
        if($authorId) {
            $rules['author_name'][] = $uniqueRuleAuthor->ignore($authorId, 'uuid');
            $rules['email'][] = $uniqueRuleEmail->ignore($authorId, 'uuid');
            $rules['phone_number'][] = $uniqueRulePhone->ignore($authorId, 'uuid');
        } else {
            $rules['author_name'][] = $uniqueRuleAuthor;
            $rules['email'][] = $uniqueRuleEmail;
            $rules['phone_number'][] = $uniqueRulePhone;
        }
        return $rules;
    }
}
