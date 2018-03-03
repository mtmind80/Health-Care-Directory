@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="{{ route('credential_list_path') }}">Credentials</a>
                </li>
                <li class="crumb-trail">Create</li>
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
                        {!! Form::open(['route' => 'credential_store_path', 'id' => 'createForm']) !!}
                            @include('credential._form', ['formTitle' => 'New Credential', 'submitButtonText' => 'Create Credential', 'create' => true])
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
            $('#createForm').validate({
                rules: {
                    // required fields:
                    customer_id: {
                        required: true,
                        positive: true
                    },
                    professional_id: {
                        required: true,
                        positive: true
                    },
                    status_id: {
                        required: true,
                        positive: true
                    },
                    assigned_to_id: {
                        required: true,
                        positive: true
                    },
                    verification:{
                        required    : true,
                        smartCaptcha: "{{ $equation['result'] }}"
                    }
                },
                messages: {
                    customer_id: {
                        positive: 'Please select Customer.'
                    },
                    professional_id: {
                        positive: 'Please select Provider.'
                    },
                    assigned_to_id: {
                        positive: 'Please select Assigned To.'
                    }
                }
            });

            $('#cancel-button').click(function(ev){
                ev.preventDefault();
                window.location = "{{ route('credential_list_path') }}";
            });

        });
    </script>
@stop