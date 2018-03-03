@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Providers</a>
                </li>
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Type: "{{ $providerTypeName }}"</a>
                </li>
                <li class="crumb-active">
                    <a href="{{ route('provider_subtype_list_path', ['provider_type_id' => $provider_type_id]) }}">State</a>
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
                        {!! Form::open(['route' => 'provider_subtype_store_path', 'id' => 'createStateForm']) !!}
                            {!! Form::hidden('provider_type_id', $provider_type_id) !!}
                            @include('providertype.providersubtype._form', ['formTitle' => 'New Provider Subtype', 'submitButtonText' => 'Create Provider Subtype', 'create' => true])
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
            $( "#createStateForm" ).validate({
                rules: {
                    name: {
                        required : true,
                        plainText: true,
                        minlength: 1
                    },
                    verification:{
                        required    : true,
                        smartCaptcha: "{{ $equation['result'] }}"
                    }
                }
            });

            $('#cancel-button').click(function(ev){
                ev.preventDefault();
                window.location = "{{ route('provider_subtype_list_path', ['provider_type_id' => $provider_type_id]) }}";
            });
        });
    </script>
@stop