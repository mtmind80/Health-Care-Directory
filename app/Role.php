<?php namespace App;

use SortableTrait, SearchTrait;

class Role extends BaseModel
{

    use SortableTrait, SearchTrait;

    protected $fillable = [
        'role_name',
        'disabled',
    ];

    public $sortable = [
        'role_name',
    ];

    public $searchable = [
        'role_name' => 'LIKE',
        'childModels'   => [
            'privileges' => [
                'fields' => [
                    'privilege_name' => 'LIKE',
                ],
            ],
        ],
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

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function privileges()
    {
        return $this->belongsToMany('App\Privilege');
    }

    public function children()
    {
        return $this->hasMany('App\RoleChildren');
    }

    /** scopes */


    public function scopeOrdered($query, $amount = null)
    {
        $query->orderBy('role_name');
        if (!empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }

    /** Methods, Accessor(get) and Mutators(set) */

    static public function rolesCB($default = [], $excludeRoot = true)
    {
        $roles = ($excludeRoot) ? self::where('role_name', '!=', 'root')->orderBy('role_name')->lists('role_name', 'id')->toArray() : self::orderBy('role_name')->lists('role_name', 'id')->toArray();

        if (!empty($default)) {
            return array_merge($default, $roles);
        }
        return $roles;
    }

    public function getPrivilegeNamesAttribute()
    {
        $privileges = [];

        if ($this->privileges->count()) {
            foreach ($this->privileges as $privilege) {
                if (!in_array($privilege->privilege_name, $privileges)) {
                    $privileges[] = $privilege->privilege_name;
                }
            }
        }

        return $privileges;
    }

}
