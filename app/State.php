<?php namespace App;

use SortableTrait, SearchTrait;

class State extends BaseModel
{

    use SortableTrait, SearchTrait;

    public $timestamps  = false;

    protected $fillable = [
        'short_name',
        'name',
        'country_id',
        'disabled',
    ];

    public $sortable = [
        'short_name',
        'name',
    ];

    public $searchable = [
        'short_name' => 'LIKE',
        'name'       => 'LIKE',
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

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function providers()
    {
        return $this->hasMany('App\Provider');
    }

    public function addresses()
    {
        return $this->hasMany('App\Address');
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

    public function scopeCountry($query, $countryId, $amount = null)
    {
        $query->where('country_id', $countryId);
        if (!empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }

    public function scopeOrdered($query, $amount = null)
    {
        $query->orderBy('name');
        if (!empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }

    /** Methods, Accessor(get) and Mutators(set) */

    static public function statesCB($countryId, $default = [])
    {
        $states = self::where('country_id', $countryId)->orderBy('name')->lists('name', 'id')->toArray();

        if (!empty($default)) {
            return self::mergeAssoc($default, $states);
        }

        return $states;
    }

}
