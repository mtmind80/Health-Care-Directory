<?php namespace App;

use SortableTrait, SearchTrait, ToolTrait;

class School extends BaseModel
{

    use SortableTrait, SearchTrait, ToolTrait;

    protected $fillable = [
        'name',
        'address',
        'address_2',
        'city',
        'state_id',
        'country_id',
        'zipcode',
        'email',
        'phone',
        'fax',
        'contact_name',
        'disabled',
    ];

    public $sortable = [
        'name',
        'email',
        'phone',
        'fax',
        'contact_name',
        'countries.name|schools.country_id',
        'states.full_name|schools.state_id',
    ];

    public $searchable = [
        'name'        => 'LIKE',
        'address'     => 'LIKE',
        'city'        => 'LIKE',
        'zipcode'     => 'LIKE',
        'email'       => 'LIKE',
        'phone'       => 'LIKE',
        'fax'         => 'LIKE',
        'childModels' => [
            'state' => [
                'fields' => [
                    'full_name' => 'LIKE',
                ],
            ],
            'country' => [
                'fields' => [
                    'name' => 'LIKE',
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

    public function state()
    {
        return $this->belongsTo('App\State');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
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

    static public function schoolsCB($default = [])
    {
        $schools = self::orderBy('name')->lists('name', 'id')->toArray();

        if (!empty($default)) {
            return self::mergeAssoc($default, $schools);
        }

        return $schools;
    }

}
