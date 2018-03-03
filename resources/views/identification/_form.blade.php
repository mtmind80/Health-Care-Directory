<div class="panel-body">
    <div class="section-divider mb40 mt20"><span>{{ $formTitle }}</span></div>

    <div class="section row">
        <div class="col-md-6">
            {{ Form::jText('name', ['label' => 'Identification', 'id' => 'name', 'placeholder' => 'Identification', 'required' => true, 'iconClass' => 'fa fa-diamond']) }}
        </div>
        <div class="col-md-6">
            {{ Form::jSwitch('licence', ['id' => 'licence', 'label' => 'Is Licence', 'class' => 'mt30']) }}
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