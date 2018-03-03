<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProviderSubtypeRequest extends Request
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
            'provider_type_id' => 'required|positive',
        ];

        if ($this->isMethod('post')) {                                                  // creating new provider subtype
            $rules['name'] = 'required|plainText|unique:provider_subtypes';
        } else if ($this->isMethod('patch')) {                                          // updating provider subtype
            $rules['name'] = 'required|plainText|unique:provider_subtypes,name,' . $this->get('id');
        }

        return $rules;
    }

}