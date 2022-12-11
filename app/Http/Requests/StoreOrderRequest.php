<?php

namespace App\Http\Requests;

use App\Http\Resources\ErrorValidateResource;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class StoreOrderRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'number'=> 'required',
            'project'=> 'nullable|max:200',
            'material'=> 'nullable|max:100',
            'count' => 'required',
            'unit' => 'required|max:50',
            'pdf_file' => 'nullable|mimes:png,jpg,jpeg,csv,txt,xlx,xls,pdf|max:8048',
            'dxf_file' => 'nullable|max:4048',
            //'done_count'=> 'nullable',
            //'shipped_count'=> 'nullable',
            //'archived',
            //'status',
            'finishing'=> 'nullable|max:100',
            //'finish_date'=> 'nullable',
            'order_date'=> 'nullable',
            //'start_date'=> 'nullable',
            //'notes'=> 'nullable|max:500',
            //'problems'=> 'nullable|max:500',
            'user_id' => 'nullable',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
           response()->json(
               [
                'success' => false , 'validate' => true,'data'=> $errors
               ],422
           )
        );

        parent::failedValidation($validator);
    }
}
