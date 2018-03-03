<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Body;
use App\Http\Requests\BodyRequest;

use EquationTrait;

class BodiesController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-body')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $bodies = Body::sortable()->paginate($perPage);

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'bodies'   => $bodies,
            'needle'   => null,
            'seo'      => [
                'pageTitle' => 'Certifying Boards',
            ],
        ];

        return view('body.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-body')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $bodies = Body::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'bodies'   => $bodies,
            'needle'   => $needle,
            'seo'      => [
                'pageTitle' => 'Certifying Boards',
            ],
        ];

        return view('body.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-body')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation' => $this->equation(),
            'seo'      => [
                'pageTitle' => 'Create Certifying Board',
            ],
        ];

        return view('body.create', $data);
    }

    public function store(BodyRequest $request)
    {
        if ($this->authUserCannot('create-body')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        Body::create($inputs);

        return redirect()->route('body_list_path')->withSuccess('Certifying Board created.');
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
                $body = Body::find($id);
                $body->{$name} = $value;
                $body->save();

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
        if ($this->authUserCannot('update-body')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $body = Body::find($id);
        $body->disabled = !$body->disabled;
        $body->save();

        return redirect()->back()->withSuccess('Certifying Board status toggled.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-body')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no Certifying Board selected.');
        }
        $arrCid = explode('|', $strCid);

        Body::destroy($arrCid);

        return redirect()->route('body_list_path')->withSuccess('Certifying Board deleted.');
    }

}
