<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\ProviderMalpractice;
use App\Http\Requests\ProviderMalpracticeRequest;

use ProviderMalpracticeObserver;

use EquationTrait;

class ProviderMalpracticesController extends CommonController
{
    use EquationTrait;

    public function __construct()
    {
        parent::__construct();

        ProviderMalpractice::observe(new ProviderMalpracticeObserver);
    }

    public function index(Request $request, $provider_id)
    {
        if ($this->authUserCannot('list-provider-malpractice')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $providerMalpractices = ProviderMalpractice::sortable()->provider($provider_id)->paginate($perPage);

        $provider = \App\Provider::find($provider_id);

        $data = [
            'encToken'             => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'providerMalpractices' => $providerMalpractices,
            'needle'               => null,
            'provider_id'          => $provider_id,
            'providerName'         => $provider->name,
            'professional_id'      => $provider->isProfessional ? $provider->professional->id : null,
            'seo'                  => [
                'pageTitle' => 'Provider Malpractices',
            ],
        ];

        return view('provider.malpractice.index', $data);
    }

    public function search(Request $request, $provider_id)
    {
        if ($this->authUserCannot('search-provider-malpractice')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $provider = \App\Provider::find($provider_id);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $providerMalpractices = ProviderMalpractice::search($needle)->provider($provider_id)->sortable()->paginate($perPage);

        $data = [
            'encToken'             => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'providerMalpractices' => $providerMalpractices,
            'needle'               => $needle,
            'provider_id'          => $provider_id,
            'providerName'         => $provider->name,
            'professional_id'      => $provider->isProfessional ? $provider->professional->id : null,
            'seo'                  => [
                'pageTitle' => 'Provider Malpractices',
            ],
        ];

        return view('provider.malpractice.index', $data);
    }

    public function create($provider_id)
    {
        if ($this->authUserCannot('create-provider-malpractice')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $provider = \App\Provider::find($provider_id);

        $data = [
            'encToken'        => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation'        => $this->equation(),
            'provider_id'     => $provider_id,
            'providerName'    => $provider->name,
            'professional_id' => $provider->isProfessional ? $provider->professional->id : null,
            'insurersCB'      => \App\Insurer::insurersCB(['0' => 'Select insurer']),
            'policyTypesCB'   => \App\PolicyType::policyTypesCB(['0' => 'Select policy type']),
            'seo'             => [
                'pageTitle' => 'Add Malpractice',
            ],
        ];

        return view('provider.malpractice.create', $data);
    }

    public function store(ProviderMalpracticeRequest $request)
    {
        if ($this->authUserCannot('create-provider-malpractice')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        $inputs['retroactive_at'] = !empty($inputs['retroactive_at']) ? date('Y-m-d', strtotime($inputs['retroactive_at'])) : null;
        $inputs['started_at'] = !empty($inputs['started_at']) ? date('Y-m-d', strtotime($inputs['started_at'])) : null;
        $inputs['expired_at'] = !empty($inputs['expired_at']) ? date('Y-m-d', strtotime($inputs['expired_at'])) : null;

        ProviderMalpractice::create($inputs);

        return redirect()->route('provider_malpractice_list_path', ['provider_id' => $inputs['provider_id']])->withSuccess('Provider malpractice added.');
    }

    public function edit(ProviderMalpractice $malpractice)
    {
        if ($this->authUserCannot('update-provider-malpractice')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $provider = \App\Provider::find($malpractice->provider_id);

        $data = [
            'encToken'        => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'malpractice'     => $malpractice,
            'equation'        => $this->equation(),
            'provider_id'     => $malpractice->provider_id,
            'providerName'    => $provider->name,
            'professional_id' => $provider->isProfessional ? $provider->professional->id : null,
            'insurersCB'      => \App\Insurer::insurersCB(['0' => 'Select insurer']),
            'policyTypesCB'   => \App\PolicyType::policyTypesCB(['0' => 'Select policy type']),
            'seo'             => [
                'pageTitle' => 'Update Malpractice',
            ],
        ];

        return view('provider.malpractice.edit', $data);
    }

    public function update(ProviderMalpractice $malpractice, ProviderMalpracticeRequest $request)
    {
        if ($this->authUserCannot('update-provider-malpractice')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        $inputs['retroactive_at'] = !empty($inputs['retroactive_at']) ? date('Y-m-d', strtotime($inputs['retroactive_at'])) : null;
        $inputs['started_at'] = !empty($inputs['started_at']) ? date('Y-m-d', strtotime($inputs['started_at'])) : null;
        $inputs['expired_at'] = !empty($inputs['expired_at']) ? date('Y-m-d', strtotime($inputs['expired_at'])) : null;

        if (empty($inputs['insurance_proof'])) {
            $inputs['insurance_proof'] = false;
        }
        if (empty($inputs['primary_sourced'])) {
            $inputs['primary_sourced'] = false;
        }

        $malpractice->update($inputs);

        return redirect()->route('provider_malpractice_list_path', ['provider_id' => $malpractice->provider_id])->withSuccess('Malpractice updated.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-provider-malpractice')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no provider malpractice selected.');
        }
        $arrCid = explode('|', $strCid);

        foreach ($arrCid as $id) {
            $providerMalpractice = ProviderMalpractice::find($id);
            $providerMalpractice->delete();
        }

        return redirect()->route('provider_malpractice_list_path', ['provider_id' => $request->input('provider_id')])->withSuccess('Provider malpractice deleted.');
    }

}
