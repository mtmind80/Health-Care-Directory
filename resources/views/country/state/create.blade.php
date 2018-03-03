@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">System Data</a>
                </li>
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Country: "{{ $countryName }}"</a>
                </li>
                <li class="crumb-active">
                    <a href="{{ route('state_list_path', ['country_id' => $country_id]) }}">State</a>
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
                        {!! Form::open(['route' => 'state_store_path', 'id' => 'createStateForm']) !!}
                            {!! Form::hidden('country_id', $country_id) !!}
                            @include('country.state._form', ['formTitle' => 'New State', 'submitButtonText' => 'Create State', 'create' => true])
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
                    short_name: {
                        required   : true,
                        letter     : true,
                        rangelength: [2, 2]
                    },
                    name: {
                        required : true,
                        plainText: true
                    },
                    verification:{
                        required    : true,
                        smartCaptcha: "{{ $equation['result'] }}"
                    }
                },
                messages: {
                    short_name: {
                        rangelength: 'Short Name must be a two char word.'
                    }
                }
            });

            $('#cancel-button').click(function(ev){
                ev.preventDefault();
                window.location = "{{ route('state_list_path', ['country_id' => $country_id]) }}";
            });

        });
    </script>
@stop