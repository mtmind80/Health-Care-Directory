@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="{{ route('provider_list_path') }}">Providers</a>
                </li>
                <li class="crumb-trail">Edit</li>
            </ol>
        </div>
        <div class="topbar-right">
            <div class="btn-group">
                @include('provider._actionmenu', ['provider_id' => $provider->id, 'professional_id' => ($provider->isProfessional ? $provider->professional->id : null)])
            </div>
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
                        {!! Form::model($provider, ['url' => route('provider_update_path', ['id' => $provider->id]), 'method' => 'PATCH', 'id' => 'updateProviderForm']) !!}
                            {!! Form::hidden('id', $provider->id) !!}
                            @include('provider._form', ['formTitle' => 'Edit Provider', 'submitButtonText' => 'Update Provider'])
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
            $('#updateProviderForm').validate({
                rules: {
                    // required fields:
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
                    provider_type_id: {
                        required: true,
                        positive: true
                    },
                    provider_subtype_id: {
                        required: true,
                        positive: true
                    },
                    // professional conditional fields:
                    first_name: {
                        required: function(element) {
                            return $('#provider_type_id').val() == 1;
                        },
                        personName: true
                    },
                    last_name: {
                        required: function(element) {
                            return $('#provider_type_id').val() == 1;
                        },
                        personName: true
                    },
                    title: {
                        required: function(element) {
                            return $('#provider_type_id').val() == 1;
                        },
                        plainText: true
                    },
                    date_of_birth: {
                        required: function(element) {
                            return $('#provider_type_id').val() == 1;
                        },
                        usDate: true
                    },
                    // facility conditional fields:
                    name: {
                        required: function(element) {
                            return $('#provider_type_id').val() != 1;
                        },
                        plainText: true
                    },
                    contact_name: {
                        required: function(element) {
                            return $('#provider_type_id').val() != 1;
                        },
                        personName: true
                    },
                    // no required fields:
                    address_2: {
                        required : false,
                        plainText: true
                    },
                    zipcode: {
                        required : false,
                        plainText: true
                    },
                    email: {
                        required: false,
                        email   : true
                    },
                    phone: {
                        required: false,
                        phone   : true
                    },
                    fax: {
                        required: false,
                        phone   : true
                    },
                    under_contract: {
                        required: false,
                        boolean : true
                    },
                    verification:{
                        required    : true,
                        smartCaptcha: "{{ $equation['result'] }}"
                    }
                },
                messages: {
                    state_id: {
                        positive: 'Please select State.'
                    },
                    provider_subtype_id: {
                        positive: 'Please select Subtype.'
                    }
                }
            });

            $('#cancel-button').click(function(ev){
                ev.preventDefault();
                window.location = "{{ route('provider_list_path') }}";
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

            var isProfessional = "{{ $provider->isProfessional }}" == "1";

            if (isProfessional) {
                $('.facility-data-section').hide();
                $('.person-data-section').show();
            } else {
                $('.person-data-section').hide();
                $('.facility-data-section').show();
            }

            $('#provider_type_id').change(function(ev){
                $('#data-container').hide();

                $.ajax({
                    type:"post",
                    url: "{{ route('provider_subtype_fetch_path') }}",
                    data: {
                        provider_type_id: $(this).val()
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
                        $('#provider_subtype_id').empty();
                        if (result.success) {
                            var html = ['<option value="0">Select Subtype</option>'];
                            $.each(result.data, function(index, value){
                                html.push('<option value="'+ index +'">'+ value +'</option>')  // person-data-section facility-data-section
                            });
                            $('#provider_subtype_id').html(html.join(''));
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

            $('#provider_subtype_id').change(function(ev){
                if ($(this).val() == 0) {
                    $('#data-container').hide();
                    $('.person-data-section').hide();
                    $('.facility-data-section').hide();
                } else {
                    if ($('#provider_type_id').val() == 1) {        // "person" type
                        $('.facility-data-section').hide();
                        $('.person-data-section').show();

                        $('#name').val('');
                    } else {
                        $('.person-data-section').hide();
                        $('.facility-data-section').show();

                        $('#first_name').val('');
                        $('#last_name').val('');
                    }
                    $('#data-container').show();
                }
            });
        });
    </script>
@stop