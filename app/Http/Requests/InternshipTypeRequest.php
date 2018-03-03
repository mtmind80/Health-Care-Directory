<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class InternshipTypeRequest extends Request
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

        if ($this->isMethod('post')) {                                                  // creating new internship_types
            $rules['name'] = 'required|plainText|unique:internship_types';
        } else if ($this->isMethod('patch')) {                                          // updating internship_types
            $rules['name'] = 'required|plainText|unique:internship_types,name,' . $this->get('id');
        }

        return $rules;
    }

}