<?php namespace App;

use SortableTrait, SearchTrait;

class Action extends BaseModel
{

    use SortableTrait, SearchTrait;

    protected $fillable = [
        'name',
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

    public function logs()
    {
        return $this->hasMany('App\Log');
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

    static public function actionsCB($default = [])
    {
        $actions = self::orderBy('name')->lists('name', 'id')->toArray();

        if (!empty($default)) {
            return self::mergeAssoc($default, $actions);
        }

        return $actions;
    }

}
