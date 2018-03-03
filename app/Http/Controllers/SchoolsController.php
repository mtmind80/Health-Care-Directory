<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\School;
use App\Http\Requests\SchoolRequest;

use EquationTrait;

class SchoolsController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-school')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $schools = School::sortable()->paginate($perPage);

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'schools'  => $schools,
            'needle'   => null,
            'seo'      => [
                'pageTitle' => 'Schools',
            ],
        ];

        return view('school.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-school')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $schools = School::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'schools'  => $schools,
            'needle'   => $needle,
            'seo'      => [
                'pageTitle' => 'Schools',
            ],
        ];

        return view('school.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-school')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken'    => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation'    => $this->equation(),
            'countriesCB' => \App\Country::countriesCB(['0' => 'Select Country']),
            'statesCB'    => [],
            'seo'         => [
                'pageTitle' => 'Create School',
            ],
        ];

        return view('school.create', $data);
    }

    public function store(SchoolRequest $request)
    {
        if ($this->authUserCannot('create-school')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        School::create($inputs);

        return redirect()->route('school_list_path')->withSuccess('School created.');
    }

    public function edit(School $school)
    {
        if ($this->authUserCannot('update-school')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken'    => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'school'      => $school,
            'equation'    => $this->equation(),
            'countriesCB' => \App\Country::countriesCB(),
            'statesCB'    => \App\State::statesCB($school->state->country->id),
            'seo'         => [
                'pageTitle' => 'Edit: ' . $school->name,
            ],
        ];

        return view('school.edit', $data);
    }

    public function update(School $school, SchoolRequest $request)
    {
        if ($this->authUserCannot('update-school')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        $school->update($inputs);

        return redirect()->route('school_list_path')->with('success', 'School updated.');
    }

    public function inlineUpdate(Request $request)
    {
        if ($request->isMethod('post') && $request->ajax()) {
            $input = $request->all();

            $id = $input['pk'];
            $name = $input['name'];
            $value = $input['value'];
            $rule = (isset($input['rule'])) ? $input['rule'] : 'text';

            /*
             * The first argument passed to the make method is the data under validation.
             * The second argument is the validation rules that should be applied to the data.
             */

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
                $school = School::find($id);
                $school->{$name} = $value;
                $school->save();

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

    public function toggleStatus($id)
    {
        if ($this->authUserCannot('update-school')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $school = School::find($id);
        $school->disabled = !$school->disabled;
        $school->save();

        return redirect()->back()->withSuccess('School status toggled.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-school')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no school selected.');
        }
        $arrCid = explode('|', $strCid);

        School::destroy($arrCid);

        return redirect()->route('school_list_path')->withSuccess('School deleted.');
    }

}
