@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Provider Logs</a>
                </li>
                <li class="crumb-trail">List</li>
            </ol>
        </div>
        <div class="topbar-right">
        </div>
    </header>
@stop

@section('content')
        <!-- Image popup -->
    <div id="userAvatar" class="popup-basic popup-lg mfp-with-anim mfp-hide">
        <img class="img-responsive" src="{{ $siteUrl }}" alt="">
    </div>

    <div id="content" class="animated fadeIn list-items admin-form">
        @include('errors._list')
        <div class="clearfix">
            <div class="xs-hidden col-xs-12 col-sm-6 pl0 ml0 pr0 mr0 mb15">
            </div>
            <div class="col-xs-12 col-sm-6 pl0 ml0 pr0 mr0 mb15 search-container">
                @if (Auth::user()->isAllowTo('search-log'))
                    {!! Form::open(['route' => 'log_search_path', 'id' => 'searchForm']) !!}
                    <span class="field search-input-container">
                        {!! Form::text('needle', $needle, ['class' => 'gui-input search-input', 'id' => 'needle', 'placeholder' => 'to search for a date, enter as "yyyy-mm-dd"']) !!}
                    </span>
                    <button id="button-search" class="btn btn-info search-button">
                        <i class="fa fa-search mr10"></i>Search
                    </button>
                    @if (!empty($needle))
                        <button class="btn btn-default reset-button equis" type="button" data-location="logs">x</button>
                    @endif
                    {!! Form::close() !!}
                @endif
            </div>
        </div>

        <div class="panel" id="spy7">
            <div class="panel-body pn">
                <table class="table table-bordered list-table">
                    <thead>
                    <tr>
                        <th class="">Provider Name</th>
                        <th class="td-sortable td-name">{!! SortableTrait::link('actions.name|logs.action_id', 'Action') !!}</th>
                        <th class="td-sortable">{!! SortableTrait::link('users.first_name|logs.user_id', 'User') !!}</th>
                        <th class="xs-hidden">Section</th>
                        <th class="td-sortable xs-hidden">{!! SortableTrait::link('created_at', 'Created At') !!}</th>
                        <th class="actions">Actions</th>
                    </tr>
                    </thead>

                    <tbody id="sortable-body">
                        @foreach ($logs as $log)
                            <tr data-id="{{ $log->id }}" class="{{ !empty($log->disabled) ? 'disabled' : '' }}">

                                <td>{!! $log->provider->isProfessional ? $log->provider->professional->fullName : $log->provider->facility->name !!}</td>
                                <td class="">{{ $log->action->name }}</td>
                                <td class="">{{ $log->user->fullName }}</td>
                                <td class="xs-hidden">{{ $log->comment }}</td>
                                <td class="xs-hidden">{{ $log->created_at->format('m/d/Y - H:i') }}</td>
                                <td class="centered actions">
                                    <ul class="nav navbar-nav">
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i></a>
                                            <ul class="dropdown-menu animated animated-short flipInX" role="menu">
                                                @if (Auth::user()->isAllowTo('show-log'))
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="show" data-id="{{ $log->id }}">
                                                            <span class="fa fa-eye mr10"></span>Show Details
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row pagination-container clearfix text-center">
            <div class="col-xs-12 col-sm-4">
                <div class="pull-left pagination-info">
                    <span>Showing {{ $logs->perPage() }} of {!! $logs->total() !!} entries</span>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 pagination-pages">
                Items per page:
                <select id="pageItems" class="form-control">
                    <option value="{{ route('log_list_path', array_merge(Request::query(), ['page' => 0, 'perPage' => 10])) }}"{{ Request::input('perPage') == 10 ? ' selected' : '' }}>10</option>
                    <option value="{{ route('log_list_path', array_merge(Request::query(), ['page' => 0, 'perPage' => 20])) }}"{{ Request::input('perPage') == 20 ? ' selected' : '' }}>20</option>
                    <option value="{{ route('log_list_path', array_merge(Request::query(), ['page' => 0, 'perPage' => $logs->total()])) }}"{{ Request::input('perPage') == $logs->total() ? ' selected' : '' }}>All</option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-4 pull-right pagination-handlers text-right">
                @include('components.pagination.custom', ['paginator' => $logs, 'route' => 'log_list_path', 'query' => http_build_query(Input::except(['page', '_token']))])
            </div>
        </div>
    </div>
@endsection

@section('js-files')
    <script>
        $(function(){
            $('#pageItems').change(function(){
                window.location.href = $(this).val();
            });

            $('#needle').blur(function(){
                $(this).parents('label').removeClass('state-error').next('em').remove();
            });

            $( "#searchForm" ).validate({
                rules: {
                    needle: {
                        minlength: 3,
                        text     : true
                    }
                }
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="show"]', function(){
                window.location = "{{ asset('logs') }}/show/" + $(this).attr('data-id');
            });
        });
    </script>
@stop