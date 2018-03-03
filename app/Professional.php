<?php namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

use SortableTrait, SearchTrait;

class Professional extends BaseModel
{

    use SortableTrait, SearchTrait;  // not include SoftDeletes to alow logs to show info

    protected $dates = ['date_of_birth', 'deleted_at'];

    protected $fillable = [
        'provider_id',
        'first_name',
        'last_name',
        'title',
        'date_of_birth',
        'deleted_at',
    ];

    public $sortable = [
        'first_name',
        'last_name',
        'title',
        'date_of_birth',
    ];

    public $searchable = [
        'first_name'    => 'LIKE',
        'last_name'     => 'LIKE',
        'title'         => 'LIKE',
        'date_of_birth' => '=',
        'childModels'   => [
            'Provider' => [
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

    public function credentials()
    {
        return $this->hasMany('App\Credential');
    }

    public function boards()
    {
        return $this->hasMany('App\ProfessionalBoard', 'professional_id')->orderBy('issued_at');
    }

    public function fellowships()
    {
        return $this->hasMany('App\ProfessionalFellowship', 'professional_id')->orderBy('started_at');
    }

    public function identifications()
    {
        return $this->hasMany('App\ProfessionalIdentification', 'professional_id');
    }

    public function internships()
    {
        return $this->hasMany('App\ProfessionalInternship', 'professional_id')->orderBy('started_at');
    }

    public function residencies()
    {
        return $this->hasMany('App\ProfessionalResidency', 'professional_id')->orderBy('started_at');
    }

    public function schools()
    {
        return $this->hasMany('App\ProfessionalSchool', 'professional_id')->orderBy('started_at');
    }

    public function affiliations()
    {
        return $this->hasMany('App\ProfessionalAffiliation', 'professional_id')->orderBy('started_at');
    }

    /** scopes */

    public function scopeOrdered($query, $amount = null)
    {
        $query->orderBy('first_name');
        if (!empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }

    public function scopeActive($query, $amount = null)
    {
        $query->whereNull('deleted_at');
        if (!empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }

    /** Methods, Accessor(get) and Mutators(set) */

    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    static public function professionalsCB($default = [])
    {
        $query = Professional::select(\DB::raw("CONCAT(first_name,' ',last_name) AS userName, id"));

        $professionals = $query->orderBy('userName')->lists('userName', 'id')->toArray();

        if (!empty($default)) {
            return self::mergeAssoc($default, $professionals);
        }

        return $professionals;
    }

    public function setDateOfBirthAttribute($value)
    {
        $this->attributes['date_of_birth'] = (!empty($value)) ? date('Y-m-d', strtotime($value)) : null;
    }

    public function delete()
    {
        $this->deleted_at = date('Y-m-d H:i:s');
        $this->save();
    }

}
