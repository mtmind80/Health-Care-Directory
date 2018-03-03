<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\ProfessionalFellowship;
use App\Http\Requests\ProfessionalFellowshipRequest;

use ProfessionalFellowshipObserver;

use EquationTrait;

class ProfessionalFellowshipsController extends CommonController
{
    use EquationTrait;

    public function __construct()
    {
        parent::__construct();

        ProfessionalFellowship::observe(new ProfessionalFellowshipObserver);
    }

    public function index(Request $request, $professional_id)
    {
        if ($this->authUserCannot('list-professional-fellowship')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $fellowships = ProfessionalFellowship::active()->sortable()->professional($professional_id)->paginate($perPage);

        $professional = \App\Professional::find($professional_id);

        $data = [
            'encToken'         => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'fellowships'      => $fellowships,
            'needle'           => null,
            'professional_id'  => $professional_id,
            'professionalName' => $professional->fullName,
            'provider_id'      => $professional->provider_id,
            'seo'              => [
                'pageTitle' => 'Provider Fellowships',
            ],
        ];

        return view('provider.fellowship.index', $data);
    }

    public function search(Request $request, $professional_id)
    {
        if ($this->authUserCannot('search-professional-fellowship')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $professional = \App\Professional::find($professional_id);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $fellowships = ProfessionalFellowship::active()->search($needle)->professional($professional_id)->sortable()->paginate($perPage);
        $data = [
            'encToken'         => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'fellowships'      => $fellowships,
            'needle'           => $needle,
            'professional_id'  => $professional_id,
            'professionalName' => $professional->fullName,
            'provider_id'      => $professional->provider_id,
            'seo'              => [
                'pageTitle' => 'Provider Fellowships',
            ],
        ];

        return view('provider.fellowship.index', $data);
    }

    public function create($professional_id)
    {
        if ($this->authUserCannot('create-professional-fellowship')) {
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
                'pageTitle' => 'Add Fellowship',
            ],
        ];

        return view('provider.fellowship.create', $data);
    }

    public function store(ProfessionalFellowshipRequest $request)
    {
        if ($this->authUserCannot('create-professional-fellowship')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (!empty($inputs['started_at'])) {
            $inputs['started_at'] = date('Y-m-d', strtotime($inputs['started_at']));
        }
        if (!empty($inputs['ended_at'])) {
            $inputs['ended_at'] = date('Y-m-d', strtotime($inputs['ended_at']));
        }

        ProfessionalFellowship::create($inputs);

        return redirect()->route('professional_fellowship_list_path', ['professional_id' => $inputs['professional_id']])->withSuccess('Fellowship added.');
    }

    public function edit(ProfessionalFellowship $fellowship)
    {
        if ($this->authUserCannot('update-fellowship')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $professional = \App\Professional::find($fellowship->professional_id);

        $data = [
            'encToken'             => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'fellowship'           => $fellowship,
            'equation'             => $this->equation(),
            'professional_id'      => $fellowship->professional_id,
            'professionalName'     => $professional->fullName,
            'provider_id'          => $professional->provider_id,
            'specialityTypesCB'    => \App\SpecialityType::specialityTypesCB(),
            'specialitySubtypesCB' => \App\SpecialitySubtype::specialitySubtypesCB($fellowship->speciality_type_id),
            'degreesCB'            => \App\Degree::degreesCB(),
            'disciplinesCB'        => \App\Discipline::disciplinesCB(),
            'institutionsCB'       => \App\Facility::institutionsCB(),
            'seo'                  => [
                'pageTitle' => 'Update Fellowship',
            ],
        ];

        return view('provider.fellowship.edit', $data);
    }

    public function update(ProfessionalFellowship $fellowship, ProfessionalFellowshipRequest $request)
    {
        if ($this->authUserCannot('update-fellowship')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        $inputs['started_at'] = !empty($inputs['started_at']) ? date('Y-m-d', strtotime($inputs['started_at'])) : null;
        $inputs['ended_at'] = !empty($inputs['ended_at']) ? date('Y-m-d', strtotime($inputs['ended_at'])) : null;

        $fellowship->update($inputs);

        return redirect()->route('professional_fellowship_list_path', ['professional_id' => $fellowship->professional_id])->withSuccess('Fellowship updated.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-professional-fellowship')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no fellowship selected.');
        }
        $arrCid = explode('|', $strCid);

        foreach ($arrCid as $id) {
            $professionalFellowship = ProfessionalFellowship::find($id);
            $professionalFellowship->delete();
        }

        return redirect()->route('professional_fellowship_list_path', ['professional_id' => $request->input('professional_id')])->withSuccess('Fellowship deleted.');
    }

}
