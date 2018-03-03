<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\ProviderReference;
use App\Http\Requests\ProviderReferenceRequest;

use ProviderReferenceObserver;

use EquationTrait;

class ProviderReferencesController extends CommonController
{
    use EquationTrait;

    public function __construct()
    {
        parent::__construct();

        ProviderReference::observe(new ProviderReferenceObserver);
    }

    public function index(Request $request, $provider_id)
    {
        if ($this->authUserCannot('list-provider-reference')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $references = ProviderReference::active()->sortable()->provider($provider_id)->paginate($perPage);

        $provider = \App\Provider::find($provider_id);

        $data = [
            'encToken'        => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'references'      => $references,
            'needle'          => null,
            'provider_id'     => $provider_id,
            'providerName'    => $provider->name,
            'professional_id' => $provider->isProfessional ? $provider->professional->id : null,
            'seo'             => [
                'pageTitle' => 'Provider References',
            ],
        ];

        return view('provider.reference.index', $data);
    }

    public function search(Request $request, $provider_id)
    {
        if ($this->authUserCannot('search-provider-reference')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $provider = \App\Provider::find($provider_id);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $references = ProviderReference::active()->search($needle)->provider($provider_id)->sortable()->paginate($perPage);
        $data = [
            'encToken'        => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'references'      => $references,
            'needle'          => $needle,
            'provider_id'     => $provider_id,
            'providerName'    => $provider->name,
            'professional_id' => $provider->isProfessional ? $provider->professional->id : null,
            'seo'             => [
                'pageTitle' => 'Provider References',
            ],
        ];

        return view('provider.reference.index', $data);
    }

    public function create($provider_id)
    {
        if ($this->authUserCannot('create-provider-reference')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $provider = \App\Provider::find($provider_id);

        $data = [
            'encToken'        => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation'        => $this->equation(),
            'provider_id'     => $provider_id,
            'providerName'    => $provider->name,
            'professional_id' => $provider->isProfessional ? $provider->professional->id : null,
            'statesCB'        => [],
            'countriesCB'     => \App\Country::countriesCB(['0' => 'Select country']),
            'seo'             => [
                'pageTitle' => 'Add Reference',
            ],
        ];

        return view('provider.reference.create', $data);
    }

    public function store(ProviderReferenceRequest $request)
    {
        if ($this->authUserCannot('create-provider-reference')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (!empty($inputs['known_at'])) {
            $inputs['known_at'] = date('Y-m-d', strtotime($inputs['known_at']));
        }

        ProviderReference::create($inputs);

        return redirect()->route('provider_reference_list_path', ['provider_id' => $inputs['provider_id']])->withSuccess('Reference added.');
    }

    public function edit(ProviderReference $reference)
    {
        if ($this->authUserCannot('update-reference')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $provider = \App\Provider::find($reference->provider_id);

        $data = [
            'encToken'        => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'reference'       => $reference,
            'equation'        => $this->equation(),
            'provider_id'     => $reference->provider_id,
            'providerName'    => $provider->name,
            'professional_id' => $provider->isProfessional ? $provider->professional->id : null,
            'statesCB'        => \App\State::statesCB($provider->country->id),
            'countriesCB'     => \App\Country::countriesCB(),
            'seo'             => [
                'pageTitle' => 'Update Reference',
            ],
        ];

        return view('provider.reference.edit', $data);
    }

    public function update(ProviderReference $reference, ProviderReferenceRequest $request)
    {
        if ($this->authUserCannot('update-reference')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (!empty($inputs['known_at'])) {
            $inputs['known_at'] = date('Y-m-d', strtotime($inputs['known_at']));
        }

        $reference->update($inputs);

        return redirect()->route('provider_reference_list_path', ['provider_id' => $reference->provider_id])->withSuccess('Reference updated.');
    }

    public function inlineUpdate(Request $request)
    {
        if ($request->isMethod('post') && $request->ajax()) {
            $input = $request->all();

            $id = $input['pk'];
            $name = $input['name'];
            $value = $input['value'];
            $rule = (isset($input['rule'])) ? $input['rule'] : 'text';

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
                $ProviderType = ProviderReference::find($id);
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

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-provider-reference')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no reference selected.');
        }
        $arrCid = explode('|', $strCid);

        foreach ($arrCid as $id) {
            $providerReference = ProviderReference::find($id);
            $providerReference->delete();
        }

        return redirect()->route('provider_reference_list_path', ['provider_id' => $request->input('provider_id')])->withSuccess('Reference deleted.');
    }

}
