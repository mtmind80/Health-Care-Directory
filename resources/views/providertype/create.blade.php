@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="{{ route('provider_list_path') }}" class="no-link">Providers</a>
                </li>
                <li class="crumb-active">
                    <a href="{{ route('provider_type_list_path') }}">Types</a>
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
                        {!! Form::open(['route' => 'provider_type_store_path', 'id' => 'createProviderTypeForm']) !!}
                            @include('providertype._form', ['formTitle' => 'New Provider Type', 'submitButtonText' => 'Create Provider Type', 'create' => true])
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
            $( "#createProviderTypeForm" ).validate({
                rules: {
                    name: {
                        required : true,
                        plainText: true,
                        minlength: 3
                    },
                    verification:{
                        required    : true,
                        smartCaptcha: "{{ $equation['result'] }}"
                    }
                }
            });

            $('#cancel-button').click(function(ev){
                ev.preventDefault();
                window.location = "{{ route('provider_type_list_path') }}";
            });

        });
    </script>
@stop