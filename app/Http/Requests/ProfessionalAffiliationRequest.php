<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProfessionalAffiliationRequest extends Request
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
            'professional_id' => 'required|positive',
            'facility_id'     => 'required|positive',
            'comment'         => 'plainText',
            'started_at'      => 'usDate',
            'ended_at'        => 'usDate',
        ];

        return $rules;
    }

}