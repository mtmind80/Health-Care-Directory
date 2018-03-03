<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CertificationRequest extends Request
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

        if ($this->isMethod('post')) {                                                  // creating new certification
            $rules['name'] = 'required|plainText|unique:certifications';
        } else if ($this->isMethod('patch')) {                                          // updating certification
            $rules['name'] = 'required|plainText|unique:certifications,name,' . $this->get('id');
        }

        return $rules;
    }

}