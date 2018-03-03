<div class="panel-body">
    <div class="section-divider mb40 mt20"><span>{{ $formTitle }}</span></div>

    <div class="section row">
        <div class="col-md-12">
            {{ Form::jText('name', ['label' => 'Name', 'id' => 'name', 'placeholder' => 'Name', 'required' => true]) }}
        </div>
    </div>
    <div class="section row">
        <div class="col-sm-8">
            {{ Form::jText('address', ['label' => 'Address', 'id' => 'address', 'placeholder' => 'Address', 'required' => false, 'iconClass' => 'fa fa-map-marker']) }}
        </div>
        <div class="col-md-4">
            {{ Form::jText('address_2', ['label' => 'Address 2', 'id' => 'address_2', 'placeholder' => 'Address 2', 'required' => false, 'iconClass' => 'fa fa-map-marker']) }}
        </div>
    </div>
    <div class="section row">
        <div class="col-sm-6">
            {{ Form::jText('city', ['label' => 'City', 'id' => 'city', 'placeholder' => 'City', 'required' => false, 'iconClass' => 'fa fa-building']) }}
        </div>
        <div class="col-sm-6">
            {{ Form::jText('zipcode', ['label' => 'Zip Code', 'id' => 'zipcode', 'placeholder' => 'Zip Code', 'required' => false, 'iconClass' => 'fa fa-object-group']) }}
        </div>
    </div>
    <div class="section row">
        <div class="col-sm-6">
            {{ Form::jSelect('country_id', $countriesCB, ['selected' => empty($create) ? $school->state->country->id : 0, 'label' => 'Country', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-globe', 'attributes' => ['id' => 'country_id',]]) }}
        </div>
        <div class="col-sm-6">
            {{ Form::jSelect('state_id', $statesCB, ['selected' => empty($create) ? $school->state->id : 0, 'label' => 'State', 'hint' => '(Select Country first)', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-tree', 'attributes' => ['id' => 'state_id',]]) }}
        </div>
    </div>
    <div class="section row">
        <div class="col-sm-6">
            {{ Form::jText('phone', ['label' => 'Phone', 'id' => 'phone', 'placeholder' => 'Phone', 'required' => false, 'iconClass' => 'fa fa-phone']) }}
        </div>
        <div class="col-sm-6">
            {{ Form::jText('fax', ['label' => 'Fax', 'id' => 'fax', 'placeholder' => 'Fax', 'required' => false, 'iconClass' => 'fa fa-fax']) }}
        </div>
    </div>
    <div class="section row">
        <div class="col-md-6">
            {{ Form::jText('email', ['label' => 'Email', 'id' => 'email', 'placeholder' => 'Email', 'required' => false, 'iconClass' => 'fa fa-envelope']) }}
        </div>
        <div class="col-md-6">
            {{ Form::jText('contact_name', ['label' => 'Contact Name', 'id' => 'contact_name', 'placeholder' => 'Contact Name', 'required' => false, 'iconClass' => 'fa fa-user']) }}
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