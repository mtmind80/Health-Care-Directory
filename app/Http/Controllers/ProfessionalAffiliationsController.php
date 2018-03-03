<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\ProfessionalAffiliation;
use App\Http\Requests\ProfessionalAffiliationRequest;

use ProfessionalAffiliationObserver;

use EquationTrait;

class ProfessionalAffiliationsController extends CommonController
{
    use EquationTrait;

    public function __construct()
    {
        parent::__construct();

        ProfessionalAffiliation::observe(new ProfessionalAffiliationObserver);
    }

    public function index(Request $request, $professional_id)
    {
        if ($this->authUserCannot('list-professional-affiliation')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $affiliations = ProfessionalAffiliation::active()->sortable()->professional($professional_id)->paginate($perPage);

        $professional = \App\Professional::find($professional_id);

        $data = [
            'encToken'         => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'affiliations'     => $affiliations,
            'needle'           => null,
            'professional_id'  => $professional_id,
            'professionalName' => $professional->fullName,
            'provider_id'      => $professional->provider_id,
            'seo'              => [
                'pageTitle' => 'Provider Affiliations',
            ],
        ];

        return view('provider.affiliation.index', $data);
    }

    public function search(Request $request, $professional_id)
    {
        if ($this->authUserCannot('search-professional-affiliation')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $professional = \App\Professional::find($professional_id);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $affiliations = ProfessionalAffiliation::active()->search($needle)->professional($professional_id)->sortable()->paginate($perPage);
        $data = [
            'encToken'         => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'affiliations'     => $affiliations,
            'needle'           => $needle,
            'professional_id'  => $professional_id,
            'professionalName' => $professional->fullName,
            'provider_id'      => $professional->provider_id,
            'seo'              => [
                'pageTitle' => 'Provider Affiliations',
            ],
        ];

        return view('provider.affiliation.index', $data);
    }

    public function create($professional_id)
    {
        if ($this->authUserCannot('create-professional-affiliation')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $institutionsCB = \App\Facility::hospitalsCB(['0' => 'Select hospital']);

        if (count($institutionsCB) <= 1) {
            return redirect()->back()->withError('There is no hospitals to select.');
        }

        $professional = \App\Professional::find($professional_id);

        $data = [
            'encToken'         => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation'         => $this->equation(),
            'professional_id'  => $professional_id,
            'professionalName' => $professional->fullName,
            'provider_id'      => $professional->provider_id,
            'institutionsCB'   => \App\Facility::hospitalsCB(['0' => 'Select hospital']),
            'seo'              => [
                'pageTitle' => 'Add Affiliation',
            ],
        ];

        return view('provider.affiliation.create', $data);
    }

    public function store(ProfessionalAffiliationRequest $request)
    {
        if ($this->authUserCannot('create-professional-affiliation')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (!empty($inputs['started_at'])) {
            $inputs['started_at'] = date('Y-m-d', strtotime($inputs['started_at']));
        }
        if (!empty($inputs['ended_at'])) {
            $inputs['ended_at'] = date('Y-m-d', strtotime($inputs['ended_at']));
        }

        ProfessionalAffiliation::create($inputs);

        return redirect()->route('professional_affiliation_list_path', ['professional_id' => $inputs['professional_id']])->withSuccess('Affiliation added.');
    }

    public function edit(ProfessionalAffiliation $affiliation)
    {
        if ($this->authUserCannot('update-affiliation')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $professional = \App\Professional::find($affiliation->professional_id);

        $data = [
            'encToken'         => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'affiliation'      => $affiliation,
            'equation'         => $this->equation(),
            'professional_id'  => $affiliation->professional_id,
            'professionalName' => $professional->fullName,
            'provider_id'      => $professional->provider_id,
            'institutionsCB'   => \App\Facility::hospitalsCB(),
            'seo'              => [
                'pageTitle' => 'Update Affiliation',
            ],
        ];

        return view('provider.affiliation.edit', $data);
    }

    public function update(ProfessionalAffiliation $affiliation, ProfessionalAffiliationRequest $request)
    {
        if ($this->authUserCannot('update-affiliation')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        $inputs['started_at'] = !empty($inputs['started_at']) ? date('Y-m-d', strtotime($inputs['started_at'])) : null;
        $inputs['ended_at'] = !empty($inputs['ended_at']) ? date('Y-m-d', strtotime($inputs['ended_at'])) : null;

        $affiliation->update($inputs);

        return redirect()->route('professional_affiliation_list_path', ['professional_id' => $affiliation->professional_id])->withSuccess('Affiliation updated.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-professional-affiliation')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no affiliation selected.');
        }
        $arrCid = explode('|', $strCid);

        foreach ($arrCid as $id) {
            $professionalAffiliation = ProfessionalAffiliation::find($id);
            $professionalAffiliation->delete();
        }

        return redirect()->route('professional_affiliation_list_path', ['professional_id' => $request->input('professional_id')])->withSuccess('Affiliation deleted.');
    }

}
