<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class StateRequest extends Request
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
            'country_id' => 'required|positive',
        ];

        if ($this->isMethod('post')) {                                                      // creating new state
            $rules['short_name'] = 'required|alpha_num|size:2|unique:states';
            $rules['name'] = 'required|plainText|unique:states';
        } else if ($this->isMethod('patch')) {                                              // updating state
            $rules['short_name'] = 'required|alpha_num|size:2|unique:states,short_name,' . $this->get('id');
            $rules['name'] = 'required|plainText|unique:states,name,' . $this->get('id');
        }

        return $rules;
    }

}