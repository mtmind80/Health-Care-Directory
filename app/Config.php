<?php namespace App;

use SortableTrait;
use SearchTrait;

class Config extends BaseModel
{
    use SortableTrait, SearchTrait;

    protected $table = 'config';


    protected $fillable = [
        'key',
        'value',
    ];

    public $sortable = [
        'key',
        'value',
    ];

    public $searchable = [
        'key'   => 'LIKE',
        'value' => 'LIKE',
    ];

    public function sortableColumns()
    {
        return $this->sortable;
    }

    public function searchableColumns()
    {
        return $this->searchable;
    }

    public function reload()
    {
        $items = $this->active()->get();

        $confArray = [];
        foreach ($items as $item) {
            if (!empty($item->key)) {
                $confArray[$item->key] = $item->value;
            }
        }
        if (empty($confArray['credentialYearSpan'])) {
            $confArray['credentialYearSpan'] = 2;
        }
        session()->put('config', $confArray);
        view()->share('config', $confArray);
    }

    public function fetch()
    {
        $items = $this->active()->get();

        $confArray = [];
        foreach ($items as $item) {
            if (!empty($item->key)) {
                $confArray[$item->key] = $item->value;
            }
        }
        if (empty($confArray['credentialYearSpan'])) {
            $confArray['credentialYearSpan'] = 2;
        }

        return $confArray;
    }

}
