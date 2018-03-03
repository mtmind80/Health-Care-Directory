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
                    <a href="{{ route('professional_internship_list_path', ['professional_id' => $internship->professional_id]) }}">Internships</a>
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
                        {!! Form::model($internship, ['url' => route('professional_internship_update_path', ['id' => $internship->id]), 'method' => 'PATCH', 'id' => 'updateForm']) !!}
                            {!! Form::hidden('id', $internship->id) !!}
                            {!! Form::hidden('professional_id', $internship->professional_id) !!}
                            @include('provider.internship._form', ['formTitle' => 'Update Internship', 'submitButtonText' => 'Update Internship'])
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
                    internship_type_id: {
                        required: true,
                        positive: true
                    },
                    discipline_id: {
                        required: true,
                        positive: true
                    },
                    facility_id: {
                        required: true,
                        positive: true
                    },
                    // not required fields
                    comment: {
                        required : false,
                        plainText: true
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
                    internship_type_id: {
                        positive: 'Pleaase, select a type.'
                    },
                    discipline_id: {
                        positive: 'Pleaase, select a discipline.'
                    },
                    facility_id: {
                        positive: 'Pleaase, select an institution.'
                    }
                }
            });

            $('#cancel-button').click(function(ev){
                ev.preventDefault();
                window.location = "{{ route('professional_internship_list_path', ['professional_id' => $internship->professional_id]) }}";
            });
        });
    </script>
@stop