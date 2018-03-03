<?php namespace App;

use SortableTrait, SearchTrait;

class ProviderMalpractice extends BaseModel
{

    use SortableTrait, SearchTrait;


    protected $dates = ['retroactive_at', 'started_at', 'expired_at', 'deleted_at'];

    protected $fillable = [
        'provider_id',
        'insurer_id',
        'policy_type_id',
        'policy_number',
        'per_occurance',
        'in_aggregate',
        'insurance_proof',
        'primary_sourced',
        'retroactive_at',
        'started_at',
        'expired_at',
        'deleted_at',
    ];

    public $sortable = [
        'policy_number',
        'per_occurance',
        'in_aggregate',
        'insurance_proof',
        'primary_sourced',
        'retroactive_at',
        'started_at',
        'expired_at',
        'insurers.name|provider_malpractices.insurer_id',
        'policy_types.name|provider_malpractices.policy_type_id',
    ];

    public $searchable = [
        'policy_number'  => 'LIKE',
        'per_occurance'  => 'LIKE',
        'in_aggregate'   => 'LIKE',
        'retroactive_at' => '=',
        'started_at'     => '=',
        'expired_at'     => '=',
        'childModels'    => [
            'insurer' => [
                'fields' => [
                    'name' => 'LIKE',
                ],
            ],
            'policyType' => [
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

    public function policyType()
    {
        return $this->belongsTo('App\PolicyType');
    }

    public function insurer()
    {
        return $this->belongsTo('App\Insurer');
    }

    /** scopes */

    public function scopeProvider($query, $providerId, $amount = null)
    {
        $query->where('provider_id', $providerId);
        if (!empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }

    /** Accessors(getters) and Mutators(setters) */

    public function getHtmlStartedAtAttribute()
    {
        return !empty($this->started_at) ? $this->started_at->format('m/d/Y') : '';
    }

    public function getHtmlExpiredAtAttribute()
    {
        return !empty($this->expired_at) ? $this->expired_at->format('m/d/Y') . ($this->isExpired() ? '<i class="fa fa-exclamation-triangle ml5 status due" data-toggle="tooltip" title="This item is expired"></i>' : '') : '';
    }

    public function getHtmlRetroactiveAtAttribute()
    {
        return !empty($this->retroactive_at) ? $this->retroactive_at->format('m/d/Y') : '';
    }

    public function setRetroactiveAtAttribute($value)
    {
        $this->attributes['retroactive_at'] = !empty($value) ? $value : null;
    }

    /** Methods */

    public function isExpired()
    {
        return !empty($this->expired_at) && $this->expired_at->lte(\Carbon\Carbon::now());
    }

    public function delete()
    {
        $this->deleted_at = date('Y-m-d H:i:s');
        $this->save();
    }

}
