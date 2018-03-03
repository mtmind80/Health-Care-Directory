<div class="panel-body">
    <div class="section-divider mb40 mt20"><span>{{ $formTitle }}</span></div>

    <div class="section row">
        <div class="col-md-6">
            {{ Form::jSelect('facility_id', $institutionsCB, ['selected' => empty($create) ? $affiliation->facility_id : 0, 'label' => 'Hospital', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-institution', 'attributes' => ['id' => 'facility_id',]]) }}
        </div>
        <div class="col-md-6">

        </div>
    </div>
    <div class="section row">
        <div class="col-md-6">
            {{ Form::jCalendar('started_at', ['value' => empty($create) ? $affiliation->started_at : null, 'label' => 'Started At', 'id' => 'started_at', 'placeholder' => 'Started At', 'required' => false]) }}
        </div>
        <div class="col-md-6">
            {{ Form::jCalendar('ended_at', ['value' => empty($create) ? $affiliation->ended_at : null, 'label' => 'Ended At', 'id' => 'ended_at', 'placeholder' => 'Ended At', 'required' => false]) }}
        </div>
    </div>
    <div class="section row">
        <div class="col-md-12">
            {{ Form::jTextarea('comment', ['label' => 'Comment', 'id' => 'comment', 'placeholder' => 'Comment', 'required' => false, 'iconClass' => 'fa fa-comments']) }}
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