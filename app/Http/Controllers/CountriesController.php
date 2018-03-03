<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Country;
use App\Http\Requests\CountryRequest;

use EquationTrait;

class CountriesController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-country')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $countries = Country::sortable()->paginate($perPage);

        $data = [
            'encToken'  => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'countries' => $countries,
            'needle'    => null,
            'seo'       => [
                'pageTitle' => 'Countries',
            ],
        ];

        return view('country.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-country')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $countries = Country::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken'  => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'countries' => $countries,
            'needle'    => $needle,
            'seo'       => [
                'pageTitle' => 'Countries',
            ],
        ];

        return view('country.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-country')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation' => $this->equation(),
            'seo'      => [
                'pageTitle' => 'Create Country',
            ],
        ];

        return view('country.create', $data);
    }

    public function store(CountryRequest $request)
    {
        if ($this->authUserCannot('create-country')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        Country::create($inputs);

        return redirect()->route('country_list_path')->withSuccess('Country created.');
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
                $country = Country::find($id);
                $country->{$name} = $value;
                $country->save();

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
        if ($this->authUserCannot('update-country')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $country = Country::find($id);
        $country->disabled = !$country->disabled;
        $country->save();

        return redirect()->back()->withSuccess('Country status toggled.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-country')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no country selected.');
        }
        $arrCid = explode('|', $strCid);

        Country::destroy($arrCid);

        return redirect()->route('country_list_path')->withSuccess('Country deleted.');
    }

}
