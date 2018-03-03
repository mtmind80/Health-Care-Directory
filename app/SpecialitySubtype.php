<?php namespace App;

use SortableTrait, SearchTrait;

class SpecialitySubtype extends BaseModel
{

    use SortableTrait, SearchTrait;

    protected $fillable = [
        'speciality_type_id',
        'name',
        'code',
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

    public function type()
    {
        return $this->belongsTo('App\SpecialityType', 'speciality_type_id');
    }


    /** scopes */

    public function scopeType($query, $countryId, $amount = null)
    {
        $query->where('speciality_type_id', $countryId);
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

    static public function specialitySubtypesCB($specialityTypeId, $default = [])
    {
        $specialitySubtypes = self::where('speciality_type_id', $specialityTypeId)->orderBy('name')->lists('name', 'id')->toArray();

        if (!empty($default)) {
            return self::mergeAssoc($default, $specialitySubtypes);
        }

        return $specialitySubtypes;
    }

}
