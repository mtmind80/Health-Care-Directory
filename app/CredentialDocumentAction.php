<?php namespace App;

use SortableTrait, SearchTrait;

class CredentialDocumentAction extends BaseModel
{

    use SortableTrait, SearchTrait;

    protected $fillable = [
        'document_id',
        'action_type_id',
        'user_id',
        'comment',
    ];

    public $sortable = [
        'document_action_types.name|credential_document_actions.action_type_id',
        'users.first_name|credential_document_actions.user_id',
    ];

    public $searchable = [
        'childModels' => [
            'type' => [
                'fields' => [
                    'name' => 'LIKE',
                ],
            ],
            'user' => [
                'fields' => [
                    'first_name' => 'LIKE',
                    'last_name'  => 'LIKE',
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

    public function document()
    {
        return $this->belongsTo('App\CredentialDocument');
    }

    public function type()
    {
        return $this->belongsTo('App\DocumentActionType', 'action_type_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }


    /** scopes */

    public function scopeDocument($query, $documentId, $amount = null)
    {
        $query->where('document_id', $documentId);
        if (!empty($amount)) {
            $query->take($amount);
        }

        return $query;
    }


    /** Methods, Accessors(getters) and Mutators(setters) */

    public function getHtmlCreatedAtAttribute()
    {
        return !empty($this->created_at) ? $this->created_at->format('m/d/Y') : '';
    }

}
