@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="{{ route('home_path') }}">Home</a>
                </li>
                <li class="crumb-trail">My Profile</li>
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
                        {!! Form::model($user, ['url' => [route('user_update_profile_path', ['id' => $user->id])], 'method' => 'PATCH', 'id' => 'profileForm']) !!}
                            {!! Form::hidden('id', $user->id) !!}
                            {!! Form::hidden('returnTo', $returnTo) !!}
                            @include('user._form', ['formTitle' => 'My Profile', 'profile' => true, 'submitButtonText' => 'Update Profile'])
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
            $('#profileForm').validate({
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
                    // no required fields:
                    password:{
                        required   : false,
                        password   : true,
                        rangelength: [6, 16],
                    },
                    repeat_password:{
                        required   : false,
                        password   : true,
                        rangelength: [6, 16],
                        equalTo  : '#password'
                    }
                },
                messages: {
                    password: {
                        rangelength: 'Password should be between {0} and {1} characters.',
                    },
                    repeat_password: 'Passwords don\'t match.'
                }
            });

            $('.dropzone').html5imageupload({
                token: "{{ $encToken }}",
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

            $('.multiselect').multiselect({
                includeSelectAllOption: false,
                // onChange doesn't work for disabled options:
                onChange: function(element, checked) {
                    uiAlert({type: 'info', text: '<p>This is a read-only section. You cannot modify your own roles/privileges.</p>'});
                    if (checked === true) {
                        $(this).multiselect('deselect', element.val());
                    } else if (checked === false) {
                        $(this).multiselect('select', element.val());
                    }
                }
            });

            $('a').on('click', '.multiselect', function(){

                    alert('aqui');
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