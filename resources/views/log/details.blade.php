@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="{{ route('log_list_path') }}">Provider Modifications</a>
                </li>
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Log created at: {{ $log->html_created_at }}</a>
                </li>
                <li class="crumb-trail">Details</li>
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
                        <div class="panel-body pb40">
                            <div class="section-divider mb30 mt20"><span>Log Details</span></div>
                            <section>
                                <div class="section row">
                                    <div class="col-md-6">
                                        {{ Form::jShow($log->provider->name, ['label' => 'Provider Name']) }}
                                    </div>
                                    <div class="col-md-6">
                                        {{ Form::jShow($log->comment, ['label' => 'Section']) }}
                                    </div>
                                </div>
                                <div class="section row">
                                    <div class="col-md-6">
                                        {{ Form::jShow($log->action->name, ['label' => 'Action']) }}
                                    </div>
                                    <div class="col-md-6">
                                        {{ Form::jShow($log->user->fullName, ['label' => 'Who Made the Action']) }}
                                    </div>
                                </div>
                                <div class="section row">
                                    <div class="col-md-6">
                                        {{ Form::jShow($log->created_at->format('m/d/Y - H:i'), ['label' => 'Created At']) }}
                                    </div>
                                    <div class="col-md-6">

                                    </div>
                                </div>
                            </section>

                            @if (!empty($log->modifications))
                                <div class="section-divider mb5 mt50"><span>Modifications</span></div>
                                @foreach ($log->modifications as $fieldName => $state)
                                    <div class="row mb5">
                                        <h3 class="ml11 fs15 fwb">{{ $fieldName }}</h3>
                                        <div class="col-md-6">
                                            {{ Form::jShow($state->before, ['label' => 'Before']) }}
                                        </div>
                                        <div class="col-md-6">
                                            {{ Form::jShow($state->after, ['label' => 'After']) }}
                                        </div>
                                    </div>

                                @endforeach
                            @endif
                        </div>
                        <div class="panel-footer text-right">
                            <div class="row">
                                <div class="col-md-6">

                                </div>
                                <div class="col-md-6">
                                    <button id="close-button" class="button btn-default mr10">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js-files')
    <script>
        $(function(){
            $('#close-button').click(function(ev){
                ev.preventDefault();
                window.location = "{{ route('log_list_path') }}";
            });
        });
    </script>
@stop