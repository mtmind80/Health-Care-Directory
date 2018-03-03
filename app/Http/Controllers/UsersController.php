<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\User;
use App\Http\Requests\UserRequest;

use UserObserver;

use EquationTrait;
use ImageTrait;
use StringTrait;

class UsersController extends CommonController
{
    use EquationTrait, ImageTrait, StringTrait;

    public function __construct()
    {
        parent::__construct();

        User::observe(new UserObserver);
    }

    public function index(Request $request)
    {
        if ($this->authUserCannot('list-user')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $users = User::sortable()->paginate($perPage);
        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'users'    => $users,
            'needle'   => null,
            'seo'      => [
                'pageTitle' => 'Users',
            ],
        ];

        return view('user.index', $data);
    }

    public function search(Request $request)
    {
        if ($this->authUserCannot('search-user')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $this->validate($request, [
            'needle' => 'min:3',
        ]);

        $needle = $request->needle;
        $perPage = $request->input('perPage') ? $request->input('perPage') : 10;
        $users = User::search($needle)->sortable()->paginate($perPage);
        $data = [
            'encToken' => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'users'    => $users,
            'needle'   => $needle,
            'seo'      => [
                'pageTitle' => 'Users',
            ],
        ];

        return view('user.index', $data);
    }

    public function create()
    {
        if ($this->authUserCannot('create-user')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $data = [
            'encToken'     => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'equation'     => $this->equation(),
            'rolesCB'      => \App\Role::rolesCB(null, $this->authUserIsNot('root')),
            'privilegesCB' => \App\Privilege::privilegesCB(),
            'seo'          => [
                'pageTitle' => 'New User',
            ],
        ];

        return view('user.create', $data);
    }

    public function store(UserRequest $request)
    {
        if ($this->authUserCannot('create-user')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $user = User::create($request->all());

        $user->roles()->attach($request->roles);
        $user->privileges()->attach($request->privileges);

        return redirect()->route('user_list_path')->with('success', 'User created.');
    }

    public function show(User $user)
    {
        if ($this->authUserCannot('show-user')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }
    }

    public function edit(User $user)
    {
        if ($this->authUserCannot('update-user')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $editableUser = User::find($user->id);

        if (!empty($editableUser->role)) {
            $roleName = $editableUser->role->role_name;

            if (!$this->hasRole($roleName)) {
                return redirect()->back()->with('error', 'You cannot modify a user with a higher role than yours.');
            }
        }

        $data = [
            'encToken'          => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'user'              => $user,
            'equation'          => $this->equation(),
            'rolesCB'           => \App\Role::rolesCB(null, $this->authUserIsNot('root')),
            'privilegesCB'      => \App\Privilege::privilegesCB(),
            'rolesPrivilegesCB' => $this->getUserRolesPrivilegesIds($user->id),
            'seo'               => [
                'pageTitle' => 'Edit: ' . $user->fullName,
            ],
        ];

        return view('user.edit', $data);
    }

    public function profile()
    {
        $data = [
            'encToken'          => app('Illuminate\Encryption\Encrypter')->encrypt(csrf_token()),
            'user'              => \Auth::user(),
            'equation'          => $this->equation(),
            'returnTo'          => \URL::previous(),
            'rolesCB'           => \App\Role::rolesCB(null, $this->authUserIsNot('root')),
            'privilegesCB'      => \App\Privilege::privilegesCB(),
            'rolesPrivilegesCB' => $this->getUserRolesPrivilegesIds(\Auth::user()->id),
            'seo'               => [
                'pageTitle' => 'Profile: ' . \Auth::user()->fullName,
            ],
        ];

        return view('user.profile', $data);
    }

    public function updateProfile(User $user, UserRequest $request)
    {
        if (\Auth::user()->id != $user->id && !\Auth::user()->hasRole('admin')) {
            return redirect()->back()->with('error', 'You cannot modify another user\'s info.');
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        $user->update($inputs);

        return redirect()->back()->with('success', 'Profile updated.');
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
                $user = User::find($id);
                $user->{$name} = $value;
                $user->save();

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

    public function update(User $user, UserRequest $request)
    {
        if ($this->authUserCannot('update-user')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $inputs = $request->all();

        if (empty($inputs['disable'])) {
            $inputs['disable'] = 0;
        }

        $user->update($inputs);

        if ($user->id != \Auth::user()->id) {
            $user->roles()->detach();
            $user->roles()->attach($request->roles);

            $user->privileges()->detach();
            $user->privileges()->attach($request->privileges);
        }

        return redirect()->route('user_list_path')->with('success', 'User updated.');
    }

    public function toggleStatus($id)
    {
        if ($this->authUserCannot('update-user')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $user = User::find($id);
        $user->disabled = !$user->disabled;
        $user->save();

        return redirect()->back()->with('success', 'User status has been toggled.');
    }

    public function destroy(Request $request)
    {
        if ($this->authUserCannot('delete-user')) {
            return redirect()->back()->with('error', self::ERROR_NOT_ENOUGH_PRIVILEGES);
        }

        $strCid = $request->input('strCid');
        if (empty($strCid)) {
            return redirect()->back()->with('error', 'There is no user selected.');
        }
        $arrCid = explode('|', $strCid);

        User::destroy($arrCid);

        return redirect()->route('user_list_path')->withSuccess('User deleted.');
    }

    public function uploadCanvas(Request $request)
    {
        if ($request->isMethod('post') && $request->ajax()) {
            $input = $request->all();

            $data = $input['data'];
            $originalFileName = $input['name'];
            $original = (!empty($input['original'])) ? $input['original'] : null;

            $serverDir = storage_path() . '/tmp/';

            list(, $tmp) = explode(',', $data);
            $imgData = base64_decode($tmp);

            $nameInfo = pathinfo($originalFileName);
            $ranStr = substr(sha1(time()), 0, 6);

            $newFileName = $this->cleanFileName($nameInfo['filename']) . '-' . $ranStr . '.' . $nameInfo['extension'];

            $handle = fopen($serverDir . $newFileName, 'w');
            fwrite($handle, $imgData);
            fclose($handle);

            $response = [
                'status'           => 'success',
                'url'              => $newFileName . '?' . time(), // added the time to force update when editting multiple times
                'originalFileName' => $originalFileName,
                'newFileName'      => $newFileName,
            ];

            if (!empty($original)) {
                list(, $tmp) = explode(',', $original);
                $originalData = base64_decode($tmp);

                $original = $nameInfo['filename'] . '-' . $ranStr . '-original' . $nameInfo['extension'];

                $handle = fopen($serverDir . $original, 'w');
                fwrite($handle, $originalData);
                fclose($handle);

                $response['original'] = $original;
            }
        } else {
            $response = ['status' => 'error', 'message' => 'Invalid request.'];
        }

        return json_encode($response);
    }

    public function deleteCanvas(Request $request)
    {
        if ($request->isMethod('post') && $request->ajax()) {
            $input = $request->all();

            $image = (!empty($input['image'])) ? $input['image'] : null;
            $id = (!empty($input['id']));

            $serverDir = storage_path() . '/tmp/';

            if (!empty($image) && file_exists($serverDir . $image)) {
                unlink($serverDir . $image);
            }

            if ($id) {
                // delete from avatars folder and database:
                if ($this->s3) {                                                           // in S3 public folder
                    if (Storage::disk('s3')->exists('public/images/avatars/' . $image)) {
                        Storage::disk('s3')->delete('public/images/avatars/' . $image);
                    }
                } else {                                                                    // in local public folder
                    $avatarsPath = public_path() . '/images/avatars/';
                    if (file_exists($avatarsPath . $image)) {
                        unlink($avatarsPath . $image);
                    }
                }
                User::find($id)->update(array('avatar' => null));
            }

            $response = ['status' => 'success'];
        } else {
            $response = ['status' => 'error', 'message' => 'Invalid request.'];
        }

        return json_encode($response);
    }

    public function ajaxFetchRolesPrivileges(Request $request)
    {
        if ($request->isMethod('post') && $request->ajax()) {
            $rolesPrivilegesIds = [];

            if ($request->roleIds) {
                $roleIds = json_decode($request->roleIds);
                if ($roles = \App\Role::whereIn('id', $roleIds)->get()) {
                    foreach ($roles as $role) {
                        foreach ($role->privileges as $privilege) {
                            if (!in_array($privilege->id, $rolesPrivilegesIds)) {
                                $rolesPrivilegesIds[] = $privilege->id;
                            }
                        }
                    }
                }
                $result = [
                    'success'            => true,
                    'rolesPrivilegesIds' => $rolesPrivilegesIds,
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
