<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\ProviderSubtype;
use App\Http\Requests\ProviderSubtypeRequest;

use EquationTrait;

class ProviderSubtypesController extends CommonController
{
    use EquationTrait;

    public function index(Request $request, $provider_type_id)
    {
        if ($this->authUserCannot('list-providersubtype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $providerSubtypes = ProviderSubtype::sortable()->providerType($provider_type_id)->paginate($perPage);

        $data = [
            'encToken'         => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'providerSubtypes' => $providerSubtypes,
            'needle'           => null,
            'provider_type_id' => $provider_type_id,
            'providerTypeName' => \App\ProviderType::find($provider_type_id)->name,
            'seo'              => [
                'pageTitle' => 'Provider Subtypes',
            ],
        ];

        return view('providertype.providersubtype.index', $data);
    }

    public function search(Request $request, $provider_type_id)
    {
        if ($this->authUserCannot('search-providersubtype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $providerSubtypes = ProviderSubtype::search($needle)->providerType($provider_type_id)->sortable()->paginate($perPage);
        $data = [
            'encToken'         => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'providerSubtypes' => $providerSubtypes,
            'needle'           => $needle,
            'provider_type_id' => $provider_type_id,
            'providerTypeName' => \App\ProviderType::find($provider_type_id)->name,
            'seo'              => [
                'pageTitle' => 'Provider Subtypes',
            ],
        ];

        return view('providertype.providersubtype.index', $data);
    }

    public function create($provider_type_id)
    {
        if ($this->authUserCannot('create-providersubtype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken'         => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation'         => $this->equation(),
            'provider_type_id' => $provider_type_id,
            'providerTypeName' => \App\ProviderType::find($provider_type_id)->name,
            'seo'              => [
                'pageTitle' => 'Create State',
            ],
        ];

        return view('providertype.providersubtype.create', $data);
    }

    public function store(ProviderSubtypeRequest $request)
    {
        if ($this->authUserCannot('create-providersubtype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        ProviderSubtype::create($inputs);

        return redirect()->route('provider_subtype_list_path', ['provider_type_id' => $inputs['provider_type_id']])->withSuccess('Provider subtype created.');
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
                $providerSubtype = ProviderSubtype::find($id);
                $providerSubtype->{$name} = $value;
                $providerSubtype->save();

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

    public function fetch(Request $request)
    {
        if ($request->isMethod('post') && $request->ajax()) {
            if (!$providerTypeId = $request->provider_type_id) {
                $response = [
                    'success'  => false,
                    'message' => 'provider_type_id is empty.',
                ];
            } else {
                if (!$providerSubtypes = ProviderSubType::providerSubtypesCB($providerTypeId)) {
                    $response = [
                        'success'  => false,
                        'message' => 'No provider subtypes found.',
                    ];
                } else {
                    $response = [
                        'success'  => true,
                        'data'   => $providerSubtypes,
                    ];
                }
            }
        } else {
            $response = [
                'success'  => false,
                'message' => 'Invalid request.',
            ];
        }

        return json_encode($response);
    }

    public function toggleStatus($id)
    {
        if ($this->authUserCannot('update-providersubtype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $providerSubtype = ProviderSubtype::find($id);
        $providerSubtype->disabled = !$providerSubtype->disabled;
        $providerSubtype->save();

        return redirect()->back()->withSuccess('Provider subtype status toggled.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-providersubtype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no provider subtype selected.');
        }
        $arrCid = explode('|', $strCid);

        ProviderSubtype::destroy($arrCid);

        return redirect()->route('provider_subtype_list_path', ['provider_type_id' => $request->input('provider_type_id')])->withSuccess('Provider subtype deleted.');
    }

}
