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
                    @if (session('status'))
                        <div class="panel panel-info mt10 br-n">
                            <div class="panel-body bg-light p24">
                                <div class="row">
                                    <div class="">
                                        <div class="alert alert-success">
                                            {{ session('status') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="panel panel-info mt10 br-n">
                            {!!Form::open(['route' => 'send_reset_link_path', 'id' => 'forgotPasswordForm', 'name' => 'forgotPasswordForm']) !!}
                                <div class="panel-body bg-light p24">
                                    <div class="row">
                                        <div class="">
                                            @if (session('status'))
                                                <div class="alert alert-success">
                                                    {{ session('status') }}
                                                </div>
                                            @endif
                                            @if (count($errors) > 0)
                                                <div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                    <i class="fa fa-remove pr10"></i>
                                                    Invalid and/or missing email
                                                </div>
                                            @endif
                                            <div class="section">
                                                <label for="email" class="field-label text-muted fs18 mb10">Email</label>
                                                <label for="email" class="field prepend-icon">
                                                    <input type="text" name="email" id="email" class="gui-input" placeholder="Enter email" value="{{ old('email') }}">
                                                    <span class="field-icon"><i class="fa fa-user"></i></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer clearfix p10 ph15 text-center">
                                    <button type="submit" class="button btn-primary mr10">Send Password Reset Link</button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    @endif
                </div>
            </section>
        </section>
    </div>
@endsection

@section('js-files')
    <script>
        $(document).ready(function(){
            $('#forgotPasswordForm').validate({
                rules: {
                    email: {
                        required: true,
                        email   : true
                    }
                }
            });
        });
    </script>
@stop
