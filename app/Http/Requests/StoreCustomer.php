<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomer extends FormRequest
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
        //return [];
        return [
            'salutation' => 'required',
            'firstName' => 'required',
            'middleName' => '',
            'lastName' => 'required',
            'mainGroup' => 'required',
            'customerLevel' => 'required',
            'agent' => 'required',
            'customerType' => 'required',
            'addressLine1' => 'required',
            //'addressLine2' => 'required',
            'city' => 'required',
            'email' => 'required',
            'contactNumber' => 'required',
            'country' => 'required',
        ];

    }
}
