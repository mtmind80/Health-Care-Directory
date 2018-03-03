<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use SortableTrait;
use SearchTrait;
use RuacTrait;
class User extends Authenticatable
{

    use SortableTrait, SearchTrait, RuacTrait;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'avatar',
        'disabled',
    ];

    protected $adminRoles = [
        'superadmin',
        'admin',
    ];

    protected $locked;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'disabled'];

    /** Sortable needed for sorted queries. Against this array is check run, if column name is not in array it will not work */

    public $sortable = [
        'first_name',
        'last_name',
        'email',
        'disabled',
    ];

    public $searchable = [
        'first_name' => 'LIKE',
        'last_name'  => 'LIKE',
        'email'      => 'LIKE',
    ];

    public function sortableColumns()
    {
        return $this->sortable;
    }

    public function searchableColumns()
    {
        return $this->searchable;
    }

    /** relationships */

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function privileges()
    {
        return $this->belongsToMany('App\Privilege');
    }

    public function logins()
    {
        return $this->hasMany('App\Login');
    }

    public function dueTasks()
    {
        return  \App\Task::due()->where('assigned_to', \Auth::user()->id)->get();
    }

    public function createdTasks()
    {
        return $this->hasMany('App\Task', 'creator_id');
    }

    public function AssignedTasks()
    {
        return $this->hasMany('App\Task', 'assigned_to_id');
    }

    public function logs()
    {
        return $this->hasMany('App\Logs');
    }

    public function assignedCredentials()
    {
        return $this->hasMany('App\Credential', 'assigned_to_id');
    }

    public function credentialDocumentActions()
    {
        return $this->hasMany('App\CredentialDocumentAction', 'user_id');
    }

    /** scopes */

    public function scopeNoRoot($query, $amount = null)
    {
        $query->where('user_id', '>', 2);  // mike and I
        if (!empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }

    /** Mutators and Accessors */

    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function getRoleNamesAttribute()
    {
        return $this->getUserRoles($this->id);
    }

    public function getPrivilegeNamesAttribute()
    {
        return $this->getUserPrivileges($this->id);
    }

    public function getRoleIdsAttribute()
    {
        return $this->getUserRolesIds($this->id);
    }

    public function getAssignedPrivilegeIdsAttribute()
    {
        return $this->getUserAssignedPrivilegesIds($this->id);
    }

    /** Methods */

    public function isSuperAdmin()
    {
        return $this->authUserIs('superadmin');
    }

    public function isAdmin()
    {
        return $this->authUserIs($this->adminRoles);
    }

    public function isAllowTo($actions = [])
    {
        return $this->userCan($this->id, $actions);
    }

    public function isNotAllowTo($actions = [])
    {
        return ! $this->userCan($this->id, $actions);
    }

    public function is($roles = [])
    {
        return $this->userIs($this->id, $roles);
    }

    public function isNot($roles = [])
    {
        return ! $this->userIsNot($this->id, $roles);
    }

    static public function usersCB($default = [], $excludeOwn = false)
    {
        $query = User::select(\DB::raw("CONCAT(first_name,' ',last_name) AS userName, id"));

        if ($excludeOwn) {
            $query->where('id', '!=', \Auth()->user()->id);
        }

        $users = $query->orderBy('userName')->lists('userName', 'id')->toArray();

        if (!empty($default)) {
            return self::mergeAssoc($default, $users);
        }

        return $users;
    }

    public function canToggleTaskStatus($task)
    {
        return $this->isAllowTo('complete-task') || $this->id == $task->creator_id || $this->id == $task->assigned_to_id;
    }

    static public function mergeAssoc($arr1, $arr2)
    {
        if (!is_array($arr1)) {
            $arr1 = [];
        }
        if (!is_array($arr2)) {
            $arr2 = [];
        }

        $keys1 = array_keys($arr1);
        $keys2 = array_keys($arr2);
        $keys = array_merge($keys1, $keys2);
        $vals1 = array_values($arr1);
        $vals2 = array_values($arr2);
        $vals = array_merge($vals1, $vals2);
        $ret = [];

        foreach ($keys as $key) {
            list(, $val) = each($vals);
            $ret[$key] = $val;
        }

        return $ret;
    }

}
