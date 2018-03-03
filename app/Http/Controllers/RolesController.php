<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Role;
use App\Http\Requests\RoleRequest;

use EquationTrait;

class RolesController extends CommonController
{
    use EquationTrait;

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-role')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $roles = Role::sortable()->paginate($perPage);

        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'roles'    => $roles,
            'needle'   => null,
            'seo'      => [
                'pageTitle' => 'Roles',
            ],
        ];

        return view('role.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-role')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $roles = Role::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'roles'    => $roles,
            'needle'   => $needle,
            'seo'      => [
                'pageTitle' => 'Roles',
            ],
        ];

        return view('role.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-role')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken'     => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation'     => $this->equation(),
            'privilegesCB' => \App\Privilege::privilegesCB(),
            'seo'          => [
                'pageTitle' => 'Create Role',
            ],
        ];

        return view('role.create', $data);
    }

    public function store(RoleRequest $request)
    {
        if ($this->authUserCannot('create-role')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        $role = Role::create($inputs);

        $role->privileges()->attach($request->privileges);

        return redirect()->route('role_list_path')->withSuccess('Role created.');
    }

    public function edit(Role $role)
    {
        if ($role->id == 1) {
            return redirect()->back()->withError('root role cannot be modified.');
        }

        if ($this->authUserCannot('update-role')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken'     => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'role'         => $role,
            'equation'     => $this->equation(),
            'privilegesCB' => \App\Privilege::privilegesCB(),
            'seo'          => [
                'pageTitle' => 'Edit Role',
            ],
        ];

        return view('role.edit', $data);
    }

    public function update(Role $role, RoleRequest $request)
    {
        if ($role->id == 1) {
            return redirect()->back()->withError('root role cannot be modified.');
        }

        if ($this->authUserCannot('update-role')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        $role->update($inputs);

        $role->privileges()->detach();
        $role->privileges()->attach($request->privileges);

        return redirect()->route('role_list_path')->withSuccess('Role updated.');
    }

    public function inlineUpdate(Request $request)
    {
        if ($request->isMethod('post') && $request->ajax()) {
            $input = $request->all();

            $id = $input['pk'];

            if ($id == 1) {
                $response = [
                    'status'  => 'error',
                    'message' => 'root role cannot be modified.',
                ];
            } else {
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
                    $role = Role::find($id);
                    $role->{$name} = $value;
                    $role->save();

                    $response = [
                        'status' => 'success',
                    ];
                }
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
        if ($this->authUserCannot('update-role')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $role = Role::find($id);
        $role->disabled = !$role->disabled;
        $role->save();

        return redirect()->back()->withSuccess('Role status toggled.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-role')) {
            return redirect()->back()->withError(self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->withError('There is no role selected.');
        }
        $arrCid = explode('|', $strCid);

        Role::destroy($arrCid);

        return redirect()->route('role_list_path')->withSuccess('Role deleted.');
    }

    public function ajaxCreateFetchPrivileges(Request $request)
    {
        if ($request->isMethod('post') && $request->ajax()) {
            $input = $request->all();
            if ($roleName = $input['roleName']) {
                $inheritedPrivileges = $this->fetchInheritedPrivileges($roleName);
                $result = [
                    'success'             => true,
                    'inheritedPrivileges' => $inheritedPrivileges,
                    'availablePrivileges' => array_diff($this->fetchAllPrivileges(), $inheritedPrivileges),
                ];
            } else {
                $result = ['success' => false, 'message' => 'There is no info available.'];
            }
        } else {
            $result = ['success' => false, 'message' => 'Invalid request'];
        }

        return json_encode($result);
    }

    public function ajaxEditFetchPrivileges(Request $request)
    {
        if ($request->isMethod('post') && $request->ajax()) {
            $input = $request->all();
            if ($roleName = $input['roleName']) {
                $inheritedPrivileges = $this->fetchInheritedPrivileges($roleName);
                $result = [
                    'success'                   => true,
                    'inheritedPrivileges'       => $inheritedPrivileges,
                    'ownPrivileges'             => array_values($this->fetchOwnPrivileges($roleName)),
                    'ownAndAvailablePrivileges' => array_diff($this->fetchAllPrivileges(), $inheritedPrivileges),
                ];
            } else {
                $result = ['success' => false, 'message' => 'There is no info available.'];
            }
        } else {
            $result = ['success' => false, 'message' => 'Invalid request'];
        }

        return json_encode($result);
    }


}
