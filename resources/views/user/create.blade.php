@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Users &amp; Access</a>
                </li>
                <li class="crumb-active">
                    <a href="{{ route('user_list_path') }}">Users</a>
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
                    <div class="section row mb30">
                        <div id="picture-container"></div>
                    </div>

                    <div class="panel">
                        {!! Form::open(['url' => route('user_store_path'), 'id' => 'createUserForm']) !!}
                            @include('user._form', ['formTitle' => 'New User', 'submitButtonText' => 'Create User', 'newUser' => true, 'roleId' => ''])
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
            $('#createUserForm').validate({
                rules: {
                    // required fields:
                    first_name: {
                        required  : true,
                        firstName: true
                    },
                    last_name: {
                        required: true,
                        lastName: true
                    },
                    email: {
                        required: true,
                        email   : true
                    },
                    verification:{
                        required    : true,
                        smartCaptcha: "{{ $equation['result'] }}"
                    },
                    // not required fields:
                    password:{
                        required : true,
                        password : true,
                        minlength: 6
                    },
                    repeat_password:{
                        required : true,
                        password : true,
                        equalTo  : '#password',
                        minlength: 6
                    }
                },
                messages: {
                    password: {
                        minlength: 'Password should have at least {0} characters.'
                    },
                    repeat_password: 'Passwords don\'t match.'
                }
            });

            $('.dropzone').html5imageupload({
                token: "{{ $encToken }}"
            });

            $('.dropzone').html5imageupload({
                onAfterSelectImage: function() {
                    resetError($(this.element));
                },
                onAfterProcessImage: function() {
                    $('#avatar').val($(this.element).data('newFileName'));
                    resetError($(this.element));
                },
                onAfterCancel: function() {
                    setError($(this.element));
                },
                onAfterRemoveImage: function() {
                    setError($(this.element));
                }
            });

            $('#cancel-button').click(function(ev){
                ev.preventDefault();
                window.location = "{{ route('user_list_path') }}";
            });

            var rolesChanged = false;

            $('#roles').multiselect({
                includeSelectAllOption: false,

                onChange: function(element, checked) {
                    if (checked === false && !$('#roles').val()) {
                        rolesChanged = false;
                        uiAlert({type: 'error', text: 'You must have at least one role selected.'});
                        $('#roles').multiselect('select', element.val());

                    } else {
                        rolesChanged = true;
                    }
                },

                onDropdownHide: function(element, checked) {
                    if (rolesChanged) {
                        if (!$('#roles').val()) {
                            alert('no roles selected');
                        } else {
                            $.ajax({
                                type:"post",
                                url: "{{ route('user_fetch_roles_privileges_path') }}",
                                data: {
                                    roleIds: JSON.stringify($('#roles').val())
                                },
                                beforeSend: function (request){
                                    showSpinner();
                                    request.setRequestHeader("X-XSRF-TOKEN", "{{ $encToken }}");
                                },
                                complete: function(){
                                    hideSpinner();
                                },
                                success: function(response){
                                    var result = $.parseJSON(response);
                                    console.log(result);
                                    if (result.success) {
                                        $('#rolesPrivileges').multiselect('deselectAll', false);

                                        if (result.rolesPrivilegesIds.length > 0) {
                                            $('#rolesPrivileges').multiselect('select', result.rolesPrivilegesIds);
                                        }

                                        $('#rolesPrivileges').multiselect('updateButtonText');

                                        rolesChanged = false;
                                    } else {
                                        uiAlert({type: 'error', text: result.message});
                                    }
                                }
                            });
                        }

                    }
                }
            });

            $('#rolesPrivileges').multiselect({
                includeSelectAllOption: false,

                onChange: function(element, checked) {
                    uiAlert({type: 'info', text: '<p>This is a read-only list. Role-related privileges can only be granted/revoke to/from a role on Roles section.</p><p>To grant a privilege this user does not have without assigning a new role, use the User-related Privilege box.</p>'});
                    if (checked === true) {
                        $('#rolesPrivileges').multiselect('deselect', element.val());
                    } else if (checked === false) {
                        $('#rolesPrivileges').multiselect('select', element.val());
                    }
                }
            });

            $('#privileges').multiselect({
                includeSelectAllOption: true
            });

            $('#submit-button').click(function(ev){
                if ($('#roles option:selected').size() == 0) {
                    ev.preventDefault();
                    uiAlert({type: 'error', text: 'You must select at least one role.'});
                }
            });
        });
        function resetError(el)
        {
            el.next('em.state-error').remove();
            el.removeClass('state-error');
        }
        function setError(el)
        {
            $('#avatar').val('');
            $('#avatarFileField').val('');
            if (!el.hasClass('state-error')) {
                el.addClass('state-error');
            }
            if ($('#avatarFileField-error').size() == 0) {
                el.after('<em class="state-error avatar-error" id="avatarFileField-error">This field is required.</em>');
            }
        }
    </script>
@stop