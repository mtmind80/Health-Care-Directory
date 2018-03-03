<div class="panel-body">
    <div class="section-divider mb40 mt20"><span>{{ $formTitle }}</span></div>

    <div class="section row">
        <div class="col-sm-6">
            {{ Form::jSelect('insurer_id', $insurersCB, ['selected' => empty($create) ? $malpractice->insurer_id : 0, 'label' => 'Insurer', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-tasks', 'attributes' => ['id' => 'insurer_id',]]) }}
        </div>
        <div class="col-sm-6">
            {{ Form::jSelect('policy_type_id', $policyTypesCB, ['selected' => empty($create) ? $malpractice->policy_type_id : 0, 'label' => 'Policy Type', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-tasks', 'attributes' => ['id' => 'policy_type_id',]]) }}
        </div>
    </div>
    <div class="section row">
        <div class="col-md-6">
            {{ Form::jText('per_occurance', ['label' => 'Per Occurance', 'id' => 'per_occurance', 'placeholder' => 'Per Occurance']) }}
        </div>
        <div class="col-md-6">
            {{ Form::jText('in_aggregate', ['label' => 'In Aggregate', 'id' => 'in_aggregate', 'placeholder' => 'In Aggregate']) }}
        </div>
    </div>
    <div class="section row">
        <div class="col-md-6">
            {{ Form::jCalendar('started_at', ['value' => empty($create) ? $malpractice->started_at : null, 'label' => 'Policy Date', 'id' => 'started_at', 'placeholder' => 'Policy Date', 'required' => false]) }}
        </div>
        <div class="col-md-6">
            {{ Form::jCalendar('expired_at', ['value' => empty($create) ? $malpractice->expired_at : null, 'label' => 'Expire At', 'id' => 'expired_at', 'placeholder' => 'Expire At', 'required' => false]) }}
        </div>
    </div>
    <div class="section row">
        <div class="col-md-6">
            {{ Form::jCalendar('retroactive_at', ['value' => empty($create) ? $malpractice->retroactive_at : null, 'label' => 'Retroactive At', 'id' => 'retroactive_at', 'placeholder' => 'Retroactive At', 'required' => false]) }}
        </div>
        <div class="col-md-6">
            {{ Form::jText('policy_number', ['label' => 'Policy Number', 'id' => 'policy_number', 'placeholder' => 'Policy Number', 'required' => true]) }}
        </div>
    </div>

    <div class="section row">
        <div class="col-md-6">
            {{ Form::jSwitch('insurance_proof', ['checked' => !empty($malpractice->insurance_proof), 'id' => 'insurance_proof', 'label' => 'Insurance Proof', 'class' => 'mt10']) }}
        </div>
        <div class="col-md-6">
            {{ Form::jSwitch('primary_sourced', ['checked' => !empty($malpractice->primary_sourced), 'id' => 'primary_sourced', 'label' => 'Primary Sourced', 'class' => 'mt10']) }}
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