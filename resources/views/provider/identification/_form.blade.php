<div class="panel-body">
    <div class="section-divider mb40 mt20"><span>{{ $formTitle }}</span></div>

    <div class="section row">
        <div class="col-md-12">
            {{ Form::jText('value', ['label' => 'Value', 'id' => 'value', 'placeholder' => 'Value', 'required' => true]) }}
        </div>
    </div>
    <div class="section row">
        <div class="col-md-6">
            {{ Form::jSelect('identification_id', $identificationsCB, ['selected' => empty($create) ? $identification->identification_id : 0, 'label' => 'Identification Type', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-credit-card', 'attributes' => ['id' => 'identification_id',]]) }}
        </div>
        <div class="col-md-6">
            {{ Form::jCalendar('expired_at', ['value' => empty($create) ? $board->expired_at : null, 'label' => 'Expire Date', 'id' => 'expired_at', 'placeholder' => 'Expire Date', 'required' => false]) }}
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