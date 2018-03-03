@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Credential Data</a>
                </li>
                <li class="crumb-active">
                    <a href="{{ route('certification_list_path') }}">Certification</a>
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
                        {!! Form::open(['route' => 'certification_store_path', 'id' => 'createCertificationForm']) !!}
                            @include('certification._form', ['formTitle' => 'New Certification', 'submitButtonText' => 'Create Certification', 'create' => true])
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
            $( "#createCertificationForm" ).validate({
                rules: {
                    name: {
                        required : true,
                        plainText: true,
                        minlength: 3
                    },
                    code: {
                        required : true,
                        plainText: true
                    },
                    verification:{
                        required    : true,
                        smartCaptcha: "{{ $equation['result'] }}"
                    }
                }
            });

            $('#cancel-button').click(function(ev){
                ev.preventDefault();
                window.location = "{{ route('certification_list_path') }}";
            });

        });
    </script>
@stop