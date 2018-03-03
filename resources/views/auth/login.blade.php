@extends('layouts.login')

@section('content')
    <div id="main" class="animated fadeIn">
        <section id="content_wrapper">
            <section id="content">
                <div class="admin-form theme-info" id="login1">
                    <div class="row mb15 table-layout">
                        <div class="col-xs-6 va-m pln">
                            &nbsp;
                        </div>
                        <div class="col-xs-6 text-right va-b pr5">
                            <div class="login-links">
                                Sign In
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-info mt10 br-n">
                        {!!Form::open(['route' => 'login_path', 'id' => 'loginForm', 'name' => 'loginForm']) !!}
                            <div class="panel-body bg-light p24">
                                <div class="row">
                                    <div class="">
                                        @include ('errors._list')
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
                                        <div class="section text-right">
                                            <a href="{{ route('reset_form_path') }}">Forgot Your Password?</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer clearfix p10 ph15">
                                <button type="submit" class="button btn-primary mr10 pull-right">Sign In</button>
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
            $('#loginForm').validate({
                rules: {
                    email: {
                        required: true,
                        email   : true
                    },
                    password:{
                        required : true,
                        password : true,
                        minlength: 6
                    }
                }
            });
            $('#remember-me-label').click(function(){
                $('#remember-me-widget').click();
            });
        });
    </script>
@stop
