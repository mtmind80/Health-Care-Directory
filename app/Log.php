<?php namespace App;

use SortableTrait;
use SearchTrait;

class Log extends BaseModel
{

    use SortableTrait, SearchTrait;

    protected $fillable = [
        'provider_id',
        'action_id',
        'user_id',
        'comment',
        'json_data',
    ];

    public $sortable = [
        'created_at',
        'users.first_name|logs.user_id',
        'actions.name|logs.action_id',
    ];

    public $searchable = [
        'comment'     => 'LIKE',
        'updated_at'  => '=',
        'childModels' => [
            'user'   => [
                'fields' => [
                    'first_name' => 'LIKE',
                    'last_name'  => 'LIKE',
                ],
            ],
            'action' => [
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

    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function action()
    {
        return $this->belongsTo('App\Action');
    }

    /** scopes */

    public function scopeOrdered($query, $amount = null)
    {
        $query->orderBy('created_at', 'DESC');
        if (!empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }

    /** Mutators and Accessors */

    public function getModificationsAttribute()
    {
        return !empty($this->json_data) ? json_decode($this->json_data) : [];
    }
}
