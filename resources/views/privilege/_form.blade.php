<div class="panel-body">
    <div class="section-divider mb40 mt20"><span>{{ $formTitle }}</span></div>

    <div class="section row">
        <div class="col-md-6">
            {{ Form::jText('privilege_name', ['label' => 'Privilege Name', 'id' => 'privilege_name', 'placeholder' => 'Privilege Name', 'required' => true]) }}
        </div>
        <div class="col-md-6 mt15">
            @if (!empty($create))
                {{ Form::jCheckbox('createCrud', ['label' => 'Create CRUD set', 'title' => 'CRUD: list, search, show, create, update and delete']) }}
            @endif
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