<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class SchoolRequest extends Request
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
            'address'      => 'required|plainText',
            'city'         => 'required|plainText',
            'state_id'     => 'required|positive',
            'country_id'   => 'required|positive',
            'address_2'    => 'plainText',
            'zipcode'      => 'plainText',
            'email'        => 'email',
            'phone'        => 'phone',
            'fax'          => 'phone',
            'contact_name' => 'plainText',
            'disabled'     => 'boolean',
        ];

        if ($this->isMethod('post')) {                                                      // creating new school
            $rules['name'] = 'required|plainText|unique:schools';
        } else if ($this->isMethod('patch')) {                                              // updating school
            $rules['name'] = 'required|plainText|unique:schools,name,' . $this->get('id');
        }

        return $rules;
    }

}