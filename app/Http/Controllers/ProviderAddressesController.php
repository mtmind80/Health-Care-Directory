<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\ProviderAddress;
use App\Http\Requests\ProviderAddressRequest;

use ProviderAddressObserver;

use EquationTrait;

class ProviderAddressesController extends CommonController
{
    use EquationTrait;

    public function __construct()
    {
        parent::__construct();

        ProviderAddress::observe(new ProviderAddressObserver);
    }

    public function index(Request $request, $provider_id)
    {
        if ($this->authUserCannot('list-provider-address')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $addresses = ProviderAddress::active()->sortable()->provider($provider_id)->paginate($perPage);

        $provider = \App\Provider::find($provider_id);

        $data = [
            'encToken'        => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'addresses'       => $addresses,
            'needle'          => null,
            'provider_id'     => $provider_id,
            'providerName'    => $provider->name,
            'professional_id' => $provider->isProfessional ? $provider->professional->id : null,
            'seo'             => [
                'pageTitle' => 'Provider Addresses',
            ],
        ];

        return view('provider.address.index', $data);
    }

    public function search(Request $request, $provider_id)
    {
        if ($this->authUserCannot('search-provider-address')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $provider = \App\Provider::find($provider_id);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $addresses = ProviderAddress::active()->search($needle)->provider($provider_id)->sortable()->paginate($perPage);
        $data = [
            'encToken'        => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'addresses'       => $addresses,
            'needle'          => $needle,
            'provider_id'     => $provider_id,
            'providerName'    => $provider->name,
            'professional_id' => $provider->isProfessional ? $provider->professional->id : null,
            'seo'             => [
                'pageTitle' => 'Provider Addresses',
            ],
        ];

        return view('provider.address.index', $data);
    }

    public function create($provider_id)
    {
        if ($this->authUserCannot('create-provider-address')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $provider = \App\Provider::find($provider_id);

        $data = [
            'encToken'        => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation'        => $this->equation(),
            'provider_id'     => $provider_id,
            'providerName'    => $provider->name,
            'professional_id' => $provider->isProfessional ? $provider->professional->id : null,
            'addressTypesCB'  => \App\AddressType::addressTypesCB(['0' => 'Select address type']),
            'statesCB'        => [],
            'countriesCB'     => \App\Country::countriesCB(['0' => 'Select country']),
            'seo'             => [
                'pageTitle' => 'Add Address',
            ],
        ];

        return view('provider.address.create', $data);
    }

    public function store(ProviderAddressRequest $request)
    {
        if ($this->authUserCannot('create-provider-address')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (!empty($inputs['started_at'])) {
            $inputs['started_at'] = date('Y-m-d', strtotime($inputs['started_at']));
        }
        if (!empty($inputs['ended_at'])) {
            $inputs['ended_at'] = date('Y-m-d', strtotime($inputs['ended_at']));
        }

        ProviderAddress::create($inputs);

        return redirect()->route('provider_address_list_path', ['provider_id' => $inputs['provider_id']])->withSuccess('Address added.');
    }

    public function edit(ProviderAddress $address)
    {
        if ($this->authUserCannot('update-address')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $provider = \App\Provider::find($address->provider_id);

        $data = [
            'encToken'        => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'address'         => $address,
            'equation'        => $this->equation(),
            'provider_id'     => $address->provider_id,
            'providerName'    => $provider->name,
            'professional_id' => $provider->isProfessional ? $provider->professional->id : null,
            'addressTypesCB'  => \App\AddressType::addressTypesCB(),
            'statesCB'        => \App\State::statesCB($provider->country->id),
            'countriesCB'     => \App\Country::countriesCB(),
            'seo'             => [
                'pageTitle' => 'Update Address',
            ],
        ];

        return view('provider.address.edit', $data);
    }

    public function update(ProviderAddress $address, ProviderAddressRequest $request)
    {
        if ($this->authUserCannot('update-address')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (!empty($inputs['started_at'])) {
            $inputs['started_at'] = date('Y-m-d', strtotime($inputs['started_at']));
        }
        if (!empty($inputs['ended_at'])) {
            $inputs['ended_at'] = date('Y-m-d', strtotime($inputs['ended_at']));
        }

        $address->update($inputs);

        return redirect()->route('provider_address_list_path', ['provider_id' => $address->provider_id])->withSuccess('Address updated.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-provider-address')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no address selected.');
        }
        $arrCid = explode('|', $strCid);

        foreach ($arrCid as $id) {
            $providerAddress = ProviderAddress::find($id);
            $providerAddress->delete();
        }

        return redirect()->route('provider_address_list_path', ['provider_id' => $request->input('provider_id')])->withSuccess('Address deleted.');
    }

}
