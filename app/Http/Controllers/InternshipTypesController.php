<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\InternshipType;
use App\Http\Requests\InternshipTypeRequest;

use EquationTrait;

class InternshipTypesController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-internshiptype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $internshipTypes = InternshipType::sortable()->paginate($perPage);

        $data = [
            'encToken'        => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'internshipTypes' => $internshipTypes,
            'needle'          => null,
            'seo'             => [
                'pageTitle' => 'Internship Types',
            ],
        ];

        return view('internshiptype.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-internshiptype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $internshipTypes = InternshipType::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken'        => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'internshipTypes' => $internshipTypes,
            'needle'          => $needle,
            'seo'             => [
                'pageTitle' => 'Internship Types',
            ],
        ];

        return view('internshiptype.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-internshiptype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation' => $this->equation(),
            'seo'      => [
                'pageTitle' => 'Create Internship Type',
            ],
        ];

        return view('internshiptype.create', $data);
    }

    public function store(InternshipTypeRequest $request)
    {
        if ($this->authUserCannot('create-internshiptype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        InternshipType::create($inputs);

        return redirect()->route('internship_type_list_path')->withSuccess('Internship type created.');
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
                $InternshipType = InternshipType::find($id);
                $InternshipType->{$name} = $value;
                $InternshipType->save();

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
        if ($this->authUserCannot('update-internshiptype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $InternshipType = InternshipType::find($id);
        $InternshipType->disabled = !$InternshipType->disabled;
        $InternshipType->save();

        return redirect()->back()->withSuccess('Internship type status toggled.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-internshiptype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no internship type selected.');
        }
        $arrCid = explode('|', $strCid);

        InternshipType::destroy($arrCid);

        return redirect()->route('internship_type_list_path')->withSuccess('Internship type deleted.');
    }

}
