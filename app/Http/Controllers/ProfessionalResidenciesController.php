<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\ProfessionalResidency;
use App\Http\Requests\ProfessionalResidencyRequest;

use ProfessionalResidencyObserver;

use EquationTrait;

class ProfessionalResidenciesController extends CommonController
{
    use EquationTrait;

    public function __construct()
    {
        parent::__construct();

        ProfessionalResidency::observe(new ProfessionalResidencyObserver);
    }

    public function index(Request $request, $professional_id)
    {
        if ($this->authUserCannot('list-professional-residency')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $residencies = ProfessionalResidency::active()->sortable()->professional($professional_id)->paginate($perPage);

        $professional = \App\Professional::find($professional_id);

        $data = [
            'encToken'         => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'residencies'      => $residencies,
            'needle'           => null,
            'professional_id'  => $professional_id,
            'professionalName' => $professional->fullName,
            'provider_id'      => $professional->provider_id,
            'seo'              => [
                'pageTitle' => 'Provider Residencies',
            ],
        ];

        return view('provider.residency.index', $data);
    }

    public function search(Request $request, $professional_id)
    {
        if ($this->authUserCannot('search-professional-residency')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $professional = \App\Professional::find($professional_id);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $residencies = ProfessionalResidency::active()->search($needle)->professional($professional_id)->sortable()->paginate($perPage);
        $data = [
            'encToken'         => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'residencies'      => $residencies,
            'needle'           => $needle,
            'professional_id'  => $professional_id,
            'professionalName' => $professional->fullName,
            'provider_id'      => $professional->provider_id,
            'seo'              => [
                'pageTitle' => 'Provider Residencies',
            ],
        ];

        return view('provider.residency.index', $data);
    }

    public function create($professional_id)
    {
        if ($this->authUserCannot('create-professional-residency')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $professional = \App\Professional::find($professional_id);

        $data = [
            'encToken'             => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation'             => $this->equation(),
            'professional_id'      => $professional_id,
            'professionalName'     => $professional->fullName,
            'provider_id'          => $professional->provider_id,
            'specialityTypesCB'    => \App\SpecialityType::specialityTypesCB(['0' => 'Select speciality type']),
            'specialitySubtypesCB' => [],
            'degreesCB'            => \App\Degree::degreesCB(['0' => 'Select degree']),
            'disciplinesCB'        => \App\Discipline::disciplinesCB(['0' => 'Select discipline']),
            'institutionsCB'       => \App\Facility::institutionsCB(['0' => 'Select institution']),
            'seo'                  => [
                'pageTitle' => 'Add Residency',
            ],
        ];

        return view('provider.residency.create', $data);
    }

    public function store(ProfessionalResidencyRequest $request)
    {
        if ($this->authUserCannot('create-professional-residency')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (!empty($inputs['started_at'])) {
            $inputs['started_at'] = date('Y-m-d', strtotime($inputs['started_at']));
        }
        if (!empty($inputs['ended_at'])) {
            $inputs['ended_at'] = date('Y-m-d', strtotime($inputs['ended_at']));
        }

        ProfessionalResidency::create($inputs);

        return redirect()->route('professional_residency_list_path', ['professional_id' => $inputs['professional_id']])->withSuccess('Residency added.');
    }

    public function edit(ProfessionalResidency $residency)
    {
        if ($this->authUserCannot('update-residency')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $professional = \App\Professional::find($residency->professional_id);

        $data = [
            'encToken'             => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'residency'            => $residency,
            'equation'             => $this->equation(),
            'professional_id'      => $residency->professional_id,
            'professionalName'     => $professional->fullName,
            'provider_id'          => $professional->provider_id,
            'specialityTypesCB'    => \App\SpecialityType::specialityTypesCB(),
            'specialitySubtypesCB' => \App\SpecialitySubtype::specialitySubtypesCB($residency->speciality_type_id),
            'degreesCB'            => \App\Degree::degreesCB(),
            'disciplinesCB'        => \App\Discipline::disciplinesCB(),
            'institutionsCB'       => \App\Facility::institutionsCB(),
            'seo'                  => [
                'pageTitle' => 'Update Residency',
            ],
        ];

        return view('provider.residency.edit', $data);
    }

    public function update(ProfessionalResidency $residency, ProfessionalResidencyRequest $request)
    {
        if ($this->authUserCannot('update-residency')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        $inputs['started_at'] = !empty($inputs['started_at']) ? date('Y-m-d', strtotime($inputs['started_at'])) : null;
        $inputs['ended_at'] = !empty($inputs['ended_at']) ? date('Y-m-d', strtotime($inputs['ended_at'])) : null;

        $residency->update($inputs);

        return redirect()->route('professional_residency_list_path', ['professional_id' => $residency->professional_id])->withSuccess('Residency updated.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-professional-residency')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no residency selected.');
        }
        $arrCid = explode('|', $strCid);

        foreach ($arrCid as $id) {
            $professionalResidency = ProfessionalResidency::find($id);
            $professionalResidency->delete();
        }

        return redirect()->route('professional_residency_list_path', ['professional_id' => $request->input('professional_id')])->withSuccess('Residency deleted.');
    }

}
