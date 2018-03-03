<div class="panel-body">
    <div class="section-divider mb40 mt20"><span>{{ $formTitle }}</span></div>

    <div class="section row">
        <div class="col-md-6">
            {{ Form::jSelect('address_type_id', $addressTypesCB, ['selected' => empty($create) ? $address->address_type_id : 0, 'label' => 'Address Type', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-tasks', 'attributes' => ['id' => 'address_type_id',]]) }}
        </div>
        <div class="col-md-6">

        </div>
    </div>
    <div class="section row">
        <div class="col-sm-8">
            {{ Form::jText('address', ['label' => 'Address', 'id' => 'address', 'placeholder' => 'Address', 'required' => true, 'iconClass' => 'fa fa-map-marker']) }}
        </div>
        <div class="col-md-4">
            {{ Form::jText('address_2', ['label' => 'Address 2', 'id' => 'address_2', 'placeholder' => 'Address 2', 'required' => false, 'iconClass' => 'fa fa-map-marker']) }}
        </div>
    </div>
    <div class="section row">
        <div class="col-sm-6">
            {{ Form::jText('city', ['label' => 'City', 'id' => 'city', 'placeholder' => 'City', 'required' => true, 'iconClass' => 'fa fa-building']) }}
        </div>
        <div class="col-sm-6">
            {{ Form::jText('zipcode', ['label' => 'Zip Code', 'id' => 'zipcode', 'placeholder' => 'Zip Code', 'required' => false, 'iconClass' => 'fa fa-object-group']) }}
        </div>
    </div>

    <div class="section row">
        <div class="col-sm-6">
            {{ Form::jSelect('country_id', $countriesCB, ['selected' => empty($create) ? $address->country->id : 0, 'label' => 'Country', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-globe', 'attributes' => ['id' => 'country_id',]]) }}
        </div>
        <div class="col-sm-6">
            {{ Form::jSelect('state_id', $statesCB, ['selected' => empty($create) ? $address->state->id : 0, 'label' => 'State', 'hint' => '(Select Country first)', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-tree', 'attributes' => ['id' => 'state_id',]]) }}
        </div>
    </div>
</div>
<div class="panel-footer text-right">
    <div class="row">
        <div class="col-md-6">
            @if (empty($config['simpleFormSubmission']))
                {{ Form::jVerification($equation['equation']) }}
            @endif
        </div>
        <div class="col-md-6">
            {{ Form::jCancelSubmit(['submit-label' => $submitButtonText]) }}
        </div>
    </div>
</div>