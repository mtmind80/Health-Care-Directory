<?php namespace App;

use SortableTrait, SearchTrait;

class ProfessionalSchool extends BaseModel
{

    use SortableTrait, SearchTrait;

    protected $fillable = [
        'professional_id',
        'school_id',
        'degree_id',
        'comment',
        'started_at',
        'ended_at',
        'deleted_at',
    ];

    protected $dates = ['started_at', 'ended_at', 'deleted_at'];

    public $sortable = [
        'started_at',
        'ended_at',
        'degrees.name|professional_schools.degree_id',
        'schools.name|professional_schools.school_id',
    ];

    public $searchable = [
        'comment'     => 'LIKE',
        'started_at'  => '=',
        'ended_at'    => '=',
        'childModels' => [
            'degree' => [
                'fields' => [
                    'name' => 'LIKE',
                ],
            ],
            'school' => [
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

    public function degree()
    {
        return $this->belongsTo('App\Degree');
    }

    public function school()
    {
        return $this->belongsTo('App\School');
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

    public function setStartedAtAttribute($value)
    {
        $this->attributes['started_at'] = (!empty($value)) ? date('Y-m-d', strtotime($value)) : null;
    }

    public function setEndedAtAttribute($value)
    {
        $this->attributes['ended_at'] = (!empty($value)) ? date('Y-m-d', strtotime($value)) : null;
    }

    public function delete()
    {
        $this->deleted_at = date('Y-m-d H:i:s');
        $this->save();
    }

}
