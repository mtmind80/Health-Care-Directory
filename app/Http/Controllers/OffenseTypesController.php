<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\OffenseType;
use App\Http\Requests\OffenseTypeRequest;

use EquationTrait;

class OffenseTypesController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-offense-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $offenseTypes = OffenseType::sortable()->paginate($perPage);

        $data = [
            'encToken'      => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'offenseTypes' => $offenseTypes,
            'needle'        => null,
            'seo'           => [
                'pageTitle' => 'Offense Types',
            ],
        ];

        return view('offensetype.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-offense-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $offenseTypes = OffenseType::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken'      => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'offenseTypes' => $offenseTypes,
            'needle'        => $needle,
            'seo'           => [
                'pageTitle' => 'Offense Types',
            ],
        ];

        return view('offensetype.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-offense-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation' => $this->equation(),
            'seo'      => [
                'pageTitle' => 'Create Offense Type',
            ],
        ];

        return view('offensetype.create', $data);
    }

    public function store(OffenseTypeRequest $request)
    {
        if ($this->authUserCannot('create-offense-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        OffenseType::create($inputs);

        return redirect()->route('offense_type_list_path')->withSuccess('Offense type created.');
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
                $offenseType = OffenseType::find($id);
                $offenseType->{$name} = $value;
                $offenseType->save();

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
        if ($this->authUserCannot('update-offense-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $offenseType = OffenseType::find($id);
        $offenseType->disabled = !$offenseType->disabled;
        $offenseType->save();

        return redirect()->back()->withSuccess('Offense type status toggled.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-offense-type')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no offense type selected.');
        }
        $arrCid = explode('|', $strCid);

        OffenseType::destroy($arrCid);

        return redirect()->route('offense_type_list_path')->withSuccess('Offense type deleted.');
    }

}
