<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ConditionRequest extends Request
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

        if ($this->isMethod('post')) {                                                      // creating new condition
            $rules['name'] = 'required|plainText|unique:conditions';
        } else if ($this->isMethod('patch')) {                                              // updating condition
            $rules['name'] = 'required|plainText|unique:conditions,name,' . $this->get('id');
        }

        return $rules;
    }

}