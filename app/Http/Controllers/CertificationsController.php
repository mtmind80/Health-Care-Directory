<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Certification;
use App\Http\Requests\CertificationRequest;

use EquationTrait;

class CertificationsController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-certification')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $certifications = Certification::sortable()->paginate($perPage);

        $data = [
            'encToken'       => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'certifications' => $certifications,
            'needle'         => null,
            'seo'            => [
                'pageTitle' => 'Certifications',
            ],
        ];

        return view('certification.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-certification')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $certifications = Certification::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken'       => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'certifications' => $certifications,
            'needle'         => $needle,
            'seo'            => [
                'pageTitle' => 'Certifications',
            ],
        ];

        return view('certification.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-certification')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken'         => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation'         => $this->equation(),
            'seo'              => [
                'pageTitle' => 'Create Certification',
            ],
        ];

        return view('certification.create', $data);
    }

    public function store(CertificationRequest $request)
    {
        if ($this->authUserCannot('create-certification')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        Certification::create($inputs);

        return redirect()->route('certification_list_path')->withSuccess('Certification created.');
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
                $certification = Certification::find($id);
                $certification->{$name} = $value;
                $certification->save();

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
        if ($this->authUserCannot('update-certification')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $certification = Certification::find($id);
        $certification->disabled = !$certification->disabled;
        $certification->save();

        return redirect()->back()->withSuccess('Certification status toggled.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-certification')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no certification selected.');
        }
        $arrCid = explode('|', $strCid);

        Certification::destroy($arrCid);

        return redirect()->route('certification_list_path')->withSuccess('Certification deleted.');
    }

}
