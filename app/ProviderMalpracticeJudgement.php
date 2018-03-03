<?php namespace App;

use SortableTrait, SearchTrait;

class ProviderMalpracticeJudgement extends BaseModel
{

    use SortableTrait, SearchTrait;

    protected $dates = ['occurred_at', 'reported_at', 'settled_at', 'deleted_at'];

    protected $fillable = [
        'malpractice_id',
        'offense_type_id',
        'plaintiff_name',
        'settled_amount',
        'defendant',
        'dismissed',
        'primary_sourced',
        'occurred_at',
        'reported_at',
        'settled_at',
        'deleted_at',
    ];

    public $sortable = [
        'plaintiff_name',
        'settled_amount',
        'defendant',
        'dismissed',
        'primary_sourced',
        'occurred_at',
        'reported_at',
        'settled_at',
        'offense_types.name|provider_malpractice_judgements.offense_type_id',
    ];

    public $searchable = [
        'plaintiff_name' => 'LIKE',
        'settled_amount' => '=',
        'occurred_at'    => '=',
        'reported_at'    => '=',
        'settled_at'     => '=',
        'childModels'    => [
            'offenseType' => [
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

    public function malpractice()
    {
        return $this->belongsTo('App\ProviderMalpractice', 'malpractice_id');
    }

    public function offenseType()
    {
        return $this->belongsTo('App\OffenseType', 'offense_type_id');
    }


    /** scopes */

    public function scopeMalpractice($query, $malpracticeId, $amount = null)
    {
        $query->where('malpractice_id', $malpracticeId);
        if (!empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }


    /** Accessors(getters) and Mutators(setters) */

    public function getHtmlOccurredAtAttribute()
    {
        return !empty($this->occurred_at) ? $this->occurred_at->format('m/d/Y') : '';
    }

    public function getHtmlReportedAtAttribute()
    {
        return !empty($this->reported_at) ? $this->reported_at->format('m/d/Y') : '';
    }

    public function getHtmlSettledAtAttribute()
    {
        return !empty($this->settled_at) ? $this->settled_at->format('m/d/Y') : '';
    }

    public function getHtmlSettledAmountAttribute()
    {
        return !empty($this->settled_amount) ? '$'.number_format($this->settled_amount, 2, '.', ',') : '';
    }

    public function getHtmlDefendantAttribute()
    {
        return !empty($this->defendant) ? 'Yes' : 'No';
    }

    public function getHtmlDismissedAttribute()
    {
        return !empty($this->dismissed) ? 'Yes' : 'No';
    }

    public function getHtmlPrimarySourcedAttribute()
    {
        return !empty($this->primary_sourced) ? 'Yes' : 'No';
    }

    public function setOccurredAtAttribute($value)
    {
        $this->attributes['occurred_at'] = !empty($value) ? $value : null;
    }

    public function setReportedAtAttribute($value)
    {
        $this->attributes['reported_at'] = !empty($value) ? $value : null;
    }

    public function setSettledAtAttribute($value)
    {
        $this->attributes['settled_at'] = !empty($value) ? $value : null;
    }

    /** Methods */

    public function delete()
    {
        $this->deleted_at = date('Y-m-d H:i:s');
        $this->save();
    }

}
