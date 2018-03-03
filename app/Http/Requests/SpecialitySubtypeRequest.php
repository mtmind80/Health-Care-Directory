<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class SpecialitysubtypeRequest extends Request
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
            'speciality_type_id' => 'required|positive',
            'name'               => 'required|plainText',
            'code'               => 'required|code',
        ];

        return $rules;
    }

}