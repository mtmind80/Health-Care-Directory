<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class LanguageRequest extends Request
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

        if ($this->isMethod('post')) {                                                      // creating new exam
            $rules['name'] = 'required|plainText|unique:languages';
        } else if ($this->isMethod('patch')) {                                              // updating exam
            $rules['name'] = 'required|plainText|unique:languages,name,' . $this->get('id');
        }

        return $rules;
    }

}