@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">`
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="{{ route('provider_list_path') }}">Providers</a>
                </li>
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Name: "{{ $providerName }}"</a>
                </li>
                <li class="crumb-active">
                    <a href="{{ route('provider_procedure_list_path', ['provider_id' => $procedure->provider_id]) }}">Procedures</a>
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
                        {!! Form::model($procedure, ['url' => route('provider_procedure_update_path', ['id' => $procedure->id]), 'method' => 'PATCH', 'id' => 'updateForm']) !!}
                            {!! Form::hidden('id', $procedure->id) !!}
                            {!! Form::hidden('provider_id', $procedure->provider_id) !!}
                            @include('provider.procedure._form', ['formTitle' => 'Update Procedure', 'submitButtonText' => 'Update Procedure'])
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
                    procedure_id: {
                        required: true,
                        positive: true
                    },
                    comment: {
                        required : true,
                        plainText: true
                    },
                    verification:{
                        required    : true,
                        smartCaptcha: "{{ $equation['result'] }}"
                    }
                },
                messages: {
                    procedure_id: {
                        positive: 'Pleaase, select a procedure.'
                    }
                }
            });

            $('#cancel-button').click(function(ev){
                ev.preventDefault();
                window.location = "{{ route('provider_procedure_list_path', ['provider_id' => $procedure->provider_id]) }}";
            });
        });
    </script>
@stop