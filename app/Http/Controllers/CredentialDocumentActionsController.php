<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\CredentialDocumentAction;
use App\Http\Requests\CredentialDocumentActionRequest;

use EquationTrait;

class CredentialDocumentActionsController extends CommonController
{
    use EquationTrait;

    public function index(Request $request, $document_id)
    {
        if ($this->authUserCannot('list-credential-document-action')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $credentialDocumentActions = CredentialDocumentAction::sortable()->document($document_id)->paginate($perPage);

        $credentialDocument = \App\CredentialDocument::find($document_id);

        $data = [
            'encToken'                   => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'credentialDocumentActions'  => $credentialDocumentActions,
            'needle'                     => null,
            'credential_id'              => $credentialDocument->credential_id,
            'document_id'                => $document_id,
            'credentialProfessionalName' => $credentialDocument->credential->professional->fullName,
            'credentialDocumentType'     => $credentialDocument->type->name,
            'jsonDocumentActionTypesCB'  => json_encode(\App\DocumentActionType::documentActionTypesCB()),
            'jsonUsersCB'                => json_encode(\App\User::usersCB()),
            'seo'                        => [
                'pageTitle' => 'Credential Document Actions',
            ],
        ];

        return view('credential.document.action.index', $data);
    }

    public function search(Request $request, $document_id)
    {
        if ($this->authUserCannot('search-credential-document-action')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $credentialDocument = \App\CredentialDocument::find($document_id);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $credentialDocumentActions = CredentialDocumentAction::search($needle)->credential($document_id)->sortable()->paginate($perPage);

        $data = [
            'encToken'                   => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'credentialDocumentActions'  => $credentialDocumentActions,
            'needle'                     => $needle,
            'credential_id'              => $credentialDocument->credential_id,
            'document_id'                => $document_id,
            'credentialProfessionalName' => $credentialDocument->credential->professional->fullName,
            'credentialDocumentType'     => $credentialDocument->type->name,
            'jsonDocumentActionTypesCB'  => json_encode(\App\DocumentActionType::documentActionTypesCB()),
            'jsonUsersCB'                => json_encode(\App\User::usersCB()),
            'seo'                        => [
                'pageTitle' => 'Credential Document Actions',
            ],
        ];

        return view('credential.document.action.index', $data);
    }

    public function create($document_id)
    {
        if ($this->authUserCannot('create-credential-document-action')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $credentialDocument = \App\CredentialDocument::find($document_id);

        $data = [
            'encToken'                   => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation'                   => $this->equation(),
            'credential_id'              => $credentialDocument->credential_id,
            'document_id'                => $document_id,
            'credentialProfessionalName' => $credentialDocument->credential->professional->fullName,
            'credentialDocumentType'     => $credentialDocument->type->name,
            'documentActionTypesCB'      => \App\DocumentActionType::documentActionTypesCB(['0' => 'Select action type']),
            'seo'                        => [
                'pageTitle' => 'Add Document Action',
            ],
        ];

        return view('credential.document.action.create', $data);
    }

    public function store(CredentialDocumentActionRequest $request)
    {
        if ($this->authUserCannot('create-credential-document-action')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();
        $inputs['user_id'] = \Auth::user()->id;

        CredentialDocumentAction::create($inputs);

        return redirect()->route('credential_document_action_list_path', ['document_id' => $inputs['document_id']])->withSuccess('Credential document action added.');
    }

    public function edit(CredentialDocumentAction $credentialDocumentAction)
    {
        if ($this->authUserCannot('update-credential-document-action')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $credentialDocument = \App\CredentialDocument::find($credentialDocumentAction->document_id);

        $data = [
            'encToken'                   => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'credentialDocumentAction'   => $credentialDocumentAction,
            'equation'                   => $this->equation(),
            'credential_id'              => $credentialDocument->credential_id,
            'document_id'                => $credentialDocumentAction->document_id,
            'credentialProfessionalName' => $credentialDocument->credential->professional->fullName,
            'credentialDocumentType'     => $credentialDocument->type->name,
            'documentActionTypesCB'      => \App\DocumentActionType::documentActionTypesCB(),
            'usersCB'                    => \App\User::usersCB(),
            'seo'                        => [
                'pageTitle' => 'Edit Credentialdocumentaction Application',
            ],
        ];

        return view('credential.document.action.edit', $data);
    }

    public function update(Credentialdocumentaction $credentialDocumentAction, CredentialDocumentActionRequest $request)
    {
        if ($this->authUserCannot('update-credential-document-action')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        $credentialDocumentAction->update($inputs);

        return redirect()->route('credential_document_action_list_path', ['document_id' => $credentialDocumentAction->document_id])->with('success', 'Credentialdocumentaction updated.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-credential-document-action')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no document action selected.');
        }
        $arrCid = explode('|', $strCid);

        CredentialDocumentAction::destroy($arrCid);

        return redirect()->route('credential_document_action_list_path', ['document_id' => $request->input('document_id')])->withSuccess('Document action deleted.');
    }

}
