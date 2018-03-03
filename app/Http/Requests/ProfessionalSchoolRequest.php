<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProfessionalSchoolRequest extends Request
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
            'school_id'       => 'required|positive',
            'degree_id'       => 'required|positive',
            'comment'         => 'text',
            'started_at'      => 'usDate',
            'ended_at'        => 'usDate',
        ];

        return $rules;
    }

}