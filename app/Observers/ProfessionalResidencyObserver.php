<?php

use Illuminate\Support\Facades\Hash;

use \App\Events\ProviderHasChanged;

class ProfessionalResidencyObserver
{

    protected $comment = 'Professional Residency';

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

        Event::fire(new ProviderHasChanged($model->professional->provider_id, 1, \Auth::user()->id, $jsonData, $this->comment));
    }

    public function updating($model)
    {
        $actionId = $this->isDeleted($model) ? 5 : 2;

        $jsonData = $this->getJSONChanges($model);

        Event::fire(new ProviderHasChanged($model->professional->provider_id, $actionId, \Auth::user()->id, $jsonData, $this->comment));
    }

}

