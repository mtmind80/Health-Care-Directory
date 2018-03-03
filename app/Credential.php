<?php namespace App;

use SortableTrait, SearchTrait;

class Credential extends BaseModel
{
    protected $credentialLifeSpan = 2;  // years

    use SortableTrait, SearchTrait;

    protected $fillable = [
        'customer_id',
        'provider_id',
        'professional_id',
        'status_id',
        'assigned_to_id',
        'opened_at',
        'completed_at',
    ];

    protected $dates = ['opened_at', 'completed_at'];

    public $sortable = [
        'opened_at',
        'completed_at',
        'customers.name|credentials.customer_id',
        'professionals.first_name|credentials.professional_id',
        'credential_status.name|credentials.status_id',
        'users.first_name|credentials.assigned_to_id',
    ];

    public $searchable = [
        'opened_at'    => '=',
        'completed_at' => '=',
        'childModels'  => [
            'customer'    => [
                'fields' => [
                    'name' => 'LIKE',
                ],
            ],
            'professional' => [
                'fields' => [
                    'first_name' => 'LIKE',
                    'last_name'  => 'LIKE',
                ],
            ],
            'status'      => [
                'fields' => [
                    'name' => 'LIKE',
                ],
            ],
            'assignedTo'  => [
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

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }

    public function professional()
    {
        return $this->belongsTo('App\Professional');
    }

    public function status()
    {
        return $this->belongsTo('App\CredentialStatus', 'status_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo('App\User', 'assigned_to_id');
    }

    public function documents()
    {
        return $this->hasMany('App\CredentialDocument', 'credential_id');
    }


    /** scopes */

    public function scopeCompleted($query, $amount = null)
    {
        $query->where('completed_at', '<=', date('Y-m-d'));
        if (!empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }


    /** Accessors(getters) and Mutators(setters) */

    public function getHtmlOpenedAtAttribute()
    {
        return !empty($this->opened_at) ? $this->opened_at->format('m/d/Y') : '';
    }

    public function getHtmlCompletedAtAttribute()
    {
        return !empty($this->completed_at) ? (!empty($this->completed_at) ? $this->completed_at->format('m/d/Y') . '<i class="fa fa-check-circle ml5 status completed" data-toggle="tooltip" title="This credential is completed"></i>' : '') : '';
    }

    public function getExpiredAtAttribute()
    {
        return !empty($this->completed_at) ? $this->completed_at->addYears($this->credentialLifeSpan) : null;
    }

    public function getHtmlExpiredAtAttribute()
    {
        return !empty($this->expired_at) ? ($this->expired_at->format('m/d/Y') . ($this->isExpired() ? '<i class="fa fa-exclamation-triangle ml5 status expired" data-toggle="tooltip" title="This credential has expired"></i>' : '')) : '';
    }

    public function setOpenedAtAttribute($value)
    {
        $this->attributes['opened_at'] = (!empty($value)) ? date('Y-m-d', strtotime($value)) : null;
    }

    public function setCompletedAtAttribute($value)
    {
        $this->attributes['completed_at'] = (!empty($value)) ? date('Y-m-d', strtotime($value)) : null;
    }

    /** Methods */

    public function isCompleted()
    {
        return !empty($this->completed_at);
    }

    public function isExpired()
    {
        return !empty($this->expired_at) && $this->expired_at->lte(\Carbon\Carbon::now());
    }

    static public function generalStats($userId = null)
    {
        $query = \DB::table('credentials')
            ->join('credential_status', 'credentials.status_id', '=', 'credential_status.id')
            ->select(\DB::raw('count(*) AS count, credential_status.name'));

        if ($userId) {
            $query = $query->where('credentials.assigned_to_id', $userId);
        }

        $total = $query->count();

        $query = $query->groupBy('status_id')->orderBy('credentials.id');

        return [
            'total' => $total,
            'rows'  => $query->get(),
        ];
    }

    static public function approvedStats($userId = null)
    {
        $config = \Session::get('config');
        $years = !empty($config['credentialYearSpan']) ? $config['credentialYearSpan'] : 2;

        $query = \DB::table('credentials')
            ->where('status_id', 4);

        if ($userId) {
            $query = $query->where('assigned_to_id', $userId);
        }

        $total = $query->count();

        $query = $query->where('completed_at', '>', \Carbon\Carbon::today()->subYears($years)->toDateString());

        $active = $query->count();

        return [
            'total'   => $total,
            'active'  => $active,
            'expired' => $total - $active,
        ];
    }


}
