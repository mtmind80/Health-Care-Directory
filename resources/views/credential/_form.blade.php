<div class="panel-body">
    <div class="section-divider mb40 mt20"><span>{{ $formTitle }}</span></div>

    <div class="section row">
        <div class="col-md-6">
            {{ Form::jSelect('customer_id', $customersCB, ['selected' => empty($create) ? $credential->customer_id : 0, 'label' => 'Customer', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-user', 'attributes' => ['id' => 'customer_id',]]) }}
        </div>
        <div class="col-md-6">
            {{ Form::jSelect('professional_id', $professionalsCB, ['selected' => empty($create) ? $credential->professional_id : 0, 'label' => 'Provider', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-user', 'attributes' => ['id' => 'professional_id',]]) }}
        </div>
    </div>
    <div class="section row">
        <div class="col-md-6">
            {{ Form::jSelect('status_id', $credentialStatusCB, ['selected' => empty($create) ? $credential->status_id : 0, 'label' => 'Status', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-line-chart', 'attributes' => ['id' => 'status_id',]]) }}
        </div>
        <div class="col-md-6">
            {{ Form::jSelect('assigned_to_id', $usersCB, ['selected' => empty($create) ? $credential->assigned_to_id : 0, 'label' => 'Assigned To', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-user', 'attributes' => ['id' => 'assigned_to_id',]]) }}
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