<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class SearchRequest extends Request
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

    public function rules()
    {
        $rules = [
            'needle' => 'required|text|min:3',
        ];

        return $rules;
    }

}
