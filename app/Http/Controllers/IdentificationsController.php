<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Identification;
use App\Http\Requests\IdentificationRequest;

use EquationTrait;

class IdentificationsController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-identification')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $identifications = Identification::sortable()->paginate($perPage);

        $data = [
            'encToken'        => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'identifications' => $identifications,
            'needle'          => null,
            'jsonYesNoCB'     => json_encode($this->yesNoCB),
            'seo'             => [
                'pageTitle' => 'Identifications',
            ],
        ];

        return view('identification.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-identification')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $identifications = Identification::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken'        => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'identifications' => $identifications,
            'needle'          => $needle,
            'jsonYesNoCB'     => json_encode($this->yesNoCB),
            'seo'             => [
                'pageTitle' => 'Identifications',
            ],
        ];

        return view('identification.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-identification')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation' => $this->equation(),
            'seo'      => [
                'pageTitle' => 'Create Identification',
            ],
        ];

        return view('identification.create', $data);
    }

    public function store(IdentificationRequest $request)
    {
        if ($this->authUserCannot('create-identification')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }
        if (empty($inputs['licence'])) {
            $inputs['licence'] = 0;
        }

        Identification::create($inputs);

        return redirect()->route('identification_list_path')->withSuccess('Identification created.');
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
                if (empty($value) && $name == 'licence') {
                    $value = 0;
                }
                $identification = Identification::find($id);
                $identification->{$name} = $value;
                $identification->save();

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
        if ($this->authUserCannot('update-identification')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $identification = Identification::find($id);
        $identification->disabled = !$identification->disabled;
        $identification->save();

        return redirect()->back()->withSuccess('Identification status toggled.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-identification')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no identification selected.');
        }
        $arrCid = explode('|', $strCid);

        Identification::destroy($arrCid);

        return redirect()->route('identification_list_path')->withSuccess('Identification deleted.');
    }

}
