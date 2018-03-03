<div class="panel-body">
    <div class="section-divider mb40 mt20"><span>{{ $formTitle }}</span></div>

    <div class="section row">
        <div class="col-sm-6">
            @if (!empty($create))
                {{ Form::jSelect('provider_type_id', $providerTypesCB, ['selected' => empty($create) ? $provider->subType->type->id : 0, 'label' => 'Type', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-sliders', 'attributes' => ['id' => 'provider_type_id',]]) }}
            @else
                {{ Form::jText('dummy', ['value' => $provider->type->name, 'label' => 'Type', 'attributes' => ['readonly' => 'readonly'] ]) }}
                {!! Form::hidden('provider_type_id', $provider->subType->type->id) !!}
            @endif
        </div>
        <div class="col-sm-6">
            {{ Form::jSelect('provider_subtype_id', $providerSubtypesCB, ['selected' => empty($create) ? $provider->provider_subtype_id : 0, 'label' => 'Sub Type', 'hint' => '(Select Type first)', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-sitemap', 'attributes' => ['id' => 'provider_subtype_id',]]) }}
        </div>
    </div>

    <section id="data-container">

        <!-- Professional data section -->

        <section class="person-data-section">
            <div class="section row">
                <div class="col-md-6">
                    {{ Form::jText('first_name', ['value' => (empty($create) && $provider->isProfessional) ? $provider->professional->first_name : null, 'label' => 'First Name', 'id' => 'first_name', 'placeholder' => 'First Name', 'required' => true]) }}
                </div>
                <div class="col-md-6">
                    {{ Form::jText('last_name', ['value' => (empty($create) && $provider->isProfessional) ? $provider->professional->last_name : null, 'label' => 'Last Name', 'id' => 'last_name', 'placeholder' => 'Last Name', 'required' => true]) }}
                </div>
            </div>
            <div class="section row">
                <div class="col-md-8">
                    {{ Form::jText('title', ['value' => (empty($create) && $provider->isProfessional) ? $provider->professional->title : null, 'label' => 'Title', 'id' => 'title', 'placeholder' => 'Title', 'required' => true]) }}
                </div>
                <div class="col-md-4">
                    <span class="form-field-label">Date of Birth:<i class="field-required fa fa-asterisk" data-toggle="tooltip" title="this field is required"></i></span>
                    <label for="date_of_birth" class="field prepend-icon">
                        <input type="text" name="date_of_birth" id="date_of_birth" value="{{ (empty($create) && $provider->isProfessional) ? $provider->professional->date_of_birth->format('m/d/Y') : '' }}" class="gui-input bootstrap-date-picker" placeholder="Date of Birth">
                        <span class="field-icon"><i class="fa fa-calendar-o"></i></span>
                    </label>
                </div>
            </div>
        </section>

        <!-- Facility data section -->

        <section class="facility-data-section">
            <div class="section row">
                <div class="col-md-12">
                    {{ Form::jText('name', ['value' => (empty($create) && ! $provider->isProfessional) ? $provider->facility->name : null, 'label' => 'Name', 'id' => 'name', 'placeholder' => 'Name', 'required' => true]) }}
                </div>
            </div>
        </section>

        <!-- Common data section -->

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
                {{ Form::jSelect('country_id', $countriesCB, ['selected' => empty($create) ? $provider->state->country->id : 0, 'label' => 'Country', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-globe', 'attributes' => ['id' => 'country_id',]]) }}
            </div>
            <div class="col-sm-6">
                {{ Form::jSelect('state_id', $statesCB, ['selected' => empty($create) ? $provider->state->id : 0, 'label' => 'State', 'hint' => '(Select Country first)', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-tree', 'attributes' => ['id' => 'state_id',]]) }}
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
                {{ Form::jSwitch('under_contract', ['checked' => !empty($provider->under_contract), 'id' => 'under_contract', 'label' => 'Under Contract', 'class' => 'mt30']) }}
            </div>
        </div>

        <!-- Facility data section -->

        <section class="facility-data-section">

            <div class="section-divider mt40 mb25">
                <span>Contact Info</span>
            </div>

            <div class="section row">
                <div class="col-md-12">
                    {{ Form::jText('contact_name', ['value' => (empty($create) && ! $provider->isProfessional) ? $provider->facility->contact_name : null, 'label' => 'Contact Name', 'id' => 'contact_name', 'placeholder' => 'Contact Name', 'required' => true, 'iconClass' => 'fa fa-user']) }}
                </div>
            </div>
        </section>
    </section>

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