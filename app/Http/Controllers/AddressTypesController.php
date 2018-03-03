<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\AddressType;
use App\Http\Requests\AddressTypeRequest;

use EquationTrait;

class AddressTypesController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-addresstype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $addressTypes = AddressType::sortable()->paginate($perPage);

        $data = [
            'encToken'     => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'addressTypes' => $addressTypes,
            'needle'       => null,
            'seo'          => [
                'pageTitle' => 'Address Types',
            ],
        ];

        return view('addresstype.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-addresstype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $addressTypes = AddressType::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken'     => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'addressTypes' => $addressTypes,
            'needle'       => $needle,
            'seo'          => [
                'pageTitle' => 'Address Types',
            ],
        ];

        return view('addresstype.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-addresstype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation' => $this->equation(),
            'seo'      => [
                'pageTitle' => 'Create Address Type',
            ],
        ];

        return view('addresstype.create', $data);
    }

    public function store(AddressTypeRequest $request)
    {
        if ($this->authUserCannot('create-addresstype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        AddressType::create($inputs);

        return redirect()->route('address_type_list_path')->withSuccess('Address type created.');
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
                $AddressType = AddressType::find($id);
                $AddressType->{$name} = $value;
                $AddressType->save();

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
        if ($this->authUserCannot('update-addresstype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $AddressType = AddressType::find($id);
        $AddressType->disabled = !$AddressType->disabled;
        $AddressType->save();

        return redirect()->back()->withSuccess('Address type status toggled.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-addresstype')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no address type selected.');
        }
        $arrCid = explode('|', $strCid);

        AddressType::destroy($arrCid);

        return redirect()->route('address_type_list_path')->withSuccess('Address type deleted.');
    }

}
