<div class="panel-body">
    <div class="section-divider mb40 mt20"><span>{{ $formTitle }}</span></div>

    <div class="section row">
        <div class="col-md-6">
            {{ Form::jSelect('speciality_type_id', $specialityTypesCB, ['selected' => empty($create) ? $board->speciality_type_id : 0, 'label' => 'Speciality Type', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-credit-card', 'attributes' => ['id' => 'speciality_type_id',]]) }}
        </div>
        <div class="col-md-6">
            {{ Form::jSelect('speciality_subtype_id', $specialitySubtypesCB, ['selected' => empty($create) ? $board->speciality_subtype_id : 0, 'label' => 'Speciality Subtype', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-credit-card', 'attributes' => ['id' => 'speciality_subtype_id',]]) }}
        </div>
    </div>
    <div class="section row">
        <div class="col-md-6">
            {{ Form::jSelect('certification_id', $certificationsCB, ['selected' => empty($create) ? $board->certification_id : 0, 'label' => 'Certification', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-credit-card', 'attributes' => ['id' => 'certification_id',]]) }}
        </div>
        <div class="col-md-6">
            {{ Form::jSelect('body_id', $bodiesCB, ['selected' => empty($create) ? $board->body_id : 0, 'label' => 'Body', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-credit-card', 'attributes' => ['id' => 'body_id',]]) }}
        </div>
    </div>
    <div class="section row">
        <div class="col-md-6">
            {{ Form::jSelect('country_id', $countriesCB, ['selected' => empty($create) ? $board->board_id : 0, 'label' => 'Country', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-globe', 'attributes' => ['id' => 'country_id',]]) }}
        </div>
        <div class="col-md-6">
            {{ Form::jSelect('state_id', $statesCB, ['selected' => empty($create) ? $board->board_id : 0, 'label' => 'State', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-tree', 'attributes' => ['id' => 'state_id',]]) }}
        </div>
    </div>
    <div class="section row">
        <div class="col-md-6">
            {{ Form::jCalendar('issued_at', ['value' => empty($create) ? $board->issued_at : null, 'label' => 'Issue Date', 'id' => 'issued_at', 'placeholder' => 'Issue Date', 'required' => false]) }}
        </div>
        <div class="col-md-6">
            {{ Form::jCalendar('expired_at', ['value' => empty($create) ? $board->expired_at : null, 'label' => 'Expire Date', 'id' => 'expired_at', 'placeholder' => 'Expire Date', 'required' => false]) }}
        </div>
    </div>
    <div class="section row">
        <div class="col-md-6">
            {{ Form::jText('number', ['label' => 'Number', 'id' => 'number', 'placeholder' => 'Number', 'required' => true]) }}
        </div>
        <div class="col-md-6">

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