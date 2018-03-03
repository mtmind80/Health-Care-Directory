<?php namespace App;

use SortableTrait, SearchTrait;

class ProviderAddress extends BaseModel
{

    use SortableTrait, SearchTrait;

    protected $tablename = 'provider_addresses';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'provider_id',
        'address_type_id',
        'address',
        'address_2',
        'city',
        'state_id',
        'country_id',
        'zipcode',
        'deleted_at',
    ];

    public $sortable = [
        'city',
        'address_types.name|provider_addresses.address_type_id',
        'states.full_name|provider_addresses.state_id',
        'countries.name|provider_addresses.country_id',
    ];

    public $searchable = [
        'address'     => 'LIKE',
        'city'        => 'LIKE',
        'childModels' => [
            'type'    => [
                'fields' => [
                    'name' => 'LIKE',
                ],
            ],
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

    public function providers()
    {
        return $this->hasMany('App\Provider');
    }

    public function type()
    {
        return $this->belongsTo('App\AddressType', 'address_type_id');
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


    /** Methods */

    public function delete()
    {
        $this->deleted_at = date('Y-m-d H:i:s');
        $this->save();
    }

}
