<?php namespace App;

use SortableTrait, SearchTrait;

class ProviderSubtype extends BaseModel
{

    use SortableTrait, SearchTrait;

    protected $fillable = [
        'name',
        'provider_type_id',
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

    public function type()
    {
        return $this->belongsTo('App\ProviderType', 'provider_type_id');
    }

    public function providers()
    {
        return $this->hasMany('App\Provider');
    }

    /** scopes */

    public function scopeProviderType($query, $providerTypeId, $amount = null)
    {
        $query->where('provider_type_id', $providerTypeId);
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

    static public function providerSubtypesCB($providerTypeId, $default = [])
    {
        $providerSubtypes = self::where('provider_type_id', $providerTypeId)->orderBy('name')->lists('name', 'id');

        if (!empty($default)) {
            return self::mergeAssoc($default, $providerSubtypes);
        }

        return $providerSubtypes;
    }


}
