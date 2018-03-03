<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProviderRequest extends Request
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
        /** custom conditional validation rules for non common fields are defined and checked in store and update functions */

        $rules = [
            'provider_type_id'    => 'required|positive',
            'provider_subtype_id' => 'required|positive',
            'address'             => 'required|plainText',
            'city'                => 'required|plainText',
            'state_id'            => 'required|positive',
            'country_id'          => 'required|positive',
            'address_2'           => 'plainText',
            'zipcode'             => 'plainText',
            'email'               => 'email',
            'phone'               => 'phone',
            'fax'                 => 'phone',
            'under_contract'      => 'boolean',
            'deleted_at'          => 'boolean',
        ];

        return $rules;
    }

}