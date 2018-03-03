@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="{{ route('provider_list_path') }}">Task</a>
                </li>
                <li class="crumb-trail">Response</li>
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


         creator_id 	assigned_to_id 	title 	content 	response 	completed 	reminder_sent 	remind_at 	due_at

            $( "#updateTaskForm" ).validate({
                rules: {
                    // required fields:
                    creator_id: {
                        required : true,
                        positive: true
                    },
                    assigned_to_id: {
                        required : true,
                        positive: true
                    },
                    title: {
                        required : true,
                        plainText: true
                    },
                    response: {
                        required : true,
                        plainText: true
                    },
                    // facility conditional fields:
                    name: {
                        required: function(element) {
                            return $('#provider_type_id').val() != 1;
                        },
                        plainText: true
                    },
                    contact_name: {
                        required: function(element) {
                            return $('#provider_type_id').val() != 1;
                        },
                        personName: true
                    },
                    // no required fields:
                    address_2: {
                        required : false,
                        plainText: true
                    },
                    zipcode: {
                        required : false,
                        plainText: true
                    },
                    email: {
                        required: false,
                        email   : true
                    },
                    phone: {
                        required: false,
                        phone   : true
                    },
                    fax: {
                        required: false,
                        phone   : true
                    },
                    verification:{
                        required    : true,
                        smartCaptcha: "{{ $equation['result'] }}"
                    }
                },
                messages: {
                    state_id: {
                        positive: 'Please select State.'
                    },
                    provider_subtype_id: {
                        positive: 'Please select Subtype.'
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