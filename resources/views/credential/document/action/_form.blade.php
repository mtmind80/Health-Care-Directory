<div class="panel-body">
    <div class="section-divider mb40 mt20"><span>{{ $formTitle }}</span></div>

    <div class="section row">
        <div class="col-sm-6">
            {{ Form::jSelect('action_type_id', $documentActionTypesCB, ['selected' => empty($create) ? $credentialDocumentAction->action_type_id : 0, 'label' => 'Action Type', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-gears', 'attributes' => ['id' => 'action_type_id',]]) }}
        </div>
        <div class="col-sm-6">

        </div>
    </div>
    <div class="section row">
        <div class="col-sm-12">
            {{ Form::jTextarea('comment', ['label' => 'Comment', 'id' => 'comment', 'placeholder' => 'Comment', 'required' => false, 'iconClass' => 'fa fa-comment']) }}
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