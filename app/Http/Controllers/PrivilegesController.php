<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Privilege;
use App\Http\Requests\PrivilegeRequest;
use App\Http\Requests\SearchRequest;

use EquationTrait;

class PrivilegesController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-privilege')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $privileges = Privilege::sortable()->paginate($perPage);
        $data = [
            'privileges' => $privileges,
            'needle'     => null,
            'encToken'   => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'seo'      => [
                'pageTitle'       => 'Privileges',
            ],
        ];

        return view('privilege.index', $data);
    }

    public function search(SearchRequest $request)
    {
        if ($this->authUserCannot('search-privilege')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $privileges = Privilege::search($needle)->sortable()->paginate($perPage);
        $data = [
            'privileges' => $privileges,
            'needle'     => $needle,
            'encToken'   => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'seo'      => [
                'pageTitle'       => 'Privileges',
            ],
        ];

        return view('privilege.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-privilege')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'equation' => $this->equation(),
            'seo'      => [
                'pageTitle'       => 'New Privilege',
            ],
        ];

        return view('privilege.create', $data);
    }

    public function store(PrivilegeRequest $request)
    {
        if ($this->authUserCannot('create-privilege')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['createCrud'])) {
            Privilege::create($request->all());

            return redirect()->route('privilege_list_path')->with('success', 'Privilege created.');
        } else {
            // create CRUD:
            $sufix = $inputs['privilege_name'];
            $totalCreated = 0;
            foreach ($this->_crud as $crud) {
                $privilegeName = $crud . '-' . $sufix;
                if (null === Privilege::where('privilege_name', $privilegeName)->first()) {
                    $inputs['privilege_name'] = $privilegeName;
                    Privilege::create($inputs);
                    $totalCreated++;
                }
            }

            if ($totalCreated > 0) {
                return redirect()->route('privilege_list_path')->with('success', 'CRUD set created for "'.$sufix.'".');
            } else {
                return redirect()->back()->with('error', 'CRUD set for "'.$sufix.'" already exists.');
            }
        }
    }

    public function inlineUpdate(Request $request)
    {
        if ($request->isMethod('post') && $request->ajax()) {
            $input = $request->all();

            $id = $input['pk'];
            $name = $input['name'];
            $value = $input['value'];
            $rule = (isset($input['rule'])) ? $input['rule'] : 'required|slug';

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
                    'message' => $validator->messages()->first()
                ];
            } else {
                $privilege = Privilege::find($id);
                $privilege->{$name} = $value;
                $privilege->save();

                $response = [
                    'status' => 'success',
                ];
            }
        } else {
            $response = [
                'status'  => 'error',
                'message' => 'Invalid request.'
            ];
        }

        return json_encode($response);
    }

    public function toggleStatus($id)
    {
        if ($this->authUserCannot('update-privilege')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $privilege = Privilege::find($id);
        $privilege->disabled = ! $privilege->disabled;
        $privilege->save();

        return redirect()->back()->with('success', 'Privilege status toggled.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-privilege')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->with('error', 'There is no item selected.');
        }
        $arrCid = explode('|', $strCid);

        Privilege::destroy($arrCid);

        return redirect()->route('privilege_list_path')->withSuccess('Privilege deleted.');
    }


}
