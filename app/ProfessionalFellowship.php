<?php namespace App;

use SortableTrait, SearchTrait;

class ProfessionalFellowship extends BaseModel
{

    use SortableTrait, SearchTrait;

    protected $fillable = [
        'professional_id',
        'speciality_type_id',
        'speciality_subtype_id',
        'degree_id',
        'discipline_id',
        'facility_id',
        'comment',
        'started_at',
        'ended_at',
        'deleted_at',
    ];

    protected $dates = ['started_at', 'ended_at', 'deleted_at'];

    public $sortable = [
        'speciality_types.name|professional_fellowships.speciality_type_id',
        'speciality_subtypes.name|professional_fellowships.speciality_subtype_id',
        'degrees.name|professional_fellowships.degree_id',
        'disciplines.name|professional_fellowships.discipline_id',
        'facilities.name|professional_fellowships.facility_id',
    ];

    public $searchable = [
        'comment'     => 'LIKE',
        'childModels' => [
            'specialityType'    => [
                'fields' => [
                    'name' => 'LIKE',
                ],
            ],
            'specialitySubtype' => [
                'fields' => [
                    'name' => 'LIKE',
                    'code' => 'LIKE',
                ],
            ],
            'degree'            => [
                'fields' => [
                    'name' => 'LIKE',
                ],
            ],
            'discipline'        => [
                'fields' => [
                    'name' => 'LIKE',
                ],
            ],
            'facility'          => [
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

    public function specialityType()
    {
        return $this->belongsTo('App\SpecialityType', 'speciality_type_id');
    }

    public function specialitySubtype()
    {
        return $this->belongsTo('App\SpecialitySubtype', 'speciality_subtype_id');
    }

    public function degree()
    {
        return $this->belongsTo('App\Degree');
    }

    public function discipline()
    {
        return $this->belongsTo('App\Discipline');
    }

    public function facility()
    {
        return $this->belongsTo('App\Facility');
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

    public function delete()
    {
        $this->deleted_at = date('Y-m-d H:i:s');
        $this->save();
    }

    public function getHtmlStartedAtAttribute()
    {
        return !empty($this->started_at) ? $this->started_at->format('m/d/Y') : '';
    }

    public function getHtmlEndedAtAttribute()
    {
        return !empty($this->ended_at) ? $this->ended_at->format('m/d/Y') : '';
    }

}
