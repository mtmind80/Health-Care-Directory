<?php

use Illuminate\Support\Facades\Hash;

use \App\Events\ProviderHasChanged;

class ProviderObserver
{

    protected $comment = 'Provider';

    protected function isDeleted($model)
    {
        return (count($items = $model->getDirty()) == 1 && key($items) == 'deleted_at' && !empty($items['deleted_at']));
    }

    protected function getJSONChanges($model)
    {
        $changes = [];
        foreach ($model->getDirty() as $key => $value) {
            $original = $model->getOriginal($key);
            $changes[$key] = [
                'before' => $original,
                'after'  => $value,
            ];
        }

        return json_encode($changes);
    }

    public function created($model)
    {
        $jsonData = $this->getJSONChanges($model);

        // arguments: provider_id, $actionId, user_id, json_data, comment
        // actions: 1- create,  2- update 3- enable  4- disable  5- delete

        Event::fire(new ProviderHasChanged($model->id, 1, \Auth::user()->id, $jsonData, $this->comment));
    }

    public function updating($model)
    {
        $actionId = $this->isDeleted($model) ? 5 : 2;

        $jsonData = $this->getJSONChanges($model);

        Event::fire(new ProviderHasChanged($model->id, $actionId, \Auth::user()->id, $jsonData, $this->comment));
    }

    public function deleting($model)
    {
        $result['provider'] = $model->toJson(); // serialize model

        if ($model->isProfessional) {
            $result['professional'] = $model->professional->toJson();
            $comment = 'Provider and Professional';
        } else {
            $result['facility'] = $model->facility->toJson();
            $comment = 'Provider and Facility';
        }

        Event::fire(new ProviderHasChanged($model->id, 5, \Auth::user()->id, json_encode($result), $comment));

        return false;  // prevent
    }

}

