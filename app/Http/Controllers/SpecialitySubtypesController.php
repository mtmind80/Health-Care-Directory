<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\SpecialitySubtype;
use App\Http\Requests\SpecialitySubtypeRequest;

use EquationTrait;

class SpecialitySubtypesController extends CommonController
{
    use EquationTrait;

    public function index(Request $request, $speciality_type_id)
    {
        if ($this->authUserCannot('list-speciality-subtype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $specialitySubtypes = SpecialitySubtype::sortable()->type($speciality_type_id)->paginate($perPage);

        $data = [
            'encToken'           => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'specialitySubtypes' => $specialitySubtypes,
            'needle'             => null,
            'speciality_type_id' => $speciality_type_id,
            'specialityTypeName' => \App\SpecialityType::find($speciality_type_id)->name,
            'seo'                => [
                'pageTitle' => 'Speciality Subtypes',
            ],
        ];

        return view('specialitytype.subtype.index', $data);
    }

    public function search(Request $request, $speciality_type_id)
    {
        if ($this->authUserCannot('search-speciality-subtype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:2',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $specialitySubtypes = SpecialitySubtype::search($needle)->type($speciality_type_id)->sortable()->paginate($perPage);
        $data = [
            'encToken'           => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'specialitySubtypes' => $specialitySubtypes,
            'needle'             => $needle,
            'speciality_type_id' => $speciality_type_id,
            'specialityTypeName' => \App\SpecialityType::find($speciality_type_id)->name,
            'seo'                => [
                'pageTitle' => 'Speciality Subtypes',
            ],
        ];

        return view('specialitytype.subtype.index', $data);
    }

    public function create($speciality_type_id)
    {
        if ($this->authUserCannot('create-speciality-subtype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken'           => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation'           => $this->equation(),
            'speciality_type_id' => $speciality_type_id,
            'specialityTypeName' => \App\SpecialityType::find($speciality_type_id)->name,
            'seo'                => [
                'pageTitle' => 'Create speciality subtype',
            ],
        ];

        return view('specialitytype.subtype.create', $data);
    }

    public function store(SpecialitySubtypeRequest $request)
    {
        if ($this->authUserCannot('create-speciality-subtype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        SpecialitySubtype::create($inputs);

        return redirect()->route('speciality_subtype_list_path', ['speciality_type_id' => $inputs['speciality_type_id']])->withSuccess('Speciality subtype created.');
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
                $SpecialitySubtype = SpecialitySubtype::find($id);
                $SpecialitySubtype->{$name} = $value;
                $SpecialitySubtype->save();

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
        if ($this->authUserCannot('update-speciality-subtype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $SpecialitySubtype = SpecialitySubtype::find($id);
        $SpecialitySubtype->disabled = !$SpecialitySubtype->disabled;
        $SpecialitySubtype->save();

        return redirect()->back()->withSuccess('SpecialitySubtype status toggled.');
    }

    public function fetch(Request $request)
    {
        if ($request->isMethod('post') && $request->ajax()) {
            if (!$specialityTypeId = $request->speciality_type_id) {
                $response = [
                    'success' => false,
                    'message' => 'speciality_type_id is empty.',
                ];
            } else {
                if (!$specialitySubtypes = SpecialitySubtype::SpecialitySubtypesCB($specialityTypeId)) {
                    $response = [
                        'success' => false,
                        'message' => 'No SpecialitySubtypes found.',
                    ];
                } else {
                    $response = [
                        'success' => true,
                        'data'    => $specialitySubtypes,
                    ];
                }
            }
        } else {
            $response = [
                'success' => false,
                'message' => 'Invalid request.',
            ];
        }

        return json_encode($response);
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-speciality-subtype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no speciality subtype selected.');
        }
        $arrCid = explode('|', $strCid);

        SpecialitySubtype::destroy($arrCid);

        return redirect()->route('speciality_subtype_list_path', ['speciality_type_id' => $request->input('speciality_type_id')])->withSuccess('Speciality subtype deleted.');
    }

}
