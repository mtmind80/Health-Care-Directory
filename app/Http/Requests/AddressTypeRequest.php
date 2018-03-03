<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddressTypeRequest extends Request
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
        $rules = [
            'code' => 'required|code',
        ];

        if ($this->isMethod('post')) {                                                    // creating new address_types
            $rules['name'] = 'required|plainText|unique:address_types';
        } else if ($this->isMethod('patch')) {                                            // updating address_types
            $rules['name'] = 'required|plainText|unique:address_types,name,' . $this->get('id');
        }

        return $rules;
    }

}