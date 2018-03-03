<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Procedure;
use App\Http\Requests\ProcedureRequest;

use EquationTrait;

class ProceduresController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-procedure')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $procedures = Procedure::sortable()->paginate($perPage);

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'procedures'    => $procedures,
            'needle'   => null,
            'seo'      => [
                'pageTitle' => 'Procedures',
            ],
        ];

        return view('procedure.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-procedure')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $procedures = Procedure::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'procedures'    => $procedures,
            'needle'   => $needle,
            'seo'      => [
                'pageTitle' => 'Procedures',
            ],
        ];

        return view('procedure.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-procedure')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation' => $this->equation(),
            'seo'      => [
                'pageTitle' => 'Create Procedure',
            ],
        ];

        return view('procedure.create', $data);
    }

    public function store(ProcedureRequest $request)
    {
        if ($this->authUserCannot('create-procedure')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        Procedure::create($inputs);

        return redirect()->route('procedure_list_path')->withSuccess('Procedure created.');
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
                $procedure = Procedure::find($id);
                $procedure->{$name} = $value;
                $procedure->save();

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
        if ($this->authUserCannot('update-procedure')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $procedure = Procedure::find($id);
        $procedure->disabled = !$procedure->disabled;
        $procedure->save();

        return redirect()->back()->withSuccess('Procedure status toggled.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-procedure')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no procedure selected.');
        }
        $arrCid = explode('|', $strCid);

        Procedure::destroy($arrCid);

        return redirect()->route('procedure_list_path')->withSuccess('Procedure deleted.');
    }

}
