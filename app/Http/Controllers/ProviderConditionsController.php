<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\ProviderCondition;
use App\Http\Requests\ProviderConditionRequest;

use ProviderConditionObserver;

use EquationTrait;

class ProviderConditionsController extends CommonController
{
    use EquationTrait;

    public function __construct()
    {
        parent::__construct();

        ProviderCondition::observe(new ProviderConditionObserver);
    }

    public function index(Request $request, $provider_id)
    {
        if ($this->authUserCannot('list-provider-condition')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $conditions = ProviderCondition::sortable()->provider($provider_id)->paginate($perPage);

        $provider = \App\Provider::find($provider_id);

        $data = [
            'encToken'        => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'conditions'      => $conditions,
            'needle'          => null,
            'provider_id'     => $provider_id,
            'providerName'    => $provider->name,
            'professional_id' => $provider->isProfessional ? $provider->professional->id : null,
            'seo'             => [
                'pageTitle' => 'Provider Conditions',
            ],
        ];

        return view('provider.condition.index', $data);
    }

    public function search(Request $request, $provider_id)
    {
        if ($this->authUserCannot('search-provider-condition')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $provider = \App\Provider::find($provider_id);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $conditions = ProviderCondition::search($needle)->provider($provider_id)->sortable()->paginate($perPage);

        $data = [
            'encToken'        => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'conditions'      => $conditions,
            'needle'          => $needle,
            'provider_id'     => $provider_id,
            'providerName'    => $provider->name,
            'professional_id' => $provider->isProfessional ? $provider->professional->id : null,
            'seo'             => [
                'pageTitle' => 'Provider Conditions',
            ],
        ];

        return view('provider.condition.index', $data);
    }

    public function create($provider_id)
    {
        if ($this->authUserCannot('create-provider-condition')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $provider = \App\Provider::find($provider_id);

        $data = [
            'encToken'        => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation'        => $this->equation(),
            'provider_id'     => $provider_id,
            'providerName'    => $provider->name,
            'professional_id' => $provider->isProfessional ? $provider->professional->id : null,
            'conditionsCB'    => \App\Condition::conditionsCB(['0' => 'Select condition']),
            'seo'             => [
                'pageTitle' => 'Add Condition',
            ],
        ];

        return view('provider.condition.create', $data);
    }

    public function store(ProviderConditionRequest $request)
    {
        if ($this->authUserCannot('create-provider-condition')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        ProviderCondition::create($inputs);

        return redirect()->route('provider_condition_list_path', ['provider_id' => $inputs['provider_id']])->withSuccess('Provider condition added.');
    }

    public function edit(ProviderCondition $condition)
    {
        if ($this->authUserCannot('update-provider-condition')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $provider = \App\Provider::find($condition->provider_id);

        $data = [
            'encToken'        => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'condition'       => $condition,
            'equation'        => $this->equation(),
            'provider_id'     => $condition->provider_id,
            'providerName'    => $provider->name,
            'professional_id' => $provider->isProfessional ? $provider->professional->id : null,
            'conditionsCB'    => \App\Condition::conditionsCB(),
            'seo'             => [
                'pageTitle' => 'Update Condition',
            ],
        ];

        return view('provider.condition.edit', $data);
    }

    public function update(ProviderCondition $condition, ProviderConditionRequest $request)
    {
        if ($this->authUserCannot('update-provider-condition')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        $condition->update($inputs);

        return redirect()->route('provider_condition_list_path', ['provider_id' => $condition->provider_id])->withSuccess('Condition updated.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-provider-condition')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no provider condition selected.');
        }
        $arrCid = explode('|', $strCid);

        foreach ($arrCid as $id) {
            $providerCondition = ProviderCondition::find($id);
            $providerCondition->delete();
        }

        return redirect()->route('provider_condition_list_path', ['provider_id' => $request->input('provider_id')])->withSuccess('Provider condition deleted.');
    }

}
