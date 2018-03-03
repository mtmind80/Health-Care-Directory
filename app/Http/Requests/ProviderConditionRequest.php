<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProviderConditionRequest extends Request
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
            'provider_id'  => 'required|positive',
            'condition_id' => 'required|positive',
            'comment'      => 'required|plainText',
        ];

        return $rules;
    }

}