<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CountryRequest extends Request
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

        if ($this->isMethod('post')) {                                                      // creating new country
            $rules['name'] = 'required|plainText|unique:countries';
            $rules['short_name'] = 'required|alpha_num|size:2|unique:countries';
        } else if ($this->isMethod('patch')) {                                              // updating country
            $rules['name'] = 'required|plainText|unique:countries,name,' . $this->get('id');
            $rules['short_name'] = 'required|alpha_num|size:2|unique:countries,short_name,' . $this->get('id');
        }

        return $rules;
    }

}