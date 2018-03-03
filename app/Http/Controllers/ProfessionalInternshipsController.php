<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\ProfessionalInternship;
use App\Http\Requests\ProfessionalInternshipRequest;

use ProfessionalInternshipObserver;

use EquationTrait;

class ProfessionalInternshipsController extends CommonController
{
    use EquationTrait;

    public function __construct()
    {
        parent::__construct();

        ProfessionalInternship::observe(new ProfessionalInternshipObserver);
    }

    public function index(Request $request, $professional_id)
    {
        if ($this->authUserCannot('list-professional-internship')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $internships = ProfessionalInternship::active()->sortable()->professional($professional_id)->paginate($perPage);

        $professional = \App\Professional::find($professional_id);

        $data = [
            'encToken'         => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'internships'      => $internships,
            'needle'           => null,
            'professional_id'  => $professional_id,
            'professionalName' => $professional->fullName,
            'provider_id'      => $professional->provider_id,
            'seo'              => [
                'pageTitle' => 'Provider Internships',
            ],
        ];

        return view('provider.internship.index', $data);
    }

    public function search(Request $request, $professional_id)
    {
        if ($this->authUserCannot('search-professional-internship')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $professional = \App\Professional::find($professional_id);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $internships = ProfessionalInternship::active()->search($needle)->professional($professional_id)->sortable()->paginate($perPage);
        $data = [
            'encToken'         => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'internships'      => $internships,
            'needle'           => $needle,
            'professional_id'  => $professional_id,
            'professionalName' => $professional->fullName,
            'provider_id'      => $professional->provider_id,
            'seo'              => [
                'pageTitle' => 'Provider Internships',
            ],
        ];

        return view('provider.internship.index', $data);
    }

    public function create($professional_id)
    {
        if ($this->authUserCannot('create-professional-internship')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $professional = \App\Professional::find($professional_id);

        $data = [
            'encToken'          => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation'          => $this->equation(),
            'professional_id'   => $professional_id,
            'professionalName'  => $professional->fullName,
            'provider_id'       => $professional->provider_id,
            'internshipTypesCB' => \App\InternshipType::internshipTypesCB(['0' => 'Select internship type']),
            'disciplinesCB'     => \App\Discipline::disciplinesCB(['0' => 'Select discipline']),
            'institutionsCB'    => \App\Facility::institutionsCB(['0' => 'Select institution']),
            'seo'               => [
                'pageTitle' => 'Add Internship',
            ],
        ];

        return view('provider.internship.create', $data);
    }

    public function store(ProfessionalInternshipRequest $request)
    {
        if ($this->authUserCannot('create-professional-internship')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (!empty($inputs['started_at'])) {
            $inputs['started_at'] = date('Y-m-d', strtotime($inputs['started_at']));
        }
        if (!empty($inputs['ended_at'])) {
            $inputs['ended_at'] = date('Y-m-d', strtotime($inputs['ended_at']));
        }

        ProfessionalInternship::create($inputs);

        return redirect()->route('professional_internship_list_path', ['professional_id' => $inputs['professional_id']])->withSuccess('Internship added.');
    }

    public function edit(ProfessionalInternship $internship)
    {
        if ($this->authUserCannot('update-internship')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $professional = \App\Professional::find($internship->professional_id);

        $data = [
            'encToken'          => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'internship'        => $internship,
            'equation'          => $this->equation(),
            'professional_id'   => $internship->professional_id,
            'professionalName'  => $professional->fullName,
            'provider_id'       => $professional->provider_id,
            'internshipTypesCB' => \App\InternshipType::internshipTypesCB(),
            'disciplinesCB'     => \App\Discipline::disciplinesCB(),
            'institutionsCB'    => \App\Facility::institutionsCB(),
            'seo'               => [
                'pageTitle' => 'Update Internship',
            ],
        ];

        return view('provider.internship.edit', $data);
    }

    public function update(ProfessionalInternship $internship, ProfessionalInternshipRequest $request)
    {
        if ($this->authUserCannot('update-internship')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        $inputs['started_at'] = !empty($inputs['started_at']) ? date('Y-m-d', strtotime($inputs['started_at'])) : null;
        $inputs['ended_at'] = !empty($inputs['ended_at']) ? date('Y-m-d', strtotime($inputs['ended_at'])) : null;

        $internship->update($inputs);

        return redirect()->route('professional_internship_list_path', ['professional_id' => $internship->professional_id])->withSuccess('Internship updated.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-professional-internship')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no internship selected.');
        }
        $arrCid = explode('|', $strCid);

        foreach ($arrCid as $id) {
            $professionalInternship = ProfessionalInternship::find($id);
            $professionalInternship->delete();
        }

        return redirect()->route('professional_internship_list_path', ['professional_id' => $request->input('professional_id')])->withSuccess('Internship deleted.');
    }

}
