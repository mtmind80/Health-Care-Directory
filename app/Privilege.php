<?php namespace App;

use SortableTrait;
use SearchTrait;

class Privilege extends BaseModel {

    use SortableTrait, SearchTrait;

    protected $fillable = [
        'privilege_name',
    ];

    public $sortable = [
        'privilege_name',
    ];

    public $searchable = [
        'privilege_name' => 'LIKE',
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

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    /** scopes */

    public function scopeOrdered($query, $amount = null)
    {
        $query->orderBy('privilege_name');
        if (!empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }

    /** Methods, Accessor(get) and Mutators(set) */

    static public function privilegesCB($default = [])
    {
        $roles = self::orderBy('privilege_name')->lists('privilege_name', 'id')->toArray();

        if (!empty($default)) {
            return array_merge($default, $roles);
        }
        return $roles;
    }

}
