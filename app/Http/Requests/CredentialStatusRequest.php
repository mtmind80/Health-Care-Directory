<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CredentialstatusRequest extends Request
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

        if ($this->isMethod('post')) {                                                      // creating new credentialstatus
            $rules['name'] = 'required|plainText|unique:credential_status';
        } else if ($this->isMethod('patch')) {                                              // updating credentialstatus
            $rules['name'] = 'required|plainText|unique:credential_status,name,' . $this->get('id');
        }

        return $rules;
    }

}