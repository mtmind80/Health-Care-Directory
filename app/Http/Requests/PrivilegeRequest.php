<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class PrivilegeRequest extends Request
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

        if ($this->isMethod('post')) {                                                        // creating new privilege
            $rules['privilege_name'] = 'required|slug|unique:privileges';
        } else if ($this->isMethod('patch')) {                                                // updating privilege
            $rules['privilege_name'] = 'required|slug|unique:privileges,privilege_name,' . $this->get('id');
        }

        return $rules;
    }

}