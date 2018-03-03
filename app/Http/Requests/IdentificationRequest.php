<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class IdentificationRequest extends Request
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
            'licence' => 'boolean'
        ];

        if ($this->isMethod('post')) {                                                      // creating new identification
            $rules['name'] = 'required|plainText|unique:identifications';
        } else if ($this->isMethod('patch')) {                                              // updating identification
            $rules['name'] = 'required|plainText|unique:identifications,name,' . $this->get('id');
        }

        return $rules;
    }

}