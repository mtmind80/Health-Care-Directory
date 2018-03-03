<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProfessionalIdentificationRequest extends Request
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
            'professional_id'   => 'required|positive',
            'identification_id' => 'required|positive',
            'value'             => 'required|plainText',
            'expired_at'        => 'usDate',
        ];

        return $rules;
    }

}