<?php namespace App;

use SortableTrait, SearchTrait;

class Country extends BaseModel
{

    use SortableTrait, SearchTrait;

    protected $tablename = 'countries';

    public $timestamps  = false;

    protected $fillable = [
        'name',
        'short_name',
    ];

    public $sortable = [
        'name',
        'short_name',
    ];

    public $searchable = [
        'name'       => 'LIKE',
        'short_name' => 'LIKE',
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

    public function states()
    {
        return $this->hasMany('App\State');
    }

    public function providers()
    {
        return $this->hasMany('App\Provider');
    }

    public function insurers()
    {
        return $this->hasMany('App\Insurer');
    }

    public function schools()
    {
        return $this->hasMany('App\School');
    }

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

    static public function countriesCB($default = [])
    {
        $countries = self::orderBy('name')->lists('name', 'id')->toArray();

        if (!empty($default)) {
            return self::mergeAssoc($default, $countries);
        }

        return $countries;
    }

}
