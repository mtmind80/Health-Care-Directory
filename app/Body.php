<?php namespace App;

use SortableTrait, SearchTrait;

class Body extends BaseModel
{

    use SortableTrait, SearchTrait;

    protected $tablename = 'bodies';

    protected $fillable = [
        'name',
        'disabled',
    ];

    public $sortable = [
        'name',
    ];

    public $searchable = [
        'name' => 'LIKE',
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

    /* update later
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
    */


    /** scopes */

    public function scopeOrdered($query, $amount = null)
    {
        $query->orderBy('name'); // leave "Others" at the end
        if (!empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }

    /** Methods, Accessor(get) and Mutators(set) */

    static public function bodiesCB($default = [])
    {
        $bodies = self::orderBy('name')->lists('name', 'id')->toArray();

        if (!empty($default)) {
            return self::mergeAssoc($default, $bodies);
        }

        return $bodies;
    }

}