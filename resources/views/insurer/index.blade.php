@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">System Data</a>
                </li>
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Insurers</a>
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
                    @if (Auth::user()->isAllowTo('create-insurer'))
                        <button id="button-create" class="btn btn-success mr10" type="submit">
                            <i class="fa fa-plus mr10"></i>Add New
                        </button>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 pl0 ml0 pr0 mr0 mb15 search-container">
                @if (Auth::user()->isAllowTo('search-insurer'))
                    {!! Form::open(['route' => 'insurer_search_path', 'id' => 'searchForm']) !!}
                    <span class="field search-input-container">
                            {!! Form::text('needle', $needle, ['class' => 'gui-input search-input', 'id' => 'needle']) !!}
                        </span>
                    <button id="button-search" class="btn btn-info search-button">
                        <i class="fa fa-search mr10"></i>Search
                    </button>
                    @if (!empty($needle))
                        <button class="btn btn-default reset-button equis" type="button" data-location="insurers">x</button>
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
                        <th class="td-sortable">{!! SortableTrait::link('name', 'Name') !!}</th>
                        <th class="">Location</th>
                        <th class="td-sortable">{!! SortableTrait::link('phone', 'Phone') !!}</th>
                        <th class="td-sortable">{!! SortableTrait::link('fax', 'Fax') !!}</th>
                        <th class="td-sortable">{!! SortableTrait::link('email', 'Email') !!}</th>
                        <th class="td-sortable">{!! SortableTrait::link('contact_name', 'Contact Name') !!}</th>
                        <th class="actions">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($insurers as $insurer)
                            <tr data-id="{{ $insurer->id }}" class="{{ !empty($insurer->disabled) ? 'disabled' : '' }}">
                                <td>
                                    @if (Auth::user()->isAllowTo('update-insurer'))
                                        <span data-toggle="tooltip" title="Click to edit">
                                            <a class="x-editable" href="#"
                                               data-pk="{{ $insurer->id }}"
                                               data-name="name"
                                               data-value="{{ $insurer->name }}"
                                               data-js-validation-function="isPlainText"
                                               data-js-validation-error-message="Invalid name."
                                               data-php-validation-rule="required|plainText"
                                               data-type="text"
                                               data-title="Insurer:"
                                               data-url="{{ route('insurer_inline_update_path') }}">
                                                {{ $insurer->name }}
                                            </a>
                                        </span>
                                    @else
                                        {{ $insurer->name }}
                                    @endif
                                </td>
                                <td>{!! $insurer->location !!}</td>
                                <td>
                                    @if (Auth::user()->isAllowTo('update-insurer'))
                                        <span data-toggle="tooltip" title="Click to edit">
                                            <a class="x-editable" href="#"
                                               data-pk="{{ $insurer->id }}"
                                               data-name="phone"
                                               data-value="{{ $insurer->phone }}"
                                               data-js-validation-function="isPhone"
                                               data-js-validation-error-message="Invalid phone."
                                               data-php-validation-rule="phone"
                                               data-type="text"
                                               data-title="Phone:"
                                               data-url="{{ route('insurer_inline_update_path') }}">
                                                {{ $insurer->phone }}
                                            </a>
                                        </span>
                                    @else
                                        {{ $insurer->phone }}
                                    @endif
                                </td>
                                <td>
                                    @if (Auth::user()->isAllowTo('update-insurer'))
                                        <span data-toggle="tooltip" title="Click to edit">
                                            <a class="x-editable" href="#"
                                               data-pk="{{ $insurer->id }}"
                                               data-name="fax"
                                               data-value="{{ $insurer->fax }}"
                                               data-js-validation-function="isPhone"
                                               data-js-validation-error-message="Invalid fax."
                                               data-php-validation-rule="phone"
                                               data-type="text"
                                               data-title="Fax:"
                                               data-url="{{ route('insurer_inline_update_path') }}">
                                                {{ $insurer->fax }}
                                            </a>
                                        </span>
                                    @else
                                        {{ $insurer->fax }}
                                    @endif
                                </td>
                                <td>
                                    @if (Auth::user()->isAllowTo('update-insurer'))
                                        <span data-toggle="tooltip" title="Click to edit">
                                            <a class="x-editable" href="#"
                                               data-pk="{{ $insurer->id }}"
                                               data-name="email"
                                               data-value="{{ $insurer->email }}"
                                               data-js-validation-function="isEmail"
                                               data-js-validation-error-message="Invalid email."
                                               data-php-validation-rule="email"
                                               data-type="text"
                                               data-title="Email:"
                                               data-url="{{ route('insurer_inline_update_path') }}">
                                                {{ $insurer->email }}
                                            </a>
                                        </span>
                                    @else
                                        {{ $insurer->email }}
                                    @endif
                                </td>
                                <td>
                                    @if (Auth::user()->isAllowTo('update-insurer'))
                                        <span data-toggle="tooltip" title="Click to edit">
                                            <a class="x-editable" href="#"
                                               data-pk="{{ $insurer->id }}"
                                               data-name="contact_name"
                                               data-value="{{ $insurer->contact_name }}"
                                               data-js-validation-function="isPlainText"
                                               data-js-validation-error-message="Invalid contact name."
                                               data-php-validation-rule="plainText"
                                               data-type="text"
                                               data-title="Contact Name:"
                                               data-url="{{ route('insurer_inline_update_path') }}">
                                                {{ $insurer->contact_name }}
                                            </a>
                                        </span>
                                    @else
                                        {{ $insurer->contact_name }}
                                    @endif
                                </td>
                                <td class="centered actions">
                                    <ul class="nav navbar-nav">
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i></a>
                                            <ul class="dropdown-menu animated animated-short flipInX" role="menu">
                                                @if (Auth::user()->isAllowTo('update-insurer'))
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="edit" data-id="{{ $insurer->id }}">
                                                            <span class="glyphicons glyphicons-edit"></span>Edit
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (Auth::user()->isAllowTo('update-insurer'))
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="status" data-id="{{ $insurer->id }}">
                                                            @if (empty($insurer->disabled))
                                                                <span class="glyphicons glyphicons-ban"></span>Disable
                                                            @else
                                                                <span class="glyphicons glyphicons-ok"></span>Enable
                                                            @endif
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (Auth::user()->isAllowTo('delete-insurer'))
                                                    <li class="menu-separator"></li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="delete" data-id="{{ $insurer->id }}">
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
                    @if (!$insurers->total())
                        <span>There is no item to show.</span>
                    @else
                        @if ($insurers->perPage() > $insurers->total())
                            <span>Showing {!! $insurers->total() !!} {{ $insurers->total() == 1 ? 'item' : 'items' }}</span>
                        @else
                            <span>Showing {{ $insurers->perPage() }} of {!! $insurers->total() !!} {{ $insurers->total() == 1 ? 'item': 'items' }}</span>
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 pagination-pages">
                Items per page:
                <select id="pageItems" class="form-control">
                    <option value="{{ route('insurer_list_path', array_merge(Request::query(), ['page' => 0, 'perPage' => 10])) }}"{{ Request::input('perPage') == 10 ? ' selected' : '' }}>10</option>
                    <option value="{{ route('insurer_list_path', array_merge(Request::query(), ['page' => 0, 'perPage' => 20])) }}"{{ Request::input('perPage') == 20 ? ' selected' : '' }}>20</option>
                    <option value="{{ route('insurer_list_path', array_merge(Request::query(), ['page' => 0, 'perPage' => $insurers->total()])) }}"{{ Request::input('perPage') == $insurers->total() ? ' selected' : '' }}>All</option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-4 pull-right pagination-handlers text-right">
                @include('components.pagination.custom', ['paginator' => $insurers, 'route' => 'insurer_list_path', 'query' => http_build_query(Input::except(['page', '_token']))])
            </div>
        </div>

        {!! Form::open(['method'=>'DELETE', 'route' => 'insurer_delete_path', 'id' => 'deleteForm']) !!}
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
                window.location = "{{ route('insurer_create_path') }}";
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
                window.location = "{{ asset('insurers') }}/" + $(this).attr('data-id') + '/togglestatus';
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="edit"]', function(){
                window.location = "{{ asset('insurers') }}/" + $(this).attr('data-id') + '/edit';
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