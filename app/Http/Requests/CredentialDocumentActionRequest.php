<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CredentialDocumentActionRequest extends Request
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
            'document_id' => 'required|positive',
            'user_id'     => 'positive',
            'comment'     => 'text',
        ];

        if ($this->isMethod('post')) {                                                      // adding new document type
            $rules['action_type_id'] = 'required|positive|unique:credential_document_actions';
        } else if ($this->isMethod('patch')) {                                              // updating document type
            $rules['action_type_id'] = 'required|positive|unique:credential_document_actions,action_type_id,' . $this->get('id');
        }

        return $rules;
    }

}