<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\PolicyType;
use App\Http\Requests\PolicyTypeRequest;

use EquationTrait;

class PolicyTypesController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-policy-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $policyTypes = PolicyType::sortable()->paginate($perPage);

        $data = [
            'encToken'      => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'policyTypes' => $policyTypes,
            'needle'        => null,
            'seo'           => [
                'pageTitle' => 'Policy Types',
            ],
        ];

        return view('policytype.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-policy-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $policyTypes = PolicyType::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken'      => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'policyTypes' => $policyTypes,
            'needle'        => $needle,
            'seo'           => [
                'pageTitle' => 'Policy Types',
            ],
        ];

        return view('policytype.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-policy-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation' => $this->equation(),
            'seo'      => [
                'pageTitle' => 'Create Policy Type',
            ],
        ];

        return view('policytype.create', $data);
    }

    public function store(PolicyTypeRequest $request)
    {
        if ($this->authUserCannot('create-policy-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        PolicyType::create($inputs);

        return redirect()->route('policy_type_list_path')->withSuccess('Policy type created.');
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
                $policyType = PolicyType::find($id);
                $policyType->{$name} = $value;
                $policyType->save();

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
        if ($this->authUserCannot('update-policy-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $policyType = PolicyType::find($id);
        $policyType->disabled = !$policyType->disabled;
        $policyType->save();

        return redirect()->back()->withSuccess('Policy type status toggled.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-policy-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no policy type selected.');
        }
        $arrCid = explode('|', $strCid);

        PolicyType::destroy($arrCid);

        return redirect()->route('policy_type_list_path')->withSuccess('Policy type deleted.');
    }

}
