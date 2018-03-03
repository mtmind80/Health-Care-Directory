<div class="panel-body">
    <div class="section-divider mb40 mt20"><span>{{ $formTitle }}</span></div>

    <div class="section row">
        <div class="col-sm-6">
            {{ Form::jSelect('document_type_id', $documentTypesCB, ['selected' => empty($create) ? $credential->document_type_id : 0, 'label' => 'Document Type', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-tasks', 'attributes' => ['id' => 'document_type_id',]]) }}
        </div>
        <div class="col-sm-6">

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