<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Insurer;
use App\Http\Requests\InsurerRequest;

use EquationTrait;

class InsurersController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-insurer')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $insurers = Insurer::sortable()->paginate($perPage);

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'insurers' => $insurers,
            'needle'   => null,
            'seo'      => [
                'pageTitle' => 'Insurers',
            ],
        ];

        return view('insurer.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-insurer')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $insurers = Insurer::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'insurers' => $insurers,
            'needle'   => $needle,
            'seo'      => [
                'pageTitle' => 'Insurers',
            ],
        ];

        return view('insurer.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-insurer')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken'    => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation'    => $this->equation(),
            'countriesCB' => \App\Country::countriesCB(['0' => 'Select Country']),
            'statesCB'    => [],
            'seo'         => [
                'pageTitle' => 'Create Insurer',
            ],
        ];

        return view('insurer.create', $data);
    }

    public function store(InsurerRequest $request)
    {
        if ($this->authUserCannot('create-insurer')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        Insurer::create($inputs);

        return redirect()->route('insurer_list_path')->withSuccess('Insurer created.');
    }

    public function edit(Insurer $insurer)
    {
        if ($this->authUserCannot('update-insurer')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken'    => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'insurer'     => $insurer,
            'equation'    => $this->equation(),
            'countriesCB' => \App\Country::countriesCB(),
            'statesCB'    => \App\State::statesCB($insurer->state->country->id),
            'seo'         => [
                'pageTitle' => 'Edit: ' . $insurer->name,
            ],
        ];

        return view('insurer.edit', $data);
    }

    public function update(Insurer $insurer, InsurerRequest $request)
    {
        if ($this->authUserCannot('update-insurer')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        $insurer->update($inputs);

        return redirect()->route('insurer_list_path')->with('success', 'Insurer updated.');
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
                $insurer = Insurer::find($id);
                $insurer->{$name} = $value;
                $insurer->save();

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
        if ($this->authUserCannot('update-insurer')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $insurer = Insurer::find($id);
        $insurer->disabled = !$insurer->disabled;
        $insurer->save();

        return redirect()->back()->withSuccess('Insurer status toggled.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-insurer')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no insurer selected.');
        }
        $arrCid = explode('|', $strCid);

        Insurer::destroy($arrCid);

        return redirect()->route('insurer_list_path')->withSuccess('Insurer deleted.');
    }

}
