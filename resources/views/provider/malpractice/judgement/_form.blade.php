<div class="panel-body">
    <div class="section-divider mb40 mt20"><span>{{ $formTitle }}</span></div>

    <div class="section row">
        <div class="col-sm-6">
            {{ Form::jSelect('offense_type_id', $offenseTypesCB, ['selected' => empty($create) ? $judgement->offense_type_id : 0, 'label' => 'Offense Type', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-tasks', 'attributes' => ['id' => 'offense_type_id',]]) }}
        </div>
        <div class="col-sm-6">
            {{ Form::jText('plaintiff_name', ['label' => 'Plaintiff Name', 'id' => 'plaintiff_name', 'placeholder' => 'Plaintiff Name', 'required' => false, 'iconClass' => 'fa fa-user']) }}
        </div>
    </div>
    <div class="section row">
        <div class="col-md-4">
            {{ Form::jSwitch('defendant', ['checked' => !empty($judgement->defendant), 'id' => 'defendant', 'label' => 'Defendant', 'class' => 'mt10']) }}
        </div>
        <div class="col-md-4">
            {{ Form::jSwitch('dismissed', ['checked' => !empty($judgement->dismissed), 'id' => 'dismissed', 'label' => 'Dismissed', 'class' => 'mt10']) }}
        </div>
        <div class="col-md-4">
            {{ Form::jSwitch('primary_sourced', ['checked' => !empty($judgement->primary_sourced), 'id' => 'primary_sourced', 'label' => 'Primary Sourced', 'class' => 'mt10']) }}
        </div>
    </div>
    <div class="section row">
        <div class="col-md-6">
            {{ Form::jCalendar('occurred_at', ['value' => empty($create) ? $judgement->occurred_at : null, 'label' => 'Occurred At', 'id' => 'occurred_at', 'required' => true, 'placeholder' => 'Occurred At', 'required' => false]) }}
        </div>
        <div class="col-md-6">
            {{ Form::jCalendar('reported_at', ['value' => empty($create) ? $judgement->reported_at : null, 'label' => 'Reported At', 'id' => 'reported_at', 'required' => true, 'placeholder' => 'Reported At', 'required' => false]) }}
        </div>
    </div>
    <div class="section row">
        <div class="col-md-6">
            {{ Form::jCalendar('settled_at', ['value' => empty($create) ? $judgement->settled_at : null, 'label' => 'Settled At', 'id' => 'settled_at', 'placeholder' => 'Settled At', 'required' => false]) }}
        </div>
        <div class="col-md-6">
            {{ Form::jText('settled_amount', ['value' => empty($create) ? number_format($judgement->settled_amount, 2, '.', ',') : null, 'label' => 'Settled Amount', 'id' => 'settled_amount', 'placeholder' => 'Settled Amount', 'iconClass' => 'fa fa-dollar']) }}
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