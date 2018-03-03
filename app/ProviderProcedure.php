<?php namespace App;

use SortableTrait, SearchTrait;

class ProviderProcedure extends BaseModel
{

    use SortableTrait, SearchTrait;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'provider_id',
        'procedure_id',
        'comment',
        'deleted_at',
    ];

    public $sortable = [
        'procedures.name|provider_procedures.procedure_id',
    ];

    public $searchable = [
        'comment'     => 'LIKE',
        'childModels' => [
            'procedure' => [
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

    public function procedure()
    {
        return $this->belongsTo('App\Procedure');
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
