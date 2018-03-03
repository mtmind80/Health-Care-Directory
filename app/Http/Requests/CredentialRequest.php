<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CredentialRequest extends Request
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
            'customer_id'     => 'required|positive',
            'professional_id' => 'required|positive',
            'status_id'       => 'required|positive',
            'assigned_to_id'  => 'required|positive',
            'opened_at'       => 'usDate',
            'completed_at'    => 'usDate',

        ];

        return $rules;
    }

}