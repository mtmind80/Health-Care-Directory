@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">`
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="{{ route('provider_list_path') }}">Providers</a>
                </li>
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Name: "{{ $professionalName }}"</a>
                </li>
                <li class="crumb-active">
                    <a href="{{ route('professional_school_list_path', ['professional_id' => $school->professional_id]) }}">School</a>
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
                        {!! Form::model($school, ['url' => route('professional_school_update_path', ['id' => $school->id]), 'method' => 'PATCH', 'id' => 'updateForm']) !!}
                        {!! Form::hidden('id', $school->id) !!}
                        {!! Form::hidden('professional_id', $school->professional_id) !!}
                        @include('provider.school._form', ['formTitle' => 'Update School', 'submitButtonText' => 'Update School'])
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
                    school_id: {
                        required: true,
                        positive: true
                    },
                    degree_id: {
                        required: true,
                        positive: true
                    },
                    // not required fields
                    comment: {
                        required : false,
                        text: true,
                        minlength: 10
                    },
                    started_at: {
                        required: false,
                        usDate  : true
                    },
                    ended_at: {
                        required: false,
                        usDate  : true
                    },
                    verification:{
                        required    : true,
                        smartCaptcha: "{{ $equation['result'] }}"
                    }
                },
                messages: {
                    school_id: {
                        positive: 'Please, select a school.'
                    },
                    degree_id: {
                        positive: 'Please, select a degree.'
                    }
                }
            });

            $('#cancel-button').click(function(ev){
                ev.preventDefault();
                window.location = "{{ route('professional_school_list_path', ['professional_id' => $school->professional_id]) }}";
            });
        });
    </script>
@stop