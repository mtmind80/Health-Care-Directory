<?php namespace App;

use SortableTrait, SearchTrait;

class OffenseType extends BaseModel
{

    use SortableTrait, SearchTrait;

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

    static public function offenseTypesCB($default = [])
    {
        $offenseTypes = self::orderBy('name')->lists('name', 'id')->toArray();

        if (!empty($default)) {
            return self::mergeAssoc($default, $offenseTypes);
        }

        return $offenseTypes;
    }

}
