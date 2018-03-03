@extends('layouts.login')

@section('content')
    <div id="main" class="animated fadeIn">
        <section id="content_wrapper">
            <section id="content">
                <div class="admin-form theme-info" id="login1">
                    <div class="row mb15 table-layout">
                        <div class="col-xs-6 va-m pln">
                        </div>
                        <div class="col-xs-6 text-right va-b pr5">
                            <div class="login-links">
                                Reset Password
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-info mt10 br-n">
                        {!!Form::open(['route' => 'reset_password_path', 'id' => 'resetPasswordForm', 'name' => 'resetPasswordForm']) !!}
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="panel-body bg-light p24">
                                <div class="row">
                                    <div class="">
                                        @if (count($errors) > 0)
                                            <div class="alert alert-danger alert-dismissable">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                <i class="fa fa-remove pr10"></i>
                                                @foreach ($errors->all() as $error)
                                                    {{ $error }}<br />
                                                @endforeach
                                            </div>
                                        @endif
                                        <div class="section">
                                            <label for="email" class="field-label text-muted fs18 mb10">Email</label>
                                            <label for="email" class="field prepend-icon">
                                                <input type="text" name="email" id="email" class="gui-input" placeholder="Enter email">
                                                <span class="field-icon"><i class="fa fa-user"></i></span>
                                            </label>
                                        </div>
                                        <div class="section">
                                            <label for="password" class="field-label text-muted fs18 mb10">Password</label>
                                            <label for="password" class="field prepend-icon">
                                                <input type="password" name="password" id="password" class="gui-input" placeholder="Enter password">
                                                <span class="field-icon"><i class="fa fa-lock"></i></span>
                                            </label>
                                        </div>
                                        <div class="section">
                                            <label for="password_confirmation" class="field-label text-muted fs18 mb10">Confirm Password</label>
                                            <label for="password_confirmation" class="field prepend-icon">
                                                <input type="password" name="password_confirmation" id="password_confirmation" class="gui-input" placeholder="Confirm password">
                                                <span class="field-icon"><i class="fa fa-unlock-alt"></i></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer clearfix p10 ph15 text-center">
                                <button type="submit" class="button btn-primary mr10">Reset Password</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </section>
        </section>
    </div>
@endsection

@section('js-files')
    <script>
        $(document).ready(function(){
            $('#resetPasswordForm').validate({
                rules: {
                    email: {
                        required: true,
                        email   : true
                    },
                    password:{
                        required : true,
                        password : true,
                        minlength: 6
                    },
                    password_confirmation:{
                        required : true,
                        password : true,
                        minlength: 6,
                        equalTo  : '#password'
                    }
                },
                messages: {
                    password: {
                        minlength: 'Password should have at least {1} characters.'
                    },
                    password_confirmation: 'Passwords don\'t match.'
                }
            });
        });
    </script>
@stop