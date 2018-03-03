<?php namespace App;

use SortableTrait, SearchTrait;

class Identification extends BaseModel
{

    use SortableTrait, SearchTrait;

    protected $fillable = [
        'name',
        'licence',
        'disabled',
    ];

    public $sortable = [
        'name',
        'licence',
    ];

    public $searchable = [
        'name'    => 'LIKE',
        'licence' => '=',
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

    public function professionals()
    {
        return $this->hasMany('App\ProfessionalIdentification', 'identification_id');
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

    static public function identificationsCB($default = [])
    {
        $identifications = self::orderBy('name')->lists('name', 'id')->toArray();

        if (!empty($default)) {
            return self::mergeAssoc($default, $identifications);
        }

        return $identifications;
    }

    public function getIsLicenceAttribute()
    {
        return $this->licence ? 'Yes' : 'No';
    }

}
