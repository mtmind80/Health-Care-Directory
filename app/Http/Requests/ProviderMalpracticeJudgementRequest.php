<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProviderMalpracticeJudgementRequest extends Request
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
            'malpractice_id'  => 'required|positive',
            'offense_type_id' => 'required|positive',
            'plaintiff_name'  => 'plainText',
            'settled_amount'  => 'currency',
            'defendant'       => 'boolean',
            'dismissed'       => 'boolean',
            'primary_sourced' => 'boolean',
            'occurred_at'     => 'required|usDate',
            'reported_at'     => 'required|usDate',
            'settled_at'      => 'usDate',
        ];

        return $rules;
    }

}