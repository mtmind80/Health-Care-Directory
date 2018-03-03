@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">System Data</a>
                </li>
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Certifying Boards</a>
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
                    @if (Auth::user()->isAllowTo('create-body'))
                        <button id="button-create" class="btn btn-success mr10" type="submit">
                            <i class="fa fa-plus mr10"></i>Add New
                        </button>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 pl0 ml0 pr0 mr0 mb15 search-container">
                @if (Auth::user()->isAllowTo('search-body'))
                    {!! Form::open(['route' => 'body_search_path', 'id' => 'searchForm']) !!}
                    <span class="field search-input-container">
                            {!! Form::text('needle', $needle, ['class' => 'gui-input search-input', 'id' => 'needle']) !!}
                        </span>
                    <button id="button-search" class="btn btn-info search-button">
                        <i class="fa fa-search mr10"></i>Search
                    </button>
                    @if (!empty($needle))
                        <button class="btn btn-default reset-button equis" type="button" data-location="bodies">x</button>
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
                        <th class="td-sortable">{!! SortableTrait::link('name') !!}</th>
                        <th class="actions">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($bodies as $body)
                            <tr data-id="{{ $body->id }}" class="{{ !empty($body->disabled) ? 'disabled' : '' }}">
                                <td>
                                    @if (Auth::user()->isAllowTo('update-body'))
                                        <span data-toggle="tooltip" title="Click to edit">
                                            <a class="x-editable" href="#"
                                               data-pk="{{ $body->id }}"
                                               data-name="name"
                                               data-value="{{ $body->name }}"
                                               data-js-validation-function="isPlainText"
                                               data-js-validation-error-message="Invalid name."
                                               data-php-validation-rule="required|plainText"
                                               data-type="text"
                                               data-title="Body:"
                                               data-url="{{ route('body_inline_update_path') }}">
                                                {{ $body->name }}
                                            </a>
                                        </span>
                                    @else
                                        {{ $body->name }}
                                    @endif
                                </td>
                                <td class="centered actions">
                                    <ul class="nav navbar-nav">
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i></a>
                                            <ul class="dropdown-menu animated animated-short flipInX" role="menu">
                                                @if (Auth::user()->isAllowTo('update-body'))
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="status" data-id="{{ $body->id }}">
                                                            @if (empty($body->disabled))
                                                                <span class="glyphicons glyphicons-ban"></span>Disable
                                                            @else
                                                                <span class="glyphicons glyphicons-ok"></span>Enable
                                                            @endif
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (Auth::user()->isAllowTo('delete-body'))
                                                    <li class="menu-separator"></li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="delete" data-id="{{ $body->id }}">
                                                            <span class="glyphicons glyphicons-circle_remove"></span>Delete
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
                    @if (!$bodies->total())
                        <span>There is no item to show.</span>
                    @else
                        @if ($bodies->perPage() > $bodies->total())
                            <span>Showing {!! $bodies->total() !!} {{ $bodies->total() == 1 ? 'item' : 'items' }}</span>
                        @else
                            <span>Showing {{ $bodies->perPage() }} of {!! $bodies->total() !!} {{ $bodies->total() == 1 ? 'item': 'items' }}</span>
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 pagination-pages">
                Items per page:
                <select id="pageItems" class="form-control">
                    <option value="{{ route('body_list_path', array_merge(Request::query(), ['page' => 0, 'perPage' => 10])) }}"{{ Request::input('perPage') == 10 ? ' selected' : '' }}>10</option>
                    <option value="{{ route('body_list_path', array_merge(Request::query(), ['page' => 0, 'perPage' => 20])) }}"{{ Request::input('perPage') == 20 ? ' selected' : '' }}>20</option>
                    <option value="{{ route('body_list_path', array_merge(Request::query(), ['page' => 0, 'perPage' => $bodies->total()])) }}"{{ Request::input('perPage') == $bodies->total() ? ' selected' : '' }}>All</option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-4 pull-right pagination-handlers text-right">
                @include('components.pagination.custom', ['paginator' => $bodies, 'route' => 'body_list_path', 'query' => http_build_query(Input::except(['page', '_token']))])
            </div>
        </div>

        {!! Form::open(['method'=>'DELETE', 'route' => 'body_delete_path', 'id' => 'deleteForm']) !!}
            <input type="hidden" id="strCid" name="strCid" value="">
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

            $('#button-create').click(function(){
                window.location = "{{ route('body_create_path') }}";
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

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="status"]', function(){
                window.location = "{{ asset('bodies') }}/" + $(this).attr('data-id') + '/togglestatus';
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="delete"]', function(){
                uiConfirm({callback: 'confirmDelete', params: [$(this).attr('data-id')]});
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

        function confirmDelete(params)
        {
            $('#strCid').val(params);
            $('#deleteForm').submit();
        }
    </script>
@stop