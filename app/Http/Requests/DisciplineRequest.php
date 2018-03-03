<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class DisciplineRequest extends Request
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

        if ($this->isMethod('post')) {                                                      // creating new discipline
            $rules['name'] = 'required|plainText|unique:disciplines';
        } else if ($this->isMethod('patch')) {                                              // updating discipline
            $rules['name'] = 'required|plainText|unique:disciplines,name,' . $this->get('id');
        }

        return $rules;
    }

}