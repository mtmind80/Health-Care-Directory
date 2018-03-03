<div class="panel-body">

    <section id="data-container">
        <div class="section-divider mb30 mt20"><span>{{ $formTitle }}</span></div>
        <div class="section row">
            <div class="col-sm-12">
                {{ Form::jText('title', ['label' => 'Title', 'id' => 'title', 'placeholder' => 'Title', 'required' => true, 'iconClass' => 'fa fa-sticky-note']) }}
            </div>
        </div>
        <div class="section row">
            <div class="col-sm-12">
                {{ Form::jTextarea('content', ['label' => 'Content', 'id' => 'contentId', 'placeholder' => 'Content', 'required' => true]) }}
            </div>
        </div>
        @if (empty($create))
            <div class="section row">
                <div class="col-sm-12">
                    {{ Form::jTextarea('response', ['label' => 'Response', 'id' => 'response', 'hint' => '(This field is read-only)', 'placeholder' => 'Response', 'attributes' => ['readonly' => 'readonly']]) }}
                </div>
            </div>
        @endif
        <div class="section row">
            <div class="col-sm-6">
                {{ Form::jSelect('assigned_to_id', $usersCB, ['selected' => empty($create) ? $task->assigned_to_id : 0, 'label' => 'Assigned To', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-user', 'attributes' => ['id' => 'assigned_to_id',]]) }}
            </div>
            <div class="col-sm-6">
                @if (empty($create))
                    {{ Form::jSelect('creator_id', $usersCB, ['selected' => $task->creator_id, 'label' => 'Created By', 'required' => true, 'class' => '', 'iconClass' => 'fa fa-user', 'attributes' => ['id' => 'creator_id',]]) }}
                @endif
            </div>
        </div>
        <div class="section row">
            <div class="col-sm-6">
                <span class="form-field-label">Due At:<i class="field-required fa fa-asterisk" data-toggle="tooltip" title="this field is required"></i></span>
                <label for="due_at" class="field prepend-icon">
                    <input type="text" name="due_at" id="due_at" value="{{ empty($create) ? $task->due_at->format('m/d/Y') : '' }}" class="gui-input bootstrap-date-picker" placeholder="Due At">
                    <span class="field-icon"><i class="fa fa-calendar-o"></i></span>
                </label>
            </div>
            <div class="col-sm-6">
                <span class="form-field-label">Remain At:</span>
                <label for="remind_at" class="field prepend-icon">
                    <input type="text" name="remind_at" id="remind_at" value="{{ empty($create) ? $task->remind_at->format('m/d/Y') : '' }}" class="gui-input bootstrap-date-picker" placeholder="Remain At">
                    <span class="field-icon"><i class="fa fa-calendar-o"></i></span>
                </label>
            </div>
        </div>
        @if (empty($create))
        <div class="section row">
            <div class="col-sm-6">
                @if ($task->completed)
                    <span class="form-field-label">Completed At:<i class="field-required fa fa-asterisk" data-toggle="tooltip" title="this field is required"></i></span>
                    <label for="completed_at" class="field prepend-icon">
                        <input type="text" name="completed_at" id="completed_at" value="{{ $task->completed_at->format('m/d/Y') }}" class="gui-input bootstrap-date-picker" placeholder="Completed At">
                        <span class="field-icon"><i class="fa fa-calendar-o"></i></span>
                    </label>
                @else
                    {{ Form::jText('dummy', ['value' => 'Not Completed', 'label' => 'Status', 'id' => 'dummy', 'iconClass' => 'fa fa-sticky-note', 'attributes' => ['readonly' => 'readonly']]) }}
                @endif
            </div>
            <div class="col-sm-6">

            </div>
        </div>
        @endif
    </section>

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