<?php namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

use SortableTrait, SearchTrait;

class Provider extends BaseModel
{

    use SortableTrait, SearchTrait;  // not include SoftDeletes to alow logs to show info

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'provider_type_id',
        'provider_subtype_id',
        'address',
        'address_2',
        'city',
        'state_id',
        'country_id',
        'zipcode',
        'email',
        'phone',
        'fax',
        'under_contract',
        'deleted_at',
    ];

    public $sortable = [
        'address',
        'email',
        'phone',
        'fax',
        'contact_name',
        'under_contract',
        'provider_types.name|providers.provider_type_id',
        'provider_subtypes.name|providers.provider_subtype_id',
        'countries.name|providers.country_id',
        'states.full_name|providers.state_id',
    ];

    public $searchable = [
        'address'      => 'LIKE',
        'city'         => 'LIKE',
        'zipcode'      => 'LIKE',
        'email'        => 'LIKE',
        'phone'        => 'LIKE',
        'fax'          => 'LIKE',
        'childModels'   => [
            'type' => [
                'fields' => [
                    'name' => 'LIKE',
                ],
            ],
            'subType' => [
                'fields' => [
                    'name' => 'LIKE',
                ],
            ],
            'state' => [
                'fields' => [
                    'name' => 'LIKE',
                ],
            ],
            'country' => [
                'fields' => [
                    'name' => 'LIKE',
                ],
            ],
            'professional' => [
                'fields' => [
                    'first_name' => 'LIKE',
                ],
            ],
            'facility' => [
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

    public function type()
    {
        return $this->belongsTo('App\ProviderType', 'provider_type_id');
    }

    public function subType()
    {
        return $this->belongsTo('App\ProviderSubtype', 'provider_subtype_id');
    }

    public function state()
    {
        return $this->belongsTo('App\State');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function professional()
    {
        return $this->hasOne('App\Professional');
    }

    public function facility()
    {
        return $this->hasOne('App\Facility');
    }

    public function logs()
    {
        return $this->hasMany('App\Log');
    }

    public function credentials()
    {
        return $this->hasMany('App\Credential');
    }

    public function addresses()
    {
        return $this->hasMany('App\ProviderAddress', 'provider_id');
    }

    public function malpractices()
    {
        return $this->hasMany('App\ProviderMalpractice', 'provider_id');
    }

    public function references()
    {
        return $this->hasMany('App\ProviderReference', 'provider_id');
    }

    public function conditions()
    {
        return $this->hasMany('App\ProviderCondition', 'provider_id');
    }

    public function procedures()
    {
        return $this->hasMany('App\ProviderProcedure', 'provider_id');
    }


    /** scopes */

    public function scopeOrdered($query, $amount = null)
    {
        $query->orderBy('name');
        if (!empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }

    public function scopeActive($query, $amount = null)
    {
        $query->whereNull('deleted_at');
        if (!empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }

    public function scopeConditionFilter($query, $condition_id)
    {
        if (!empty($condition_id)) {
            $query->whereHas('provider_conditions', function($q) use ($condition_id) {
                $q->where('condition_id', $condition_id);
            });
        }

        return $query;
    }

    public function scopeProcedureFilter($query, $procedure_id)
    {
        if (!empty($procedure_id)) {
            $query->whereHas('procedures', function($q) use ($procedure_id) {
                $q->where('procedure_id', $procedure_id);
            });
        }

        return $query;
    }

    public function scopeLocationFilter($query, $city, $zipcode, $state_id, $country_id)
    {
        if (!empty($city)) {
            $query->where('city', 'LIKE', '%'.$city.'%');
        }

        if (!empty($zipcode)) {
            $query->where('zipcode', 'LIKE', '%'.$zipcode.'%');
        }

        if (!empty($state_id)) {
            $query->where('state_id', $state_id);
        }

        if (!empty($country_id)) {
            $query->where('country_id', $country_id);
        }

        return $query;
    }

    public function scopeProviderTypeFilter($query, $provider_type_id, $provider_subtype_id)
    {
        if (!empty($provider_type_id)) {
            $query->where('provider_type_id', $provider_type_id);
        }

        if (!empty($provider_subtype_id)) {
            $query->where('provider_subtype_id', $provider_subtype_id);
        }

        return $query;
    }

    /** Methods, Accessor(get) and Mutators(set) */

    public function getIsProfessionalAttribute()
    {
        return $this->subType->provider_type_id == 1;
    }

    public function getHtmlIsUnderContractAttribute()
    {
        return $this->under_contract ? '<span class="color-blue">Yes</span>' : '<span class="color-red">No</span>';
    }

    public function getNameAttribute()
    {
        return $this->isProfessional ? $this->professional->fullName : $this->facility->name;
    }

    /** Methods */

    static public function ProvidersCB($default = [])
    {
        $providers = self::orderBy('name')->lists('name', 'id')->toArray();

        if (!empty($default)) {
            return self::mergeAssoc($default, $providers);
        }

        return $providers;
    }

    // override Eloquent's method:

    public function delete()
    {
        $this->deleted_at = date('Y-m-d H:i:s');
        $this->save();
    }



}
