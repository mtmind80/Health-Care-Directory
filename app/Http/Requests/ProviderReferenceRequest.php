<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProviderReferenceRequest extends Request
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
            'provider_id' => 'required|positive',
            'name'        => 'required|personName',
            'title'       => 'required|plainText',
            'address'     => 'required|address',
            'address_2'   => 'address',
            'city'        => 'required|location',
            'state_id'    => 'required|positive',
            'country_id'  => 'required|positive',
            'zipcode'     => 'required|plainText',
            'email'       => 'required|email',
            'phone'       => 'required|phone',
            'fax'         => 'phone',
            'known_at'    => 'usDate',
            'comment'     => 'plainText',
        ];

        return $rules;
    }

}