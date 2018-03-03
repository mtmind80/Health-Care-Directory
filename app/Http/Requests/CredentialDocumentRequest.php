<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CredentialDocumentRequest extends Request
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
            'credential_id'    => 'required|positive',
        ];

        if ($this->isMethod('post')) {                                                      // adding new document type
            $rules['document_type_id'] = 'required|positive|unique:credential_documents';
        } else if ($this->isMethod('patch')) {                                              // updating document type
            $rules['document_type_id'] = 'required|positive|unique:credential_documents,document_type_id,' . $this->get('id');
        }

        return $rules;
    }

}