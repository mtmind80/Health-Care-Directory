<div class="panel-body">
    <div class="section-divider mb40 mt20"><span>{{ $formTitle }}</span></div>

    <div class="section row">
        <div class="col-md-6">
            {{ Form::jSelect('school_id', $schoolsCB, ['selected' => empty($create) ? $school->school_id : 0, 'label' => 'School', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-institution', 'attributes' => ['id' => 'school_id',]]) }}
        </div>
        <div class="col-md-6">
            {{ Form::jSelect('degree_id', $degreesCB, ['selected' => empty($create) ? $school->degree_id : 0, 'label' => 'Degree', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-graduation-cap', 'attributes' => ['id' => 'degree_id',]]) }}
        </div>
    </div>
    <div class="section row">
        <div class="col-md-6">
            {{ Form::jCalendar('started_at', ['value' => empty($create) ? $school->started_at : null, 'label' => 'From', 'id' => 'started_at', 'placeholder' => 'From', 'required' => false]) }}
        </div>
        <div class="col-md-6">
            {{ Form::jCalendar('ended_at', ['value' => empty($create) ? $school->ended_at : null, 'label' => 'To', 'id' => 'ended_at', 'placeholder' => 'To', 'required' => false]) }}
        </div>
    </div>
    <div class="section row">
        <div class="col-md-12">
            {{ Form::jTextarea('comment', ['value' => empty($create) ? $school->comment : null, 'label' => 'Comment', 'id' => 'comment', 'placeholder' => 'Comment', 'required' => false]) }}
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