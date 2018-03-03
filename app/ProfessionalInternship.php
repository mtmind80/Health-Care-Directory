<?php namespace App;

use SortableTrait, SearchTrait;

class ProfessionalInternship extends BaseModel
{

    use SortableTrait, SearchTrait;

    protected $fillable = [
        'professional_id',
        'internship_type_id',
        'discipline_id',
        'facility_id',
        'comment',
        'started_at',
        'ended_at',
        'deleted_at',
    ];

    protected $dates = ['started_at', 'ended_at', 'deleted_at'];

    public $sortable = [
        'internship_types.name|professional_internships.internship_type_id',
        'disciplines.name|professional_internships.discipline_id',
        'facilities.name|professional_internships.facility_id',
    ];

    public $searchable = [
        'comment'     => 'LIKE',
        'childModels' => [
            'internshipType'    => [
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

    public function internshipType()
    {
        return $this->belongsTo('App\InternshipType', 'internship_type_id');
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

}
