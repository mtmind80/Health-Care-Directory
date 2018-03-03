<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProviderMalpracticeRequest extends Request
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
            'provider_id'     => 'required|positive',
            'insurer_id'      => 'required|positive',
            'policy_type_id'  => 'required|positive',
            'policy_number'   => 'required|plainText',
            'per_occurance'   => 'plainText',
            'in_aggregate'    => 'plainText',
            'insurance_proof' => 'boolean',
            'primary_sourced' => 'boolean',
            'retroactive_at'  => 'usDate',
            'started_at'      => 'usDate',
            'expired_at'      => 'usDate',
        ];

        return $rules;
    }

}