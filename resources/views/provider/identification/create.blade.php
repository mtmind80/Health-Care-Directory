@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="{{ route('provider_list_path') }}">Providers</a>
                </li>
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Name: "{{ $professionalName }}"</a>
                </li>
                <li class="crumb-active">
                    <a href="{{ route('professional_identification_list_path', ['professional_id' => $professional_id]) }}">Identification</a>
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
                        {!! Form::open(['route' => 'professional_identification_store_path', 'id' => 'createForm']) !!}
                            {!! Form::hidden('professional_id', $professional_id) !!}
                            @include('provider.identification._form', ['formTitle' => 'New Identification', 'submitButtonText' => 'Add Identification', 'create' => true])
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
                    value: {
                        required : true,
                        plainText: true,
                        minlength: 1
                    },
                    identification_id: {
                        required: true,
                        positive: true
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
                    identification_id: {
                        positive: 'Please, select a identification type.'
                    }
                }
            });

            $('#cancel-button').click(function(ev){
                ev.preventDefault();
                window.location = "{{ route('professional_identification_list_path', ['professional_id' => $professional_id]) }}";
            });
        });
    </script>
@stop