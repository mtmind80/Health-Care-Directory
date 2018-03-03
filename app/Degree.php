<?php namespace App;

use SortableTrait, SearchTrait;

class Degree extends BaseModel
{

    use SortableTrait, SearchTrait;

    protected $fillable = [
        'short_name',
        'full_name',
        'disabled',
    ];

    public $sortable = [
        'short_name',
        'full_name',
    ];

    public $searchable = [
        'short_name' => 'LIKE',
        'full_name'  => 'LIKE',
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

    static public function degreesCB($default = [])
    {
        $degrees = self::orderBy('short_name')->lists('short_name', 'id')->toArray();

        if (!empty($default)) {
            return self::mergeAssoc($default, $degrees);
        }

        return $degrees;
    }

}
