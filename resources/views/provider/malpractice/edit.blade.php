@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="{{ route('provider_list_path') }}">Providers</a>
                </li>
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Provider: "{{ $providerName }}"</a>
                </li>
                <li class="crumb-active">
                    <a href="{{ route('provider_malpractice_list_path', ['provider_id' => $provider_id]) }}">Malpractices</a>
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
                        {!! Form::model($malpractice, ['url' => route('provider_malpractice_update_path', ['id' => $malpractice->id]), 'method' => 'PATCH', 'id' => 'updateForm']) !!}
                            {!! Form::hidden('id', $malpractice->id) !!}
                            {!! Form::hidden('provider_id', $provider_id) !!}
                            @include('provider.malpractice._form', ['formTitle' => 'Edit Malpractice ', 'submitButtonText' => 'Update Malpractice '])
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
                    insurer_id: {
                        required: true,
                        positive: true
                    },
                    policy_type_id: {
                        required: true,
                        positive: true
                    },
                    policy_number: {
                        required : true,
                        plainText: true
                    },
                    // not required fields
                    per_occurance: {
                        required : false,
                        plainText: true
                    },
                    in_aggregate: {
                        required : false,
                        plainText: true
                    },
                    insurance_proof: {
                        required: false,
                        boolean : true
                    },
                    primary_sourced: {
                        required: false,
                        boolean : true
                    },
                    retroactive_at: {
                        required: false,
                        usDate  : true
                    },
                    started_at: {
                        required: false,
                        usDate  : true
                    },
                    expired_at: {
                        required: false,
                        usDate  : true
                    },
                    verification:{
                        required    : true,
                        smartCaptcha: "{{ $equation['result'] }}"
                    }
                },
                messages: {
                    insurer_id: {
                        positive: 'Please, select insurer.'
                    },
                    policy_type_id: {
                        positive: 'Please, select policy type.'
                    }
                }
            });

            $('#cancel-button').click(function(ev){
                ev.preventDefault();
                window.location = "{{ route('provider_malpractice_list_path', ['provider_id' => $provider_id]) }}";
            });
        });
    </script>
@stop