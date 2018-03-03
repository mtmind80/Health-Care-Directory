<div class="panel-body">

    <section id="data-container">
        <div class="section-divider mb40 mt20"><span>{{ $formTitle }}</span></div>

        <div class="section row">
            <div class="col-sm-6">
                    {{!! $task->creator->fullName !!}}
            </div>
            <div class="col-sm-6">
                {{!! $task->assignedTo->fullName !!}}
            </div>
        </div>


        <div class="section row">
            <div class="col-sm-4">
                {{!! $task->title !!}}
            </div>
            <div class="col-md-8">
                {{!! $task->content !!}}
            </div>
        </div>


        <div class="section row">
            <div class="col-sm-8">
                {{ Form::jText('response', ['label' => 'Response', 'id' => 'response', 'placeholder' => 'Response', 'required' => true, 'iconClass' => 'fa fa-tasks']) }}
            </div>
            <div class="col-sm-4">
                    Check box Is complete
            </div>
        </div>


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