<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Condition;
use App\Http\Requests\ConditionRequest;

use EquationTrait;

class ConditionsController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-condition')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $conditions = Condition::sortable()->paginate($perPage);

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'conditions'    => $conditions,
            'needle'   => null,
            'seo'      => [
                'pageTitle' => 'Conditions',
            ],
        ];

        return view('condition.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-condition')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $conditions = Condition::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'conditions'    => $conditions,
            'needle'   => $needle,
            'seo'      => [
                'pageTitle' => 'Conditions',
            ],
        ];

        return view('condition.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-condition')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation' => $this->equation(),
            'seo'      => [
                'pageTitle' => 'Create Condition',
            ],
        ];

        return view('condition.create', $data);
    }

    public function store(ConditionRequest $request)
    {
        if ($this->authUserCannot('create-condition')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        Condition::create($inputs);

        return redirect()->route('condition_list_path')->withSuccess('Condition created.');
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
                $condition = Condition::find($id);
                $condition->{$name} = $value;
                $condition->save();

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
        if ($this->authUserCannot('update-condition')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $condition = Condition::find($id);
        $condition->disabled = !$condition->disabled;
        $condition->save();

        return redirect()->back()->withSuccess('Condition status toggled.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-condition')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no condition selected.');
        }
        $arrCid = explode('|', $strCid);

        Condition::destroy($arrCid);

        return redirect()->route('condition_list_path')->withSuccess('Condition deleted.');
    }

}
