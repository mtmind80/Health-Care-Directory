<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\ProfessionalSchool;
use App\Http\Requests\ProfessionalSchoolRequest;

use ProfessionalSchoolObserver;

use EquationTrait;

class ProfessionalSchoolsController extends CommonController
{
    use EquationTrait;

    public function __construct()
    {
        parent::__construct();

        ProfessionalSchool::observe(new ProfessionalSchoolObserver);
    }

    public function index(Request $request, $professional_id)
    {
        if ($this->authUserCannot('list-professional-school')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $schools = ProfessionalSchool::active()->sortable()->professional($professional_id)->paginate($perPage);

        $professional = \App\Professional::find($professional_id);

        $data = [
            'encToken'         => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'schools'          => $schools,
            'needle'           => null,
            'professional_id'  => $professional_id,
            'professionalName' => $professional->fullName,
            'provider_id'      => $professional->provider_id,
            'jsonDegreesCB'    => json_encode(\App\Degree::degreesCB()),
            'jsonSchoolsCB'    => json_encode(\App\School::schoolsCB()),
            'seo'              => [
                'pageTitle' => 'Provider Schools',
            ],
        ];

        return view('provider.school.index', $data);
    }

    public function search(Request $request, $professional_id)
    {
        if ($this->authUserCannot('search-professional-school')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $professional = \App\Professional::find($professional_id);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $schools = ProfessionalSchool::active()->search($needle)->professional($professional_id)->sortable()->paginate($perPage);
        $data = [
            'encToken'         => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'schools'          => $schools,
            'needle'           => $needle,
            'professional_id'  => $professional_id,
            'professionalName' => $professional->fullName,
            'provider_id'      => $professional->provider_id,
            'jsonDegreesCB'    => json_encode(\App\Degree::degreesCB()),
            'jsonSchoolsCB'    => json_encode(\App\School::schoolsCB()),
            'seo'              => [
                'pageTitle' => 'Provider Schools',
            ],
        ];

        return view('provider.school.index', $data);
    }

    public function create($professional_id)
    {
        if ($this->authUserCannot('create-professional-school')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $professional = \App\Professional::find($professional_id);

        $data = [
            'encToken'         => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation'         => $this->equation(),
            'professional_id'  => $professional_id,
            'professionalName' => $professional->fullName,
            'provider_id'      => $professional->provider_id,
            'degreesCB'        => \App\Degree::degreesCB(['0' => 'Select degree']),
            'schoolsCB'        => \App\School::schoolsCB(['0' => 'Select school']),
            'seo'              => [
                'pageTitle' => 'Add School',
            ],
        ];

        return view('provider.school.create', $data);
    }

    public function store(ProfessionalSchoolRequest $request)
    {
        if ($this->authUserCannot('create-professional-school')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (!empty($inputs['started_at'])) {
            $inputs['started_at'] = date('Y-m-d', strtotime($inputs['started_at']));
        }
        if (!empty($inputs['ended_at'])) {
            $inputs['ended_at'] = date('Y-m-d', strtotime($inputs['started_at']));
        }

        ProfessionalSchool::create($inputs);

        return redirect()->route('professional_school_list_path', ['professional_id' => $inputs['professional_id']])->withSuccess('School added.');
    }

    public function edit(ProfessionalSchool $school)
    {
        if ($this->authUserCannot('update-school')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $professional = \App\Professional::find($school->professional_id);

        $data = [
            'encToken'         => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'school'           => $school,
            'equation'         => $this->equation(),
            'professional_id'  => $school->professional_id,
            'professionalName' => $professional->fullName,
            'provider_id'      => $professional->provider_id,
            'degreesCB'        => \App\Degree::degreesCB(),
            'schoolsCB'        => \App\School::schoolsCB(),
            'seo'              => [
                'pageTitle' => 'Update School',
            ],
        ];

        return view('provider.school.edit', $data);
    }

    public function update(ProfessionalSchool $school, ProfessionalSchoolRequest $request)
    {
        if ($this->authUserCannot('update-school')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        $inputs['started_at'] = !empty($inputs['started_at']) ? date('Y-m-d', strtotime($inputs['started_at'])) : null;
        $inputs['ended_at'] = !empty($inputs['ended_at']) ? date('Y-m-d', strtotime($inputs['ended_at'])) : null;

        $school->update($inputs);

        return redirect()->route('professional_school_list_path', ['professional_id' => $school->professional_id])->withSuccess('School updated.');
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
                $professionalSchool = ProfessionalSchool::find($id);
                $professionalSchool->{$name} = $value;
                $professionalSchool->save();

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
        if ($this->authUserCannot('delete-professional-school')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no school selected.');
        }
        $arrCid = explode('|', $strCid);

        foreach ($arrCid as $id) {
            $professionalSchool = ProfessionalSchool::find($id);
            $professionalSchool->delete();
        }

        return redirect()->route('professional_school_list_path', ['professional_id' => $request->input('professional_id')])->withSuccess('School deleted.');
    }

}
