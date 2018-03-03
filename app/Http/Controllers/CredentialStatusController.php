<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\CredentialStatus;
use App\Http\Requests\CredentialStatusRequest;

use EquationTrait;

class CredentialStatusController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-credential-status')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $credentialStatus = CredentialStatus::sortable()->paginate($perPage);

        $data = [
            'encToken'         => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'credentialStatus' => $credentialStatus,
            'needle'           => null,
            'seo'              => [
                'pageTitle' => 'Credential Status',
            ],
        ];

        return view('credentialstatus.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-credential-status')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $credentialStatus = CredentialStatus::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken'         => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'credentialStatus' => $credentialStatus,
            'needle'           => $needle,
            'seo'              => [
                'pageTitle' => 'Credential Status',
            ],
        ];

        return view('credentialstatus.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-credential-status')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation' => $this->equation(),
            'seo'      => [
                'pageTitle' => 'Create Credential Status',
            ],
        ];

        return view('credentialstatus.create', $data);
    }

    public function store(CredentialStatusRequest $request)
    {
        if ($this->authUserCannot('create-credential-status')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        CredentialStatus::create($inputs);

        return redirect()->route('credential_status_list_path')->withSuccess('Credential status created.');
    }

    public function inlineUpdate(Request $request)
    {
        if ($request->isMethod('post') && $request->ajax()) {
            $input = $request->all();

            $id = $input['pk'];
            $name = $input['name'];
            $value = $input['value'];
            $rule = (isset($input['rule'])) ? $input['rule'] : 'text';

            /*
             * The first argument passed to the make method is the data under validation.
             * The second argument is the validation rules that should be applied to the data.
             */

            $validator = \Validator::make(
                [$name => $value],
                [$name => $rule]
            );

            if ($validator->fails()) {
                $response = [
                    'status'  => 'error',
                    'message' => $validator->messages()->first(),
                ];
            } else {
                $credentialStatus = CredentialStatus::find($id);
                $credentialStatus->{$name} = $value;
                $credentialStatus->save();

                $response = [
                    'status' => 'success',
                ];
            }
        } else {
            $response = [
                'status'  => 'error',
                'message' => 'Invalid request.',
            ];
        }

        return json_encode($response);
    }

    public function toggleStatus($id)
    {
        if ($this->authUserCannot('update-credential-status')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $credentialStatus = CredentialStatus::find($id);
        $credentialStatus->disabled = !$credentialStatus->disabled;
        $credentialStatus->save();

        return redirect()->back()->withSuccess('Credential status toggled.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-credential-status')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no credential status selected.');
        }
        $arrCid = explode('|', $strCid);

        CredentialStatus::destroy($arrCid);

        return redirect()->route('credential_status_list_path')->withSuccess('Credential status deleted.');
    }

}
