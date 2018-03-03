<?php namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

use SortableTrait, SearchTrait;

class Facility extends BaseModel
{

    use SortableTrait, SearchTrait;  // not include SoftDeletes to alow logs to show info

    protected $dates = ['deleted_at'];

    protected $tablename = 'facilitites';

    protected $fillable = [
        'provider_id',
        'name',
        'contact_name',
        'deleted_at',
    ];

    public $sortable = [
        'name',
        'contact_name',
    ];

    public $searchable = [
        'name'         => 'LIKE',
        'contact_name' => 'LIKE',
        'childModels'  => [
            'Provider' => [
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

    /** Methods, Accessor(get) and Mutators(set) */

    public function getFullNameAttribute()
    {
        return trim($this->name);
    }

    public function delete()
    {
        $this->deleted_at = date('Y-m-d H:i:s');
        $this->save();
    }

    static public function institutionsCB($default = [])
    {
        $institutions = self::whereHas('provider', function($q){
            $q->where('provider_type_id', 2);
        })->orderBy('name')->lists('name', 'id')->toArray();

        if (!empty($default)) {
            return self::mergeAssoc($default, $institutions);
        }

        return $institutions;
    }

    // where word "hospital" exists in subtypes.

    static public function hospitalsCB($default = [])
    {
        $hospitals = self::whereHas('provider', function($q){
            $q->where('provider_type_id', 2)->whereHas('subType', function($p){
                $p->where('name', 'LIKE', '%hospital%');
            });
        })->orderBy('name')->lists('name', 'id')->toArray();

        if (!empty($default)) {
            return self::mergeAssoc($default, $hospitals);
        }

        return $hospitals;
    }

}
