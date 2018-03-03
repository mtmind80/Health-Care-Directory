@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="{{ route('task_list_path') }}">Task</a>
                </li>
                <li class="crumb-trail">Edit</li>
            </ol>
        </div>
        <div class="topbar-right">
        </div>
    </header>
@stop

@section('content')
    <section id="content" class="animated fadeIn list-items admin-form">
        <div class="row">
            <div class="col-md-9 center-block">
                @include('errors._list')
                <div class="admin-form theme-primary">
                    <div class="panel">
                        {!! Form::model($task, ['url' => route('task_update_path', ['id' => $task->id]), 'method' => 'PATCH', 'id' => 'updateTaskForm']) !!}
                            {!! Form::hidden('id', $task->id) !!}
                            @include('task._form', ['formTitle' => 'Edit Task', 'submitButtonText' => 'Update Task'])
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js-files')
    <script>
        $(function(){
            $( "#updateTaskForm" ).validate({
                rules: {
                    // required fields:
                    title: {
                        required : true,
                        plainText: true,
                        minlength: 3
                    },
                    creator_id: {
                        required: true,
                        positive: true
                    },
                    assigned_to_id: {
                        required: true,
                        positive: true
                    },
                    content: {
                        required : true,
                        plainText: true
                    },
                    due_at: {
                        required: true,
                        usDate  : true
                    },
                    // no required fields:
                    remind_at: {
                        required: false,
                        usDate  : true
                    },
                    verification:{
                        required    : true,
                        smartCaptcha: "{{ $equation['result'] }}"
                    }
                },
                messages: {
                    creator_id: {
                        positive: 'Please select Creator.'
                    },
                    assigned_to_id: {
                        positive: 'Please select Assigned To.'
                    }
                }
            });

            $('#cancel-button').click(function(ev){
                ev.preventDefault();
                window.location = "{{ route('task_list_path') }}";
            });


        });
    </script>
@stop