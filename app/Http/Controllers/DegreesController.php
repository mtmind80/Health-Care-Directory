<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Degree;
use App\Http\Requests\DegreeRequest;

use EquationTrait;

class DegreesController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-degree')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $degrees = Degree::sortable()->paginate($perPage);

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'degrees'  => $degrees,
            'needle'   => null,
            'seo'      => [
                'pageTitle' => 'Degrees',
            ],
        ];

        return view('degree.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-degree')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:2',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $degrees = Degree::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'degrees'  => $degrees,
            'needle'   => $needle,
            'seo'      => [
                'pageTitle' => 'Degrees',
            ],
        ];

        return view('degree.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-degree')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation' => $this->equation(),
            'seo'      => [
                'pageTitle' => 'Create Degree',
            ],
        ];

        return view('degree.create', $data);
    }

    public function store(DegreeRequest $request)
    {
        if ($this->authUserCannot('create-degree')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        Degree::create($inputs);

        return redirect()->route('degree_list_path')->withSuccess('Degree created.');
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
                $degree = Degree::find($id);
                $degree->{$name} = $value;
                $degree->save();

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
        if ($this->authUserCannot('update-degree')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $degree = Degree::find($id);
        $degree->disabled = !$degree->disabled;
        $degree->save();

        return redirect()->back()->withSuccess('Degree status toggled.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-degree')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no degree selected.');
        }
        $arrCid = explode('|', $strCid);

        Degree::destroy($arrCid);

        return redirect()->route('degree_list_path')->withSuccess('Degree deleted.');
    }

}
