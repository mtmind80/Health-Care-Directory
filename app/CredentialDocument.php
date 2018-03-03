<?php namespace App;

use SortableTrait, SearchTrait;

class CredentialDocument extends BaseModel
{

    use SortableTrait, SearchTrait;

    protected $fillable = [
        'credential_id',
        'document_type_id',
    ];

    public $sortable = [
        'document_types.name|credential_documents.document_type_id',

    ];

    public $searchable = [
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

    public function credential()
    {
        return $this->belongsTo('App\Credential');
    }

    public function type()
    {
        return $this->belongsTo('App\DocumentType', 'document_type_id');
    }

    public function actions()
    {
        return $this->hasMany('App\CredentialDocumentAction');
    }

    /** scopes */

    public function scopeCredential($query, $credentialId, $amount = null)
    {
        $query->where('credential_id', $credentialId);
        if (!empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }

    /** Methods, Accessors(getters) and Mutators(setters) */


}
