<?php namespace App;

use SortableTrait, SearchTrait;

class Task extends BaseModel
{

    use SortableTrait, SearchTrait;

    protected $dates = ['remind_at', 'due_at', 'completed_at'];

    protected $fillable = [
        'creator_id',
        'assigned_to_id',
        'title',
        'content',
        'response',
        'reminder_sent',
        'completed',
        'remind_at',
        'due_at',
        'completed_at',
    ];

    public $sortable = [
        'completed',
        'reminder_sent',
        'remind_at',
        'due_at',
        'completed_at',
        'created_at',
        'users.first_name|tasks.creator_id',
        'users.first_name|tasks.assigned_to_id',
    ];

    public $searchable = [
        'title'         => 'LIKE',
        'content'       => 'LIKE',
        'response'      => 'LIKE',
        'reminder_sent' => '=',
        'remind_at'     => '=',
        'due_at'        => '=',
        'completed_at'  => '=',
        'created_at'    => '=',
        'childModels'   => [
            'creator'    => [
                'fields' => [
                    'first_name' => 'LIKE',
                    'last_name'  => 'LIKE',
                ],
            ],
            'assignedTo' => [
                'fields' => [
                    'first_name' => 'LIKE',
                    'last_name'  => 'LIKE',
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

    public function creator()
    {
        return $this->belongsTo('App\User', 'creator_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo('App\User', 'assigned_to_id');
    }


    /** scopes */

    public function scopeOrdered($query, $amount = null)
    {
        $query->orderBy('due_at');
        if (!empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }

    public function scopeMine($query, $amount = null) // not completed
    {
        $query->where('assigned_to_id', \Auth::user()->id);
        if (!empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }

    public function scopePending($query, $amount = null) // not completed
    {
        $query->where('completed', 0);
        if (!empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }

    public function scopeShouldBeRemainded($query, $amount = null)
    {
        $query->where('completed', 0)->whereNotNull('remind_at')->where('remind_at', date('Y-m-d'))->where('reminder_sent', 0);
        if (!empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }

    /** Methods, Accessor(get) and Mutators(set) */

    public function getHtmlCompletedAttribute()
    {
        return (boolean)$this->isCompleted() ? '<span class="status completed">Yes</span>' : '<span class="status incompleted">No</span>';
    }

    public function getHtmlDueAtAttribute()
    {
        return $this->due_at->format('M. d, Y') . ($this->isDue() ? '<i class="fa fa-exclamation-triangle ml5 status due" data-toggle="tooltip" title="This task is due"></i>' : '');
    }

    /** Methods */

    public function isCompleted()
    {
        return (boolean)$this->completed;
    }

    public function isDue()
    {
        return !$this->completed && !empty($this->due_at) && $this->due_at->lte(\Carbon\Carbon::now());
    }

}
