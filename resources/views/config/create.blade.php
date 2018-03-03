@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="{{ route('config_list_path') }}">System Settings</a>
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
                        {!! Form::open(['url' => route('config_store_path'), 'id' => 'createConfigForm']) !!}
                        @include('config._form', ['formTitle' => 'New Item', 'submitButtonText' => 'Create Item'])
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js-files')
    <script>
        $(function () {
            $('#createConfigForm').validate({
                rules: {
                    verification:{
                        required    : true,
                        smartCaptcha: "{{ $equation['result'] }}"
                    }
                }
            });

            $('#keyId').rules('add', {
                required  : true,
                minlength : 3,
                identifier: true
            });

            $('#valueId').rules('add', {
                required: true,
                text    : true
            });


            $('#cancel-button').click(function (ev) {
                ev.preventDefault();
                window.location = "{{ route('config_list_path') }}";
            });

        });
    </script>
@stop