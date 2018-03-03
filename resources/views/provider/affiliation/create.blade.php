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
                    <a href="{{ route('professional_affiliation_list_path', ['professional_id' => $professional_id]) }}">Affiliations</a>
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
                        {!! Form::open(['route' => 'professional_affiliation_store_path', 'id' => 'createForm']) !!}
                            {!! Form::hidden('professional_id', $professional_id) !!}
                            @include('provider.affiliation._form', ['formTitle' => 'New Affiliation', 'submitButtonText' => 'Add Affiliation', 'create' => true])
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
                    facility_id: {
                        required: true,
                        positive: true
                    },
                    // not required fields
                    comment: {
                        required : false,
                        plainText: true
                    },
                    started_at: {
                        required: false,
                        usDate  : true
                    },
                    ended_at: {
                        required: false,
                        usDate  : true
                    },
                    verification:{
                        required    : true,
                        smartCaptcha: "{{ $equation['result'] }}"
                    }
                },
                messages: {
                    facility_id: {
                        positive: 'Pleaase, select a hospital.'
                    }
                }
            });

            $('#cancel-button').click(function(ev){
                ev.preventDefault();
                window.location = "{{ route('professional_affiliation_list_path', ['professional_id' => $professional_id]) }}";
            });
        });
    </script>
@stop