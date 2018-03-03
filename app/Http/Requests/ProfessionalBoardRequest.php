<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProfessionalBoardRequest extends Request
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
            'professional_id'       => 'required|positive',
            'speciality_type_id'    => 'required|positive',
            'speciality_subtype_id' => 'required|positive',
            'body_id'               => 'required|positive',
            'certification_id'      => 'required|positive',
            'state_id'              => 'required|positive',
            'country_id'            => 'required|positive',
            'number'                => 'plainText',
            'issued_at'             => 'usDate',
            'expired_at'            => 'usDate',
        ];

        return $rules;
    }

}