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
                    <a href="{{ route('credential_document_list_path', ['credential_id' => $credential_id]) }}">Documents</a>
                </li>
                <li class="crumb-trail">Add New</li>
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
                        {!! Form::open(['route' => 'credential_document_store_path', 'id' => 'createForm']) !!}
                            {!! Form::hidden('credential_id', $credential_id) !!}
                            @include('credential.document._form', ['formTitle' => 'Add Document', 'submitButtonText' => 'Add Document', 'create' => true])
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
                    document_type_id: {
                        required: true,
                        positive: true
                    },
                    verification:{
                        required    : true,
                        smartCaptcha: "{{ $equation['result'] }}"
                    }
                },
                messages: {
                    document_type_id: {
                        positive: 'Please, select document type.'
                    }
                }
            });

            $('#cancel-button').click(function(ev){
                ev.preventDefault();
                window.location = "{{ route('credential_document_list_path', ['credential_id' => $credential_id]) }}";
            });

        });
    </script>
@stop