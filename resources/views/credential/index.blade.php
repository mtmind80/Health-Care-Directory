@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Credentials</a>
                </li>
                <li class="crumb-trail">List</li>
            </ol>
        </div>
        <div class="topbar-right">
        </div>
    </header>
@stop

@section('content')
    <div id="content" class="animated fadeIn list-items admin-form">
        @include('errors._list')
        <div class="clearfix">
            <div class="col-xs-12 col-sm-6 pl0 ml0 pr0 mr0 mb15">
                <div class="btn-group">
                    @if (Auth::user()->isAllowTo('create-credential'))
                        <button id="button-create" class="btn btn-success mr10" type="submit">
                            <i class="fa fa-plus mr10"></i>Add New
                        </button>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 pl0 ml0 pr0 mr0 mb15 search-container">
                @if (Auth::user()->isAllowTo('search-credential'))
                    {!! Form::open(['route' => 'credential_search_path', 'id' => 'searchForm']) !!}
                    <span class="field search-input-container">
                            {!! Form::text('needle', $needle, ['class' => 'gui-input search-input', 'id' => 'needle']) !!}
                        </span>
                    <button id="button-search" class="btn btn-info search-button">
                        <i class="fa fa-search mr10"></i>Search
                    </button>
                    @if (!empty($needle))
                        <button class="btn btn-default reset-button equis" type="button" data-location="credentials">x</button>
                    @endif
                    {!! Form::close() !!}
                @endif
            </div>
        </div>

        <div class="panel" id="spy7">
            <div class="panel-credential pn">
                <table class="table table-bordered list-table">
                    <thead>
                    <tr>
                        <th class="td-sortable xs-hidden">{!! SortableTrait::link('customers.name|credentials.customer_id', 'Customer') !!}</th>
                        <th class="td-sortable">{!! SortableTrait::link('professionals.first_name|credentials.professional_id', 'Provider') !!}</th>
                        <th class="td-sortable">{!! SortableTrait::link('credential_status.name|credentials.status_id', 'Status') !!}</th>
                        <th class="td-sortable xs-hidden">{!! SortableTrait::link('users.first_name|credentials.assigned_to_id', 'Assigned To') !!}</th>
                        <th class="td-sortable xs-hidden text-center">{!! SortableTrait::link('opened_at', 'Opened At') !!}</th>
                        <th class="td-sortable text-center">{!! SortableTrait::link('completed_at', 'Completed At') !!}</th>
                        <th class="td-sortable text-center">{!! SortableTrait::link('expired_at', 'Expired At') !!}</th>
                        <th class="actions">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($credentials as $credential)
                            <tr data-id="{{ $credential->id }}" class="{{ !empty($credential->disabled) ? 'disabled' : '' }}">
                                <td class="xs-hidden">{{ $credential->customer->name }}</td>
                                <td>{{ $credential->professional->fullName }}</td>
                                <td>{{ $credential->status->name }}</td>
                                <td class="xs-hidden">{{ $credential->assignedTo->fullName }}</td>
                                <td class="td-sortable text-center xs-hidden">{!! $credential->htmlOpenedAt !!}</td>
                                <td class="td-sortable text-center">{!! $credential->htmlCompletedAt !!}</td>
                                <td class="td-sortable text-center">{!! $credential->htmlExpiredAt !!}</td>
                                <td class="centered actions">
                                    <ul class="nav navbar-nav">
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i></a>
                                            <ul class="dropdown-menu animated animated-short flipInX" role="menu">
                                                @if (Auth::user()->isAllowTo('update-credential-document'))
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="credentialdocuments" data-id="{{ $credential->id }}">
                                                            <span class="fa fa-file-text-o mr15"></span>View Documents
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (Auth::user()->isAllowTo('update-credential'))
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="edit" data-id="{{ $credential->id }}">
                                                            <span class="glyphicons glyphicons-edit"></span>Edit</a>
                                                    </li>
                                                @endif
                                                @if (Auth::user()->isAllowTo('update-credential') && !$credential->isCompleted())
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="complete" data-id="{{ $credential->id }}">
                                                            <span class="fa fa-check-circle mr15"></span>Set as Complete</a>
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
                    @if (!$credentials->total())
                        <span>There is no item to show.</span>
                    @else
                        @if ($credentials->perPage() > $credentials->total())
                            <span>Showing {!! $credentials->total() !!} {{ $credentials->total() == 1 ? 'item' : 'items' }}</span>
                        @else
                            <span>Showing {{ $credentials->perPage() }} of {!! $credentials->total() !!} {{ $credentials->total() == 1 ? 'item': 'items' }}</span>
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 pagination-pages">
                Items per page:
                <select id="pageItems" class="form-control">
                    <option value="{{ route('credential_list_path', array_merge(Request::query(), ['page' => 0, 'perPage' => 10])) }}"{{ Request::input('perPage') == 10 ? ' selected' : '' }}>10</option>
                    <option value="{{ route('credential_list_path', array_merge(Request::query(), ['page' => 0, 'perPage' => 20])) }}"{{ Request::input('perPage') == 20 ? ' selected' : '' }}>20</option>
                    <option value="{{ route('credential_list_path', array_merge(Request::query(), ['page' => 0, 'perPage' => $credentials->total()])) }}"{{ Request::input('perPage') == $credentials->total() ? ' selected' : '' }}>All</option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-4 pull-right pagination-handlers text-right">
                @include('components.pagination.custom', ['paginator' => $credentials, 'route' => 'credential_list_path', 'query' => http_build_query(Input::except(['page', '_token']))])
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

            $('#button-create').click(function(){
                window.location = "{{ route('credential_create_path') }}";
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

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="credentialdocuments"]', function(){
                window.location = "{{ asset('credentialdocuments') }}/" + $(this).attr('data-id');
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="complete"]', function(){
                window.location = "{{ asset('credentials/setascomplete') }}/" + $(this).attr('data-id');
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="edit"]', function(){
                window.location = "{{ asset('credentials') }}/" + $(this).attr('data-id') + '/edit';
            });
        });
    </script>
@stop