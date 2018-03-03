<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\ProviderProcedure;
use App\Http\Requests\ProviderProcedureRequest;

use ProviderProcedureObserver;

use EquationTrait;

class ProviderProceduresController extends CommonController
{
    use EquationTrait;

    public function __construct()
    {
        parent::__construct();

        ProviderProcedure::observe(new ProviderProcedureObserver);
    }

    public function index(Request $request, $provider_id)
    {
        if ($this->authUserCannot('list-provider-procedure')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $procedures = ProviderProcedure::sortable()->provider($provider_id)->paginate($perPage);

        $provider = \App\Provider::find($provider_id);

        $data = [
            'encToken'        => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'procedures'      => $procedures,
            'needle'          => null,
            'provider_id'     => $provider_id,
            'providerName'    => $provider->name,
            'professional_id' => $provider->isProfessional ? $provider->professional->id : null,
            'seo'             => [
                'pageTitle' => 'Provider Procedures',
            ],
        ];

        return view('provider.procedure.index', $data);
    }

    public function search(Request $request, $provider_id)
    {
        if ($this->authUserCannot('search-provider-procedure')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $provider = \App\Provider::find($provider_id);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $procedures = ProviderProcedure::search($needle)->provider($provider_id)->sortable()->paginate($perPage);

        $data = [
            'encToken'        => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'procedures'      => $procedures,
            'needle'          => $needle,
            'provider_id'     => $provider_id,
            'providerName'    => $provider->name,
            'professional_id' => $provider->isProfessional ? $provider->professional->id : null,
            'seo'             => [
                'pageTitle' => 'Provider Procedures',
            ],
        ];

        return view('provider.procedure.index', $data);
    }

    public function create($provider_id)
    {
        if ($this->authUserCannot('create-provider-procedure')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $provider = \App\Provider::find($provider_id);

        $data = [
            'encToken'        => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation'        => $this->equation(),
            'provider_id'     => $provider_id,
            'providerName'    => $provider->name,
            'professional_id' => $provider->isProfessional ? $provider->professional->id : null,
            'proceduresCB'    => \App\Procedure::proceduresCB(['0' => 'Select procedure']),
            'seo'             => [
                'pageTitle' => 'Add Procedure',
            ],
        ];

        return view('provider.procedure.create', $data);
    }

    public function store(ProviderProcedureRequest $request)
    {
        if ($this->authUserCannot('create-provider-procedure')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        ProviderProcedure::create($inputs);

        return redirect()->route('provider_procedure_list_path', ['provider_id' => $inputs['provider_id']])->withSuccess('Provider procedure added.');
    }

    public function edit(ProviderProcedure $procedure)
    {
        if ($this->authUserCannot('update-provider-procedure')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $provider = \App\Provider::find($procedure->provider_id);

        $data = [
            'encToken'        => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'procedure'       => $procedure,
            'equation'        => $this->equation(),
            'provider_id'     => $procedure->provider_id,
            'providerName'    => $provider->name,
            'professional_id' => $provider->isProfessional ? $provider->professional->id : null,
            'proceduresCB'    => \App\Procedure::proceduresCB(),
            'seo'             => [
                'pageTitle' => 'Update Procedure',
            ],
        ];

        return view('provider.procedure.edit', $data);
    }

    public function update(ProviderProcedure $procedure, ProviderProcedureRequest $request)
    {
        if ($this->authUserCannot('update-provider-procedure')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        $procedure->update($inputs);

        return redirect()->route('provider_procedure_list_path', ['provider_id' => $procedure->provider_id])->withSuccess('Procedure updated.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-provider-procedure')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no provider procedure selected.');
        }
        $arrCid = explode('|', $strCid);

        foreach ($arrCid as $id) {
            $providerProcedure = ProviderProcedure::find($id);
            $providerProcedure->delete();
        }

        return redirect()->route('provider_procedure_list_path', ['provider_id' => $request->input('provider_id')])->withSuccess('Provider procedure deleted.');
    }

}
