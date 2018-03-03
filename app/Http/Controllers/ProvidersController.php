<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Provider;
use ProviderObserver;
use App\Http\Requests\ProviderRequest;

use App\Professional;
use ProfessionalObserver;

use App\Facility;
use FacilityObserver;

use EquationTrait, ArrayTrait;

class ProvidersController extends CommonController
{
    use EquationTrait, ArrayTrait;

    public function __construct()
    {
        parent::__construct();

        Provider::observe(new ProviderObserver);
        Professional::observe(new ProfessionalObserver);
        Facility::observe(new FacilityObserver);
    }

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-provider')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;

        $city = $request->input('city');
        $zipcode = $request->input('zipcode');
        $country_id = $request->input('country_id');
        $state_id = $request->input('state_id');
        $provider_type_id = $request->input('provider_type_id');
        $provider_subtype_id = $request->input('provider_subtype_id');
        $condition_id = $request->input('condition_id');
        $procedure_id = $request->input('procedure_id');

        $providers = Provider::sortable()->active()
            ->locationFilter($city, $zipcode, $state_id, $country_id)
            ->providerTypeFilter($provider_type_id, $provider_subtype_id)
            ->conditionFilter($condition_id)
            ->procedureFilter($procedure_id)
            ->paginate($perPage);

        $data = [
            'encToken'            => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'providers'           => $providers,
            'needle'              => null,
            'advanceSearch'       => true,
            'countriesCB'         => \App\Country::countriesCB(['0' => '&nbsp;']),
            'statesCB'            => \App\State::statesCB($country_id, ['0' => '&nbsp;']),
            'providerTypesCB'     => \App\ProviderType::providerTypesCB(['0' => '&nbsp;']),
            'providerSubtypesCB'  => \App\ProviderSubtype::providerSubtypesCB($provider_type_id, ['0' => '&nbsp;']),
            'conditionsCB'        => \App\Condition::conditionsCB(['0' => '&nbsp;']),
            'proceduresCB'        => \App\Procedure::proceduresCB(['0' => '&nbsp;']),
            'city'                => $city,
            'zipcode'             => $zipcode,
            'country_id'          => $country_id,
            'state_id'            => $state_id,
            'provider_type_id'    => $provider_type_id,
            'provider_subtype_id' => $provider_subtype_id,
            'condition_id'        => $condition_id,
            'procedure_id'        => $procedure_id,
            'seo'                 => [
                'pageTitle' => 'Providers',
            ],
        ];

        return view('provider.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-provider')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;

        $city = $request->input('city');
        $zipcode = $request->input('zipcode');
        $country_id = $request->input('country_id');
        $state_id = $request->input('state_id');
        $provider_type_id = $request->input('provider_type_id');
        $provider_subtype_id = $request->input('provider_subtype_id');
        $condition_id = $request->input('condition_id');
        $procedure_id = $request->input('procedure_id');

        $providers = Provider::search($needle)->sortable()->active()
            ->locationFilter($city, $zipcode, $state_id, $country_id)
            ->providerTypeFilter($provider_type_id, $provider_subtype_id)
            ->conditionFilter($condition_id)
            ->procedureFilter($procedure_id)
            ->paginate($perPage);

        $data = [
            'encToken'            => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'providers'           => $providers,
            'needle'              => $needle,
            'advanceSearch'       => true,
            'countriesCB'         => \App\Country::countriesCB(['0' => '&nbsp;']),
            'statesCB'            => \App\State::statesCB($country_id, ['0' => '&nbsp;']),
            'providerTypesCB'     => \App\ProviderType::providerTypesCB(['0' => '&nbsp;']),
            'providerSubtypesCB'  => \App\ProviderSubtype::providerSubtypesCB($provider_type_id, ['0' => '&nbsp;']),
            'conditionsCB'        => \App\Condition::conditionsCB(['0' => '&nbsp;']),
            'proceduresCB'        => \App\Procedure::proceduresCB(['0' => '&nbsp;']),
            'city'                => $city,
            'zipcode'             => $zipcode,
            'country_id'          => $country_id,
            'state_id'            => $state_id,
            'provider_type_id'    => $provider_type_id,
            'provider_subtype_id' => $provider_subtype_id,
            'condition_id'        => $condition_id,
            'procedure_id'        => $procedure_id,
            'seo'                 => [
                'pageTitle' => 'Providers',
            ],
        ];

        return view('provider.index', $data);
    }

    public function show(Provider $provider)
    {
        if ($this->authUserCannot('show-provider')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'provider' => $provider,
            'seo'      => [
                'pageTitle' => 'Provider Profile',
            ],
        ];

        return view('provider.profile', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-provider')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken'           => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation'           => $this->equation(),
            'countriesCB'        => \App\Country::countriesCB(['0' => 'Select Country']),
            'statesCB'           => [],
            'providerTypesCB'    => \App\ProviderType::providerTypesCB(['0' => 'Select Type']),
            'providerSubtypesCB' => [],
            'seo'                => [
                'pageTitle' => 'Create Provider',
            ],
        ];

        return view('provider.create', $data);
    }

    public function store(ProviderRequest $request)
    {
        if ($this->authUserCannot('create-provider')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $validator = \Validator::make(
            [
                'provider_type_id' => $request->provider_type_id,
                'name'             => $request->name,
                'first_name'       => $request->first_name,
                'last_name'        => $request->last_name,

            ],
            [
                'provider_type_id' => 'required|positive',
                'name'             => 'plainText',
                'first_name'       => 'personName',
                'last_name'        => 'personName',
            ]);

        $validator->sometimes('name', 'required', function ($input) {
            return $input->provider_type_id != 1;
        });

        $validator->sometimes('first_name', 'required', function ($input) {
            return $input->provider_type_id == 1;
        });
        $validator->sometimes('last_name', 'required', function ($input) {
            return $input->provider_type_id == 1;
        });

        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $error) {
                $messages[] = $error;
            }

            return redirect()->back()->withError(implode(', ', $messages));
        }

        $inputs = $request->all();

        $provider = Provider::create($inputs);

        $inputs['provider_id'] = $provider->id;

        if ($request->provider_type_id == 1) {
            if (!empty($inputs['date_of_birth'])) {
                $inputs['date_of_birth'] = date('Y-m-d', strtotime($inputs['date_of_birth']));
            }

            Professional::create($inputs);
        } else {
            Facility::create($inputs);
        }

        return redirect()->route('provider_list_path')->withSuccess('Provider created.');
    }

    public function edit(Provider $provider)
    {
        if ($this->authUserCannot('update-provider')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken'           => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'provider'           => $provider,
            'equation'           => $this->equation(),
            'countriesCB'        => \App\Country::countriesCB(),
            'statesCB'           => \App\State::statesCB($provider->state->country->id),
            'providerTypesCB'    => \App\ProviderType::providerTypesCB(),
            'providerSubtypesCB' => \App\ProviderSubtype::providerSubtypesCB($provider->subType->provider_type_id),
            'seo'                => [
                'pageTitle' => 'Edit: ' . $provider->name,
            ],
        ];

        return view('provider.edit', $data);
    }

    public function update(Provider $provider, ProviderRequest $request)
    {
        if ($this->authUserCannot('update-provider')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $validator = \Validator::make(
            [
                'provider_type_id' => $request->provider_type_id,
                'name'             => $request->name,
                'first_name'       => $request->first_name,
                'last_name'        => $request->last_name,

            ],
            [
                'provider_type_id' => 'required|positive',
                'name'             => 'plainText',
                'first_name'       => 'personName',
                'last_name'        => 'personName',
            ]);

        $validator->sometimes('name', 'required', function ($input) {
            return $input->provider_type_id != 1;
        });

        $validator->sometimes('first_name', 'required', function ($input) {
            return $input->provider_type_id == 1;
        });
        $validator->sometimes('last_name', 'required', function ($input) {
            return $input->provider_type_id == 1;
        });

        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $error) {
                $messages[] = $error;
            }

            return redirect()->back()->withError(implode(', ', $messages));
        }

        $inputs = $request->all();

        if (empty($inputs['deleted_at'])) {
            $inputs['deleted_at'] = null;
        }
        if (empty($inputs['under_contract'])) {
            $inputs['under_contract'] = false;
        }

        $provider->update($inputs);

        if ($provider->isProfessional) {
            if ($professionalInputs = $this->arrayIntersectInKeys($inputs, $provider->professional->ownFillable())) {
                if (!empty($inputs['date_of_birth'])) {
                    $inputs['date_of_birth'] = date('Y-m-d', strtotime($inputs['date_of_birth']));
                }

                $professional = Professional::where('provider_id', $provider->id)->first();
                $professional->update($professionalInputs);
            }
        } else {
            if ($facilityInputs = $this->arrayIntersectInKeys($inputs, $provider->facility->ownFillable())) {
                $facility = Facility::where('provider_id', $provider->id)->first();

                $facility->update($facilityInputs);
            }
        }

        return redirect()->route('provider_list_path')->with('success', 'Provider updated.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-provider')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no provider selected.');
        }
        $arrCid = explode('|', $strCid);

        foreach ($arrCid as $id) {
            $provider = Provider::find($id);
            if ($provider->isProfessional) {
                $provider->professional()->delete();
            } else {
                $provider->facility()->delete();
            }
            $provider->delete();
        }

        return redirect()->route('provider_list_path')->withSuccess('Provider deleted.');
    }

    protected function exportToExcel(Request $request)
    {
        $this->export('excel', $request);

        exit();
    }

    protected function exportToPdf(Request $request)
    {
        $this->export('pdf', $request);

        exit();
    }

    protected function export($format, $request)
    {
        if ($this->authUserCannot('export-provider')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        if (!in_array($format, ['excel', 'pdf'])) {
            return redirect()->back()->withError('Unknown format.');
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $providers = Provider::sortable()->active()->paginate($perPage);

        $data = [];
        foreach ($providers as $provider) {
            $data[] = [
                'Name'     => $provider->isProfessional ? $provider->professional->fullName : $provider->facility->name,
                'Type'     => $provider->type->name,
                'Sub Type' => $provider->subType->name,
                'Address'  => $provider->address,
                'City'     => $provider->city,
                'State'    => $provider->state->full_name,
                'Zipcode'  => $provider->zipcode,
                'Country'  => $provider->country->name,
                'Phone'    => $provider->phone,
                'Email'    => $provider->email,
            ];
        }

        $obj = \Excel::create('providers', function ($excel) use ($data) {
            $excel->sheet('Providers', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        });

        if ($format == 'excel') {
            $obj->export('xls');
        } else {
            $obj->download('pdf');
        }

        exit();
    }

}
