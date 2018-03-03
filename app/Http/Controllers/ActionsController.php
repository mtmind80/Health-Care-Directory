<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Action;
use App\Http\Requests\ActionRequest;

use EquationTrait;

class ActionsController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-action')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $logactions = Action::sortable()->paginate($perPage);

        $data = [
            'encToken'   => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'logActions' => $logactions,
            'needle'     => null,
            'seo'        => [
                'pageTitle' => 'Actions',
            ],
        ];

        return view('action.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-action')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $logactions = Action::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken'   => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'logActions' => $logactions,
            'needle'     => $needle,
            'seo'        => [
                'pageTitle' => 'Actions',
            ],
        ];

        return view('action.index', $data);
    }

    public function show(Action $action)
    {
        if ($this->authUserCannot('show-action')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }
    }

    public function create()
    {
        if ($this->authUserCannot('create-action')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation' => $this->equation(),
            'seo'      => [
                'pageTitle' => 'Create Action',
            ],
        ];

        return view('action.create', $data);
    }

    public function store(ActionRequest $request)
    {
        if ($this->authUserCannot('create-action')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        Action::create($inputs);

        return redirect()->route('action_list_path')->withSuccess('Action created.');
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
                $logaction = Action::find($id);
                $logaction->{$name} = $value;
                $logaction->save();

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
        if ($this->authUserCannot('delete-action')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no action selected.');
        }
        $arrCid = explode('|', $strCid);

        Action::destroy($arrCid);

        return redirect()->route('action_list_path')->withSuccess('Action deleted.');
    }

}
