<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class BodyRequest extends Request
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

        if ($this->isMethod('post')) {                                                      // creating new body
            $rules['name'] = 'required|plainText|unique:bodies';
        } else if ($this->isMethod('patch')) {                                              // updating body
            $rules['name'] = 'required|plainText|unique:bodies,name,' . $this->get('id');
        }

        return $rules;
    }

}