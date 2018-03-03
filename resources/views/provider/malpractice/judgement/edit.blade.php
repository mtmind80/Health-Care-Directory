@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Provider: "{{ $providerName }}"</a>
                </li>
                <li class="crumb-active">
                    <a href="{{ route('provider_malpractice_list_path', ['provider_id' => $provider_id]) }}">Policy: "{{ $policyNumber }}"</a>
                </li>
                <li class="crumb-active">
                    <a href="{{ route('provider_malpractice_judgement_list_path', ['malpractice_id' => $malpractice_id]) }}">Judgements</a>
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
                        {!! Form::model($judgement, ['url' => route('provider_malpractice_judgement_update_path', ['id' => $judgement->id]), 'method' => 'PATCH', 'id' => 'updateForm']) !!}
                            {!! Form::hidden('id', $judgement->id) !!}
                            {!! Form::hidden('malpractice_id', $malpractice_id) !!}
                            @include('provider.malpractice.judgement._form', ['formTitle' => 'Edit Judgement', 'submitButtonText' => 'Update Judgement'])
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
                    offense_type_id: {
                        required: true,
                        positive: true
                    },
                    occurred_at: {
                        required: true,
                        usDate  : true
                    },
                    reported_at: {
                        required: true,
                        usDate  : true
                    },
                    // not required fields
                    settled_at: {
                        required: false,
                        usDate  : true
                    },
                    defendant: {
                        required: false,
                        boolean : true
                    },
                    dismissed: {
                        required: false,
                        boolean : true
                    },
                    primary_sourced: {
                        required: false,
                        boolean : true
                    },
                    plaintiff_name: {
                        required : false,
                        plainText: true
                    },
                    settled_amount: {
                        required: false,
                        currency: true
                    },
                    verification:{
                        required    : true,
                        smartCaptcha: "{{ $equation['result'] }}"
                    }
                },
                messages: {
                    offense_type_id: {
                        positive: 'Please, select offense type.'
                    }
                }
            });

            $('#cancel-button').click(function(ev){
                ev.preventDefault();
                window.location = "{{ route('provider_malpractice_judgement_list_path', ['malpractice_id' => $malpractice_id]) }}";
            });
        });
    </script>
@stop