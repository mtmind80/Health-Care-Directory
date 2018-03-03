@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="{{ route('credential_list_path') }}">Credentials</a>
                </li>
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Provider: "{{ $credentialProfessionalName }}"</a>
                </li>
                <li class="crumb-active">
                    <a href="{{ route('credential_document_list_path', ['credential_id' => $credential_id]) }}">Document: "{{ $credentialDocumentType }}"</a>
                </li>
                <li class="crumb-active">
                    <a href="{{ route('credential_document_action_list_path', ['document_id' => $document_id]) }}">Actions</a>
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
                        {!! Form::model($credentialDocumentAction, ['url' => route('credential_document_action_update_path', ['id' => $credentialDocumentAction->id]), 'method' => 'PATCH', 'id' => 'updateForm']) !!}
                            {!! Form::hidden('id', $credentialDocumentAction->id) !!}
                            {!! Form::hidden('document_id', $document_id) !!}
                            @include('credential.document.action._form', ['formTitle' => 'Edit Document Action', 'submitButtonText' => 'Update Document Action'])
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
            $('#updateForm').validate({
                rules: {
                    // required fields
                    action_type_id: {
                        required: true,
                        positive: true
                    },
                    // not required fields
                    comment: {
                        required : false,
                        text     : true,
                        minlength: 10
                    },
                    verification:{
                        required    : true,
                        smartCaptcha: "{{ $equation['result'] }}"
                    }
                },
                messages: {
                    action_type_id: {
                        positive: 'Please, select action type.'
                    }
                }
            });

            $('#cancel-button').click(function(ev){
                ev.preventDefault();
                window.location = "{{ route('credential_document_action_list_path', ['document_id' => $document_id]) }}";
            });
        });
    </script>
@stop