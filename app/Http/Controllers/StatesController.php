<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\State;
use App\Http\Requests\StateRequest;

use EquationTrait;

class StatesController extends CommonController
{
    use EquationTrait;

    public function index(Request $request, $country_id)
    {
        if ($this->authUserCannot('list-state')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $states = State::sortable()->country($country_id)->paginate($perPage);

        $data = [
            'encToken'    => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'states'      => $states,
            'needle'      => null,
            'country_id'  => $country_id,
            'countryName' => \App\Country::find($country_id)->name,
            'seo'         => [
                'pageTitle' => 'States',
            ],
        ];

        return view('country.state.index', $data);
    }

    public function search(Request $request, $country_id)
    {
        if ($this->authUserCannot('search-state')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:2',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $states = State::search($needle)->country($country_id)->sortable()->paginate($perPage);
        $data = [
            'encToken'    => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'states'      => $states,
            'needle'      => $needle,
            'country_id'  => $country_id,
            'countryName' => \App\Country::find($country_id)->name,
            'seo'         => [
                'pageTitle' => 'States',
            ],
        ];

        return view('country.state.index', $data);
    }

    public function create($country_id)
    {
        if ($this->authUserCannot('create-state')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken'    => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation'    => $this->equation(),
            'country_id'  => $country_id,
            'countryName' => \App\Country::find($country_id)->name,
            'seo'         => [
                'pageTitle' => 'Create State',
            ],
        ];

        return view('country.state.create', $data);
    }

    public function store(StateRequest $request)
    {
        if ($this->authUserCannot('create-state')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        State::create($inputs);

        return redirect()->route('state_list_path', ['country_id' => $inputs['country_id']])->withSuccess('State created.');
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
                $state = State::find($id);
                $state->{$name} = $value;
                $state->save();

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
        if ($this->authUserCannot('update-state')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $state = State::find($id);
        $state->disabled = !$state->disabled;
        $state->save();

        return redirect()->back()->withSuccess('State status toggled.');
    }

    public function fetch(Request $request)
    {
        if ($request->isMethod('post') && $request->ajax()) {
            if (!$countryId = $request->country_id) {
                $response = [
                    'success'  => false,
                    'message' => 'country_id is empty.',
                ];
            } else {
                if (!$states = State::statesCB($countryId)) {
                    $response = [
                        'success'  => false,
                        'message' => 'No states found.',
                    ];
                } else {
                    $response = [
                        'success'  => true,
                        'data'   => $states,
                    ];
                }
            }
        } else {
            $response = [
                'success'  => false,
                'message' => 'Invalid request.',
            ];
        }

        return json_encode($response);
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-state')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no state selected.');
        }
        $arrCid = explode('|', $strCid);

        State::destroy($arrCid);

        return redirect()->route('state_list_path', ['country_id' => $request->input('country_id')])->withSuccess('State deleted.');
    }

}
