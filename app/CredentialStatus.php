<?php namespace App;

use SortableTrait, SearchTrait;

class Credentialstatus extends BaseModel
{

    use SortableTrait, SearchTrait;

    protected $table = 'credential_status';

    protected $fillable = [
        'name',
        'disabled',
    ];

    public $sortable = [
        'name',
    ];

    public $searchable = [
        'name' => 'LIKE',
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

    public function credentials()
    {
        return $this->hasMany('App\Credential');
    }


    /** scopes */


    /** Methods, Accessor(get) and Mutators(set) */

    static public function credentialStatusCB($default = [])
    {
        $credentialStatus = self::lists('name', 'id')->toArray();

        if (!empty($default)) {
            return self::mergeAssoc($default, $credentialStatus);
        }

        return $credentialStatus;
    }

}
