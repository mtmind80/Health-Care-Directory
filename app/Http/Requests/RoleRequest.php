<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

use RuacTrait;

class RoleRequest extends Request
{
    use RuacTrait;

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

        if ($this->isMethod('post')) {                        // creating new role
            $rules['role_name'] = 'required|lower|unique:roles';

        } else if ($this->isMethod('patch')) {                // updating  role
            if ($this->input('role_name') == 'root' && $this->authUserIs('root')) {
                // skip to allow root to update its own role, due to parent_id is null
            } else {
                $rules['role_name'] = 'required|lower|unique:roles,role_name,' . $this->get('id');
            }
        }

        return $rules;
    }

}