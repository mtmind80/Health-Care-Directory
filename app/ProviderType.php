<?php namespace App;

use SortableTrait, SearchTrait;

class ProviderType extends BaseModel
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

    public function providers()
    {
        return $this->hasMany('App\Provider');
    }

    public function subTypes()
    {
        return $this->hasMany('App\ProviderSubtypes');
    }


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

    static public function providerTypesCB($default = [])
    {
        $providerTypes = self::orderBy('d_sort')->orderBy('name')->lists('name', 'id')->toArray();

        if (!empty($default)) {
            return self::mergeAssoc($default, $providerTypes);
        }

        return $providerTypes;
    }

}
