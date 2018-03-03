<?php namespace App;

use SortableTrait, SearchTrait;

class ProviderReference extends BaseModel
{

    use SortableTrait, SearchTrait;

    protected $dates = ['known_at', 'deleted_at'];

    protected $fillable = [
        'provider_id',
        'name',
        'title',
        'address',
        'address_2',
        'city',
        'state_id',
        'country_id',
        'zipcode',
        'email',
        'phone',
        'fax',
        'known_at',
        'comment',
        'deleted_at',
    ];

    public $sortable = [
        'name',
        'title',
        'email',
        'phone',
        'states.full_name|provider_references.state_id',
        'countries.name|provider_references.country_id',
    ];

    public $searchable = [
        'name'        => 'LIKE',
        'title'       => 'LIKE',
        'address'     => 'LIKE',
        'city'        => 'LIKE',
        'email'       => 'LIKE',
        'phone'       => 'LIKE',
        'childModels' => [
            'state'   => [
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

    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }

    public function state()
    {
        return $this->belongsTo('App\State');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }


    /** scopes */

    public function scopeActive($query, $amount = null)
    {
        $query->whereNull('deleted_at');
        if (!empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }

    public function scopeProvider($query, $providerId, $amount = null)
    {
        $query->where('provider_id', $providerId);
        if (!empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }

    /** Accessor(get) and Mutators(set) */

    public function getHtmlKnownAtAttribute()
    {
        return !empty($this->known_at) ? $this->known_at->format('Y') : '';
    }

    public function setKnownAtAttribute($value)
    {
        $this->attributes['known_at'] = !empty($value) ? $value : null;
    }

    /** Methods */

    public function delete()
    {
        $this->deleted_at = date('Y-m-d H:i:s');
        $this->save();
    }

}
