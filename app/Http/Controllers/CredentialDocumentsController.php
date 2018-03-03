<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\CredentialDocument;
use App\Http\Requests\CredentialDocumentRequest;

use EquationTrait;

class CredentialDocumentsController extends CommonController
{
    use EquationTrait;

    public function index(Request $request, $credential_id)
    {
        if ($this->authUserCannot('list-credential-document')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $credentialDocuments = CredentialDocument::sortable()->credential($credential_id)->paginate($perPage);

        $credential = \App\Credential::find($credential_id);

        $data = [
            'encToken'                   => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'credentialDocuments'        => $credentialDocuments,
            'needle'                     => null,
            'credential_id'              => $credential_id,
            'credentialProfessionalName' => $credential->professional->fullName,
            'jsonDocumentTypesCB'        => json_encode(\App\DocumentType::documentTypesCB()),
            'seo'                        => [
                'pageTitle' => 'Credential Documents',
            ],
        ];

        return view('credential.document.index', $data);
    }

    public function search(Request $request, $credential_id)
    {
        if ($this->authUserCannot('search-credential-document')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $credential = \App\Credential::find($credential_id);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $credentialDocuments = CredentialDocument::search($needle)->credential($credential_id)->sortable()->paginate($perPage);

        $data = [
            'encToken'                   => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'credentialDocuments'        => $credentialDocuments,
            'needle'                     => $needle,
            'credential_id'              => $credential_id,
            'credentialProfessionalName' => $credential->professional->fullName,
            'jsonDocumentTypesCB'        => json_encode(\App\DocumentType::documentTypesCB()),
            'seo'                        => [
                'pageTitle' => 'Credential Documents',
            ],
        ];

        return view('credential.document.index', $data);
    }

    public function create($credential_id)
    {
        if ($this->authUserCannot('create-credential-document')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $credential = \App\Credential::find($credential_id);

        $data = [
            'encToken'                   => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation'                   => $this->equation(),
            'credential_id'              => $credential_id,
            'credentialProfessionalName' => $credential->professional->fullName,
            'documentTypesCB'            => \App\DocumentType::documentTypesCB(['0' => 'Select document type']),
            'seo'                        => [
                'pageTitle' => 'Add Document',
            ],
        ];

        return view('credential.document.create', $data);
    }

    public function store(CredentialDocumentRequest $request)
    {
        if ($this->authUserCannot('create-credential-document')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        CredentialDocument::create($inputs);

        return redirect()->route('credential_document_list_path', ['credential_id' => $inputs['credential_id']])->withSuccess('Credential document added.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-credential-document')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no credential document selected.');
        }
        $arrCid = explode('|', $strCid);

        CredentialDocument::destroy($arrCid);

        return redirect()->route('credential_document_list_path', ['credential_id' => $request->input('credential_id')])->withSuccess('Credential document deleted.');
    }

}
