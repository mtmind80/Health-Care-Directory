<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class DegreeRequest extends Request
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

        if ($this->isMethod('post')) {                                                      // creating new degree
            $rules['short_name'] = 'required|plainText|unique:degrees';
            $rules['full_name'] = 'required|plainText|unique:degrees';
        } else if ($this->isMethod('patch')) {                                              // updating degree
            $rules['short_name'] = 'required|plainText|unique:degrees,short_name,' . $this->get('id');
            $rules['full_name'] = 'required|plainText|unique:degrees,full_name,' . $this->get('id');
        }

        return $rules;
    }

}