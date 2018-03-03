<?php namespace App;

use SortableTrait, SearchTrait;

class ProfessionalBoard extends BaseModel
{

    use SortableTrait, SearchTrait;

    protected $fillable = [
        'professional_id',
        'speciality_type_id',
        'speciality_subtype_id',
        'body_id',
        'certification_id',
        'state_id',
        'country_id',
        'number',
        'issued_at',
        'expired_at',
        'deleted_at',
    ];

    protected $dates = ['issued_at', 'expired_at', 'deleted_at'];

    public $sortable = [
        'number',
        'speciality_types.name|professional_boards.speciality_type_id',
        'speciality_subtypes.name|professional_boards.speciality_subtype_id',
        'bodies.name|professional_boards.body_id',
        'certifications.name|professional_boards.certification_id',
        'states.full_name|professional_boards.state_id',
        'countries.name|professional_boards.country_id',
    ];

    public $searchable = [
        'number'      => 'LIKE',
        'issued_at'   => '=',
        'expired_at'  => '=',
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
            'body'              => [
                'fields' => [
                    'name' => 'LIKE',
                ],
            ],
            'certification'     => [
                'fields' => [
                    'name' => 'LIKE',
                    'code' => 'LIKE',
                ],
            ],
            'state'             => [
                'fields' => [
                    'full_name' => 'LIKE',
                ],
            ],
            'country'           => [
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

    public function body()
    {
        return $this->belongsTo('App\Body');
    }

    public function certification()
    {
        return $this->belongsTo('App\Certification');
    }

    public function state()
    {
        return $this->belongsTo('App\State');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
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

    public function setIssuedAtAttribute($value)
    {
        $this->attributes['issued_at'] = (!empty($value)) ? date('Y-m-d', strtotime($value)) : null;
    }

    public function setExpiredAtAttribute($value)
    {
        $this->attributes['expired_at'] = (!empty($value)) ? date('Y-m-d', strtotime($value)) : null;
    }

    public function getHtmlIssuedAtAttribute()
    {
        return !empty($this->issued_at) ? $this->issued_at->format('m/d/Y') : '';
    }

    public function isExpired()
    {
        return !empty($this->expired_at) && $this->expired_at->lte(\Carbon\Carbon::now());
    }

    public function getHtmlExpiredAtAttribute()
    {
        return !empty($this->expired_at) ? $this->expired_at->format('m/d/Y') . ($this->isExpired() ? '<i class="fa fa-exclamation-triangle ml5 status due" data-toggle="tooltip" title="This item is expired"></i>' : '') : '';
    }

    public function delete()
    {
        $this->deleted_at = date('Y-m-d H:i:s');
        $this->save();
    }

}
