@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">System Data</a>
                </li>
                <li class="crumb-active">
                    <a href="{{ route('address_type_list_path') }}">Address Type</a>
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
                        {!! Form::open(['route' => 'address_type_store_path', 'id' => 'createAddressTypeForm']) !!}
                            @include('addresstype._form', ['formTitle' => 'New Address Type', 'submitButtonText' => 'Create Address Type', 'create' => true])
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
            $( "#createAddressTypeForm" ).validate({
                rules: {
                    name: {
                        required : true,
                        plainText: true,
                        minlength: 3
                    },
                    code: {
                        required: true,
                        code    : true
                    },
                    verification:{
                        required    : true,
                        smartCaptcha: "{{ $equation['result'] }}"
                    }
                }
            });

            $('#cancel-button').click(function(ev){
                ev.preventDefault();
                window.location = "{{ route('address_type_list_path') }}";
            });

        });
    </script>
@stop