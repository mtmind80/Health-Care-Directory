@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Tasks</a>
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
                    @if (Auth::user()->isAllowTo('create-task'))
                        <button id="button-create" class="btn btn-success mr10" type="submit">
                            <i class="fa fa-plus mr10"></i>Add New
                        </button>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 pl0 ml0 pr0 mr0 mb15 search-container">
                @if (Auth::user()->isAllowTo('search-task'))
                    {!! Form::open(['route' => 'task_search_path', 'id' => 'searchForm']) !!}
                    <span class="field search-input-container">
                            {!! Form::text('needle', $needle, ['class' => 'gui-input search-input', 'id' => 'needle']) !!}
                        </span>
                    <button id="button-search" class="btn btn-info search-button">
                        <i class="fa fa-search mr10"></i>Search
                    </button>
                    @if (!empty($needle))
                        <button class="btn btn-default reset-button equis" type="button" data-location="tasks">x</button>
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
                        <th class="td-sortable xs-hidden">{!! SortableTrait::link('users.first_name|tasks.creator_id', 'Created By') !!}</th>
                        <th class="td-sortable xs-hidden">{!! SortableTrait::link('users.first_name|tasks.assigned_to_id', 'Assigned To') !!}</th>
                        <th class="">Title</th>
                        <th class="td-sortable text-center xs-hidden">{!! SortableTrait::link('due_at', 'Due At') !!}</th>
                        <th class="td-sortable text-center">{!! SortableTrait::link('completed') !!}</th>
                        <th class="actions">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr data-id="{{ $task->id }}" class="{{ !empty($task->completed) ? 'completed' : '' }}">
                                <td class="xs-hidden">{{ $task->creator->fullName }}</td>
                                <td class="xs-hidden">{{ $task->assignedTo->fullName }}</td>
                                <td>
                                    @if (Auth::user()->isAllowTo('update-task'))
                                        <span data-toggle="tooltip" title="Click to edit">
                                            <a class="x-editable" href="#"
                                               data-pk="{{ $task->id }}"
                                               data-name="title"
                                               data-value="{{ $task->title }}"
                                               data-js-validation-function="isPlainText"
                                               data-js-validation-error-message="Invalid title."
                                               data-php-validation-rule="plainText"
                                               data-type="text"
                                               data-title="Title:"
                                               data-url="{{ route('task_inline_update_path') }}">
                                                {{ $task->title }}
                                            </a>
                                        </span>
                                    @else
                                        {{ $school->title }}
                                    @endif
                                </td>
                                <td class="td-sortable text-center xs-hidden">{!! $task->htmlDueAt !!}</td>
                                <td class="td-sortable text-center">{!! $task->htmlCompleted !!}</td>
                                <td class="centered actions">
                                    <ul class="nav navbar-nav">
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i></a>
                                            <ul class="dropdown-menu animated animated-short flipInX" role="menu">
                                                @if (Auth::user()->isAllowTo('update-task'))
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="edit" data-id="{{ $task->id }}">
                                                            <span class="glyphicons glyphicons-edit"></span>Edit</a>
                                                    </li>
                                                @endif
                                                @if (Auth::user()->canToggleTaskStatus($task))
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="status" data-id="{{ $task->id }}" data-completed="{{ $task->completed }}">
                                                            @if ($task->completed)
                                                                <span class="glyphicons glyphicons-ban"></span>Mark as Not Completed
                                                            @else
                                                                <span class="glyphicons glyphicons-ok"></span>Mark as Completed
                                                            @endif
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
                    @if (!$tasks->total())
                        <span>There is no item to show.</span>
                    @else
                        @if ($tasks->perPage() > $tasks->total())
                            <span>Showing {!! $tasks->total() !!} {{ $tasks->total() == 1 ? 'item' : 'items' }}</span>
                        @else
                            <span>Showing {{ $tasks->perPage() }} of {!! $tasks->total() !!} {{ $tasks->total() == 1 ? 'item': 'items' }}</span>
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 pagination-pages">
                Items per page:
                <select id="pageItems" class="form-control">
                    <option value="{{ route('task_list_path', array_merge(Request::query(), ['page' => 0, 'perPage' => 10])) }}"{{ Request::input('perPage') == 10 ? ' selected' : '' }}>10</option>
                    <option value="{{ route('task_list_path', array_merge(Request::query(), ['page' => 0, 'perPage' => 20])) }}"{{ Request::input('perPage') == 20 ? ' selected' : '' }}>20</option>
                    <option value="{{ route('task_list_path', array_merge(Request::query(), ['page' => 0, 'perPage' => $tasks->total()])) }}"{{ Request::input('perPage') == $tasks->total() ? ' selected' : '' }}>All</option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-4 pull-right pagination-handlers text-right">
                @include('components.pagination.custom', ['paginator' => $tasks, 'route' => 'task_list_path', 'query' => http_build_query(Input::except(['page', '_token']))])
            </div>
        </div>

        {!! Form::open(['route' => ['task_toggle_status_path', ], 'id' => 'statusForm']) !!}
            <input type="hidden" id="taskId" name="taskId" value="">
            <input type="hidden" id="response" name="response" value="">
        {!! Form::close() !!}
    </div>
@endsection

@section('css-files')
    <!-- X-editable CSS -->
    <link rel="stylesheet" type="text/css" href="{{ $siteUrl }}/vendor/vendor/editors/xeditable/css/bootstrap-editable.css">
    <link rel="stylesheet" type="text/css" href="{{ $siteUrl }}/vendor/vendor/editors/xeditable/inputs/address/address.css">
    <link rel="stylesheet" type="text/css" href="{{ $siteUrl }}/vendor/vendor/editors/xeditable/inputs/typeaheadjs/lib/typeahead.js-bootstrap.css">
@stop

@section('js-files')
    <!-- Xedit JS -->
    <script src="{{ $siteUrl }}/vendor/vendor/editors/xeditable/js/bootstrap-editable.min.js"></script>
    <script src="{{ $siteUrl }}/vendor/vendor/editors/xeditable/inputs/address/address.js"></script>
    <script src="{{ $siteUrl }}/vendor/vendor/editors/xeditable/inputs/typeaheadjs/lib/typeahead.js"></script>
    <script src="{{ $siteUrl }}/vendor/vendor/editors/xeditable/inputs/typeaheadjs/typeaheadjs.js"></script>
    <script src="{{ $siteUrl }}/vendor/vendor/plugins/daterange/moment.min.js"></script>
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

            $('#button-create').click(function(){
                window.location = "{{ route('task_create_path') }}";
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="edit"]', function(){
                window.location = "{{ asset('tasks') }}/" + $(this).attr('data-id') + '/edit';
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="status"]', function(){
                uiConfirm({
                    title: 'Change Task Status',
                    text: 'You are about to mark the task as <strong>'+($(this).data('completed') == '0' ? 'Completed' : 'No Completed')+'</strong>. Are you sure?',
                    callback: 'confirmChangeTaskStatus',
                    params: [$(this).attr('data-id')],
                    note: {
                        label: 'Enter the response:',
                        required: true
                    }
                });
            });

            $('.x-editable').editable({
                ajaxOptions: {
                    headers: {'X-XSRF-TOKEN': "{{ $encToken }}"}
                },
                validate: function(value) {
                    var jsValidationFunction = $(this).data('js-validation-function'),
                            jsValidationErrorMessage = $(this).data('js-validation-error-message'),
                            phpValidationRule = $(this).data('php-validation-rule');

                    if (phpValidationRule.indexOf('required') >= 0 && $.trim(value) == '') {
                        return 'This field is required';
                    }
                    if ( ! eval(jsValidationFunction + '("' + value + '")')) {
                        return (jsValidationErrorMessage) ? jsValidationErrorMessage : 'Only text (no html).';
                    }

                    // Additional params for submit. It is appended to original ajax data (pk, name and value).
                    $(this).editable('option', 'params', {
                        rule: phpValidationRule
                    });
                },
                success: function(response, newValue) {
                    var result = $.parseJSON(response);
                    if (result.status == 'error') {
                        return result.message;
                    }
                }
            });
        });
        function confirmChangeTaskStatus(taskId)
        {
            $('#taskId').val(taskId);
            $('#response').val($('#myModalConfirmNote').val());
            $('#statusForm').submit();
        }
    </script>
@stop