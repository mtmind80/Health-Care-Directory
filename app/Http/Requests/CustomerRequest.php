<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CustomerRequest extends Request
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
        $rules = [];

        if ($this->isMethod('post')) {                                                      // creating new customer
            $rules['name'] = 'required|plainText|unique:customers';
        } else if ($this->isMethod('patch')) {                                              // updating customer
            $rules['name'] = 'required|plainText|unique:customers,name,' . $this->get('id');
        }

        return $rules;
    }

}