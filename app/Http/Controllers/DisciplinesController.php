<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Discipline;
use App\Http\Requests\DisciplineRequest;

use EquationTrait;

class DisciplinesController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-discipline')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $disciplines = Discipline::sortable()->paginate($perPage);

        $data = [
            'encToken'    => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'disciplines' => $disciplines,
            'needle'      => null,
            'seo'         => [
                'pageTitle' => 'Disciplines',
            ],
        ];

        return view('discipline.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-discipline')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $disciplines = Discipline::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken'    => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'disciplines' => $disciplines,
            'needle'      => $needle,
            'seo'         => [
                'pageTitle' => 'Disciplines',
            ],
        ];

        return view('discipline.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-discipline')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation' => $this->equation(),
            'seo'      => [
                'pageTitle' => 'Create Discipline',
            ],
        ];

        return view('discipline.create', $data);
    }

    public function store(DisciplineRequest $request)
    {
        if ($this->authUserCannot('create-discipline')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        Discipline::create($inputs);

        return redirect()->route('discipline_list_path')->withSuccess('Discipline created.');
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
                $discipline = Discipline::find($id);
                $discipline->{$name} = $value;
                $discipline->save();

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
        if ($this->authUserCannot('update-discipline')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $discipline = Discipline::find($id);
        $discipline->disabled = !$discipline->disabled;
        $discipline->save();

        return redirect()->back()->withSuccess('Discipline status toggled.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-discipline')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no discipline selected.');
        }
        $arrCid = explode('|', $strCid);

        Discipline::destroy($arrCid);

        return redirect()->route('discipline_list_path')->withSuccess('Discipline deleted.');
    }

}
