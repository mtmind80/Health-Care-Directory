<?php namespace App;

use SortableTrait, SearchTrait;

class Certification extends BaseModel
{

    use SortableTrait, SearchTrait;

    protected $fillable = [
        'name',
        'code',
        'd_sort',
        'disabled',
    ];

    public $sortable = [
        'name',
        'code',
    ];

    public $searchable = [
        'name' => 'LIKE',
        'code' => 'LIKE',
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
        $query->orderBy('d_sort')->orderBy('name'); // leave "Others" at the end
        if (!empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }

    /** Methods, Accessor(get) and Mutators(set) */

    static public function certificationsCB($default = [])
    {
        $certifications = self::orderBy('d_sort')->orderBy('name')->lists('name', 'id')->toArray();

        if (!empty($default)) {
            return self::mergeAssoc($default, $certifications);
        }

        return $certifications;
    }

}
