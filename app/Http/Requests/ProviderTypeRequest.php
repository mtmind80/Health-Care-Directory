<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProviderTypeRequest extends Request
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

        if ($this->isMethod('post')) {                                                  // creating new providertype
            $rules['name'] = 'required|plainText|unique:provider_types';
        } else if ($this->isMethod('patch')) {                                          // updating providertype
            $rules['name'] = 'required|plainText|unique:provider_types,name,' . $this->get('id');
        }

        return $rules;
    }

}