<?php namespace App;

use SortableTrait, SearchTrait;

class ProfessionalIdentification extends BaseModel
{

    use SortableTrait, SearchTrait;

    protected $fillable = [
        'professional_id',
        'identification_id',
        'value',
        'expired_at',
        'deleted_at',
    ];

    protected $dates = ['expired_at', 'deleted_at'];

    public $sortable = [
        'value',
        'identifications.name|professional_identifications.identification_id',
    ];

    public $searchable = [
        'value'       => 'LIKE',
        'childModels' => [
            'identification' => [
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

    public function professional()
    {
        return $this->belongsTo('App\Professional');
    }

    public function identification()
    {
        return $this->belongsTo('App\Identification');
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

    public function scopeProfessional($query, $professionalId, $amount = null)
    {
        $query->where('professional_id', $professionalId);
        if (!empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }

    /** Methods, Accessors(getters) and Mutators(setters) */

    public function setExpiredAtAttribute($value)
    {
        $this->attributes['expired_at'] = (!empty($value)) ? date('Y-m-d', strtotime($value)) : null;
    }

    public function delete()
    {
        $this->deleted_at = date('Y-m-d H:i:s');
        $this->save();
    }

}
