<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Credential;
use App\Http\Requests\CredentialRequest;

use EquationTrait;

class CredentialsController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-credential')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $credentials = Credential::sortable()->paginate($perPage);

        $data = [
            'encToken'    => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'credentials' => $credentials,
            'needle'      => null,
            'seo'         => [
                'pageTitle' => 'Credentials',
            ],
        ];

        return view('credential.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-credential')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $credentials = Credential::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken'    => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'credentials' => $credentials,
            'needle'      => $needle,
            'seo'         => [
                'pageTitle' => 'Credentials',
            ],
        ];

        return view('credential.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-credential')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken'           => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation'           => $this->equation(),
            'customersCB'        => \App\Customer::customersCB(['0' => 'Select Customer']),
            'professionalsCB'    => \App\Professional::professionalsCB(['0' => 'Select Provider']),
            'credentialStatusCB' => \App\CredentialStatus::credentialStatusCB(['0' => 'Select Status']),
            'usersCB'            => \App\User::usersCB(['0' => 'Select Assigned To']),
            'seo'                => [
                'pageTitle' => 'Start Credential Application',
            ],
        ];

        return view('credential.create', $data);
    }

    public function store(CredentialRequest $request)
    {
        if ($this->authUserCannot('create-credential')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        $professional = \App\Professional::find($inputs['professional_id']);
        $inputs['provider_id'] = $professional->provider_id;
        $inputs['opened_at'] = date('m/d/Y');

        Credential::create($inputs);

        return redirect()->route('credential_list_path')->withSuccess('Credential created.');
    }

    public function edit(Credential $credential)
    {
        if ($this->authUserCannot('update-credential')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken'           => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'credential'         => $credential,
            'equation'           => $this->equation(),
            'customersCB'        => \App\Customer::customersCB(),
            'professionalsCB'    => \App\Professional::professionalsCB(),
            'credentialStatusCB' => \App\CredentialStatus::credentialStatusCB(),
            'usersCB'            => \App\User::usersCB(),
            'seo'                => [
                'pageTitle' => 'Edit Credential Application',
            ],
        ];

        return view('credential.edit', $data);
    }

    public function update(Credential $credential, CredentialRequest $request)
    {
        if ($this->authUserCannot('update-credential')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        $professional = \App\Professional::find($inputs['professional_id']);
        $inputs['provider_id'] = $professional->provider_id;

        $inputs['completed_at'] = ($inputs['status_id'] == 4) ? date('m/d/Y') : null;

        $credential->update($inputs);

        return redirect()->route('credential_list_path')->with('success', 'Credential updated.');
    }

    public function setAsComplete($id)
    {
        if ($this->authUserCannot('update-credential')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $credential = Credential::find($id);
        $credential->status_id = 4;
        $credential->completed_at = date('m/d/Y');
        $credential->save();

        return redirect()->back()->withSuccess('Credential set as completed.');
    }

}
