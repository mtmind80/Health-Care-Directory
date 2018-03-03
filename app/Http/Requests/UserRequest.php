<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
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
            'first_name' => 'required|personName',
            'last_name'  => 'required|personName',
            'avatar'     => 'fileName',
            'disable'    => 'boolean',
        ];

        if ($this->isMethod('post')) {                                                      // creating new user
            $rules['email'] = 'required|email|unique:users';
            $rules['password'] = 'required|min:6';
        } else if ($this->isMethod('patch')) {                                              // updating user
            $rules['email'] = 'required|email|unique:users,email,' . $this->get('id');
            $rules['password'] = 'min:6';
        }

        return $rules;
    }

}
