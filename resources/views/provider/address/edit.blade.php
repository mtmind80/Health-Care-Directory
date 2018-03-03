@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">`
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="{{ route('provider_list_path') }}">Providers</a>
                </li>
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Name: "{{ $providerName }}"</a>
                </li>
                <li class="crumb-active">
                    <a href="{{ route('provider_address_list_path', ['provider_id' => $address->provider_id]) }}">Addresses</a>
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
                        {!! Form::model($address, ['url' => route('provider_address_update_path', ['id' => $address->id]), 'method' => 'PATCH', 'id' => 'updateForm']) !!}
                            {!! Form::hidden('id', $address->id) !!}
                            {!! Form::hidden('provider_id', $address->provider_id) !!}
                            @include('provider.address._form', ['formTitle' => 'Update Address', 'submitButtonText' => 'Update Address'])
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
                    address_type_id: {
                        required: true,
                        positive: true
                    },
                    address: {
                        required : true,
                        plainText: true
                    },
                    city: {
                        required : true,
                        plainText: true
                    },
                    state_id: {
                        required: true,
                        positive: true
                    },
                    country_id: {
                        required: true,
                        positive: true
                    },
                    zipcode: {
                        required: true,
                        plainText: true
                    },
                    // not required fields
                    address_2: {
                        required : false,
                        plainText: true
                    },
                    verification:{
                        required    : true,
                        smartCaptcha: "{{ $equation['result'] }}"
                    }
                },
                messages: {
                    address_type_id: {
                        positive: 'Pleaase, select a type.'
                    },
                    state_id: {
                        positive: 'Pleaase, select a state.'
                    },
                    country_id: {
                        positive: 'Pleaase, select a country.'
                    }
                }
            });

            $('#cancel-button').click(function(ev){
                ev.preventDefault();
                window.location = "{{ route('provider_address_list_path', ['provider_id' => $address->provider_id]) }}";
            });

            $('#country_id').change(function(ev){
                $.ajax({
                    type:"post",
                    url: "{{ route('state_fetch_path') }}",
                    data: {
                        country_id: $(this).val()
                    },
                    beforeSend: function (request){
                        PNotify.removeAll();
                        showSpinner();
                        request.setRequestHeader("X-XSRF-TOKEN", "{{ $encToken }}");
                    },
                    complete: function(){
                        hideSpinner();
                    },
                    success: function(response){
                        var result = $.parseJSON(response);
                        $('#state_id').empty();
                        if (result.success) {
                            var html = ['<option value="0">Select State</option>'];
                            $.each(result.data, function(index, value){
                                html.push('<option value="'+ index +'">'+ value +'</option>')
                            });
                            $('#state_id').html(html.join(''));
                        } else {
                            pnAlert({
                                type: 'error',
                                title: 'Error',
                                text: result.message,
                                addClass: 'mt50'
                            });
                        }
                    }
                });
            });
        });
    </script>
@stop