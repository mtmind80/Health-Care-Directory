<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\ProviderType;
use App\Http\Requests\ProviderTypeRequest;

use EquationTrait;

class ProviderTypesController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-providertype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $providerTypes = ProviderType::sortable()->paginate($perPage);

        $data = [
            'encToken'      => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'providerTypes' => $providerTypes,
            'needle'        => null,
            'seo'           => [
                'pageTitle' => 'Provider Types',
            ],
        ];

        return view('providertype.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-providertype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $providerTypes = ProviderType::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken'      => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'providerTypes' => $providerTypes,
            'needle'        => $needle,
            'seo'           => [
                'pageTitle' => 'Provider Types',
            ],
        ];

        return view('providertype.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-providertype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation' => $this->equation(),
            'seo'      => [
                'pageTitle' => 'Create Provider Type',
            ],
        ];

        return view('providertype.create', $data);
    }

    public function store(ProviderTypeRequest $request)
    {
        if ($this->authUserCannot('create-providertype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        ProviderType::create($inputs);

        return redirect()->route('provider_type_list_path')->withSuccess('Provider type created.');
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
                $ProviderType = ProviderType::find($id);
                $ProviderType->{$name} = $value;
                $ProviderType->save();

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
        if ($this->authUserCannot('update-providertype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $ProviderType = ProviderType::find($id);
        $ProviderType->disabled = !$ProviderType->disabled;
        $ProviderType->save();

        return redirect()->back()->withSuccess('Provider type status toggled.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-providertype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no provider type selected.');
        }
        $arrCid = explode('|', $strCid);

        ProviderType::destroy($arrCid);

        return redirect()->route('provider_type_list_path')->withSuccess('Provider type deleted.');
    }

}
