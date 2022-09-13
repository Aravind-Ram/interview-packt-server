<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

abstract class Request extends FormRequest
{

    /**
     * Indicates whether validation should stop after the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;


    public function formatErrors($validator) 
    {
        $errors = [];
        foreach ($validator->errors()->getMessages() as $key => $value) {
            if($validator->errors()->has($key)) {
                $errors[$key] = $validator->errors()->first($key);
            }
        }        
        return $errors;
    }
    /**
     * Returns validations errors.
     *
     * @param Validator $validator
     * @throws  HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        // Get all the errors thrown
        $errors = collect($validator->errors());
        // Manipulate however you want. I'm just getting the first one here,
        // but you can use whatever logic fits your needs.
        $error = $errors->unique()->first();
        throw new HttpResponseException(response()->json([
            "status" => "FAILED",
            'code' => 422,
            'message' => 'Validation errors',
            'data' => $this->formatErrors($validator) //$error
        ], 422));
    }
}