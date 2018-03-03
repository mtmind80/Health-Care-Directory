<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\SpecialityType;
use App\Http\Requests\SpecialityTypeRequest;

use EquationTrait;

class SpecialityTypesController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-speciality-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $specialityTypes = SpecialityType::sortable()->paginate($perPage);

        $data = [
            'encToken'        => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'specialityTypes' => $specialityTypes,
            'needle'          => null,
            'seo'             => [
                'pageTitle' => 'Speciality Types',
            ],
        ];

        return view('specialitytype.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-speciality-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $specialityTypes = SpecialityType::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken'        => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'specialityTypes' => $specialityTypes,
            'needle'          => $needle,
            'seo'             => [
                'pageTitle' => 'Speciality Types',
            ],
        ];

        return view('specialitytype.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-speciality-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation' => $this->equation(),
            'seo'      => [
                'pageTitle' => 'Create Speciality Type',
            ],
        ];

        return view('specialitytype.create', $data);
    }

    public function store(SpecialityTypeRequest $request)
    {
        if ($this->authUserCannot('create-speciality-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        SpecialityType::create($inputs);

        return redirect()->route('speciality_type_list_path')->withSuccess('Speciality type created.');
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
                $SpecialityType = SpecialityType::find($id);
                $SpecialityType->{$name} = $value;
                $SpecialityType->save();

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
        if ($this->authUserCannot('update-speciality-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $SpecialityType = SpecialityType::find($id);
        $SpecialityType->disabled = !$SpecialityType->disabled;
        $SpecialityType->save();

        return redirect()->back()->withSuccess('Speciality type status toggled.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-speciality-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no speciality type selected.');
        }
        $arrCid = explode('|', $strCid);

        SpecialityType::destroy($arrCid);

        return redirect()->route('speciality_type_list_path')->withSuccess('Speciality type deleted.');
    }

}
