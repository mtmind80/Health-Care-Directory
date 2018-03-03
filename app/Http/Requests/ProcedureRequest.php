<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProcedureRequest extends Request
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

        if ($this->isMethod('post')) {                                                      // creating new procedure
            $rules['name'] = 'required|plainText|unique:procedures';
        } else if ($this->isMethod('patch')) {                                              // updating procedure
            $rules['name'] = 'required|plainText|unique:procedures,name,' . $this->get('id');
        }

        return $rules;
    }

}