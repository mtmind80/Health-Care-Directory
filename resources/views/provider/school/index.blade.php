@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="{{ route('provider_list_path') }}">Providers</a>
                </li>
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Name: "{{ $professionalName }}"</a>
                </li>
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Schools</a>
                </li>
                <li class="crumb-trail">List</li>
            </ol>
        </div>
        <div class="topbar-right">
            @include('provider._actionmenu')
        </div>
    </header>
@stop

@section('content')
    <div id="content" class="animated fadeIn list-items admin-form">
        @include('errors._list')
        <div class="clearfix">
            <div class="col-xs-12 col-sm-6 pl0 ml0 pr0 mr0 mb15">
                <div class="btn-group">
                    @if (Auth::user()->isAllowTo('create-professional-school'))
                        <button id="button-create" class="btn btn-success mr10" type="submit">
                            <i class="fa fa-plus mr10"></i>Add New
                        </button>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 pl0 ml0 pr0 mr0 mb15 search-container">
                @if (Auth::user()->isAllowTo('search-professional-school'))
                    {!! Form::open(['url' => route('professional_school_search_path', ['professional_id' => $professional_id]), 'id' => 'searchForm']) !!}
                    <span class="field search-input-container">
                            {!! Form::text('needle', $needle, ['class' => 'gui-input search-input', 'id' => 'needle']) !!}
                        </span>
                    <button id="button-search" class="btn btn-info search-button">
                        <i class="fa fa-search mr10"></i>Search
                    </button>
                    @if (!empty($needle))
                        <button class="btn btn-default reset-button equis" type="button" data-location="professionalschools/{{ $professional_id }}">x</button>
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
                        <th class="td-sortable">{!! SortableTrait::link('schools.name|professional_schools.school_id', 'School', ['professional_id' => $professional_id]) !!}</th>
                        <th class="td-sortable">{!! SortableTrait::link('degrees.name|professional_schools.degree_id', 'Degree', ['professional_id' => $professional_id]) !!}</th>
                        <th class="td-sortable">{!! SortableTrait::link('started_at', 'From', ['professional_id' => $professional_id]) !!}</th>
                        <th class="td-sortable">{!! SortableTrait::link('ended_at', 'To', ['professional_id' => $professional_id]) !!}</th>
                        <th class="actions">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($schools as $school)
                            <tr data-id="{{ $school->id }}" class="{{ !empty($school->disabled) ? 'disabled' : '' }}">
                                <td>
                                    @if (Auth::user()->isAllowTo('update-professional-school'))
                                        <span data-toggle="tooltip" title="Click to edit">
                                            <a class="x-editable" href="#"
                                               data-pk="{{ $school->id }}"
                                               data-name="school_id"
                                               data-value="{{ $school->school_id }}"
                                               data-js-validation-function="isPositive"
                                               data-js-validation-error-message="Invalid value."
                                               data-php-validation-rule="required|positive"
                                               data-type="select"
                                               data-source="{{ $jsonSchoolsCB }}"
                                               data-title="School:"
                                               data-url="{{ route('professional_school_inline_update_path') }}">
                                            </a>
                                        </span>
                                    @else
                                        {{ $school->school_id }}
                                    @endif
                                </td>
                                <td>
                                    @if (Auth::user()->isAllowTo('update-professional-school'))
                                        <span data-toggle="tooltip" title="Click to edit">
                                            <a class="x-editable" href="#"
                                               data-pk="{{ $school->id }}"
                                               data-name="degree_id"
                                               data-value="{{ $school->degree_id }}"
                                               data-js-validation-function="isPositive"
                                               data-js-validation-error-message="Invalid value."
                                               data-php-validation-rule="required|positive"
                                               data-type="select"
                                               data-source="{{ $jsonDegreesCB }}"
                                               data-title="Degree:"
                                               data-url="{{ route('professional_school_inline_update_path') }}">
                                            </a>
                                        </span>
                                    @else
                                        {{ $school->degree_id }}
                                    @endif
                                </td>
                                <td>
                                    @if (Auth::user()->isAllowTo('update-professional-school'))
                                        <span data-toggle="tooltip" title="Click to edit">
                                            <a class="x-editable x-date" href="#"
                                               data-pk="{{ $school->id }}"
                                               data-name="started_at"
                                               data-value="{{ $school->started_at->format('m/d/Y') }}"
                                               data-format="MM/DD/YYYY"
                                               data-template="M / D / YYYY"
                                               data-js-validation-function="isUSDate"
                                               data-js-validation-error-message="Invalid value."
                                               data-php-validation-rule="usDate"
                                               data-type="combodate"
                                               data-title="From:"
                                               data-url="{{ route('professional_school_inline_update_path') }}">
                                                {{ $school->started_at->format('m/d/Y') }}
                                            </a>
                                        </span>
                                    @else
                                        {{ $school->started_at->format('m/d/Y') }}
                                    @endif
                                </td>
                                <td>
                                    @if (Auth::user()->isAllowTo('update-professional-school'))
                                        <span data-toggle="tooltip" title="Click to edit">
                                            <a class="x-editable x-date" href="#"
                                               data-pk="{{ $school->id }}"
                                               data-name="ended_at"
                                               data-value="{{ $school->ended_at->format('m/d/Y') }}"
                                               data-format="MM/DD/YYYY"
                                               data-template="M / D / YYYY"
                                               data-js-validation-function="isUSDate"
                                               data-js-validation-error-message="Invalid value."
                                               data-php-validation-rule="usDate"
                                               data-type="combodate"
                                               data-title="To:"
                                               data-url="{{ route('professional_school_inline_update_path') }}">
                                                {{ $school->ended_at->format('m/d/Y') }}
                                            </a>
                                        </span>
                                    @else
                                        {{ $school->ended_at->format('m/d/Y') }}
                                    @endif
                                </td>
                                <td class="centered actions">
                                    <ul class="nav navbar-nav">
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i></a>
                                            <ul class="dropdown-menu animated animated-short flipInX" role="menu">
                                                @if (Auth::user()->isAllowTo('update-professional-school'))
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="edit" data-id="{{ $school->id }}">
                                                            <span class="glyphicons glyphicons-edit"></span>Edit
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (Auth::user()->isAllowTo('delete-professional-school'))
                                                    <li class="menu-separator"></li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="delete" data-id="{{ $school->id }}">
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
                    @if (!$schools->total())
                        <span>There is no item to show.</span>
                    @else
                        @if ($schools->perPage() > $schools->total())
                            <span>Showing {!! $schools->total() !!} {{ $schools->total() == 1 ? 'item' : 'items' }}</span>
                        @else
                            <span>Showing {{ $schools->perPage() }} of {!! $schools->total() !!} {{ $schools->total() == 1 ? 'item': 'items' }}</span>
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 pagination-pages">
                Items per page:
                <select id="pageItems" class="form-control">
                    <option value="{{ route('professional_school_list_path', array_merge(Request::query(), ['professional_id' => $professional_id, 'page' => 0, 'perPage' => 10])) }}"{{ Request::input('perPage') == 10 ? ' selected' : '' }}>10</option>
                    <option value="{{ route('professional_school_list_path', array_merge(Request::query(), ['professional_id' => $professional_id, 'page' => 0, 'perPage' => 20])) }}"{{ Request::input('perPage') == 20 ? ' selected' : '' }}>20</option>
                    <option value="{{ route('professional_school_list_path', array_merge(Request::query(), ['professional_id' => $professional_id, 'page' => 0, 'perPage' => $schools->total()])) }}"{{ Request::input('perPage') == $schools->total() ? ' selected' : '' }}>All</option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-4 pull-right pagination-handlers text-right">
                @include('components.pagination.custom', ['paginator' => $schools, 'route' => 'professional_school_list_path', 'query' => http_build_query(Input::except(['page', '_token']))])
            </div>
        </div>

        {!! Form::open(['method'=>'DELETE', 'route' => 'professional_school_delete_path', 'id' => 'deleteForm']) !!}
            {!! Form::hidden('professional_id', $professional_id) !!}
            <input type="hidden" id="strCid" name="strCid" value="">
        {!! Form::close() !!}
    </div>
@endsection

@section('css-files')
    <!-- X-editable CSS -->
    <link rel="stylesheet" type="text/css" href="{{ $siteUrl }}/vendor/vendor/editors/xeditable/css/bootstrap-editable.css">
    <link rel="stylesheet" type="text/css" href="{{ $siteUrl }}/vendor/vendor/editors/xeditable/inputs/typeaheadjs/lib/typeahead.js-bootstrap.css">
@stop

@section('js-files')
    <!-- Xedit JS -->
    <script src="{{ $siteUrl }}/vendor/vendor/editors/xeditable/js/bootstrap-editable.min.js"></script>
    <script src="{{ $siteUrl }}/vendor/vendor/editors/xeditable/inputs/typeaheadjs/lib/typeahead.js"></script>
    <script src="{{ $siteUrl }}/vendor/vendor/editors/xeditable/inputs/typeaheadjs/typeaheadjs.js"></script>
    <script src="{{ $siteUrl }}/vendor/vendor/plugins/daterange/moment.min.js"></script>
    <script>
        $(function(){
            $('#pageItems').change(function(){
                window.location.href = $(this).val();
            });

            $('#button-create').click(function(){
                window.location = "{{ route('professional_school_create_path', ['professional_id' => $professional_id]) }}";
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

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="edit"]', function(){
                window.location = "{{ asset('professionalschools') }}/" + $(this).attr('data-id') + '/edit';
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
                        phpValidationRule = $(this).data('php-validation-rule'),
                        isRequired = phpValidationRule.indexOf('required') >= 0;

                    if ($(this).hasClass('x-date')) {
                        if (typeof value._d != 'undefined') {
                            var d = value._d.toISOString().slice(0, 10).split('-');
                            value = d[1]+'/'+d[2]+'/'+d[0];
                        } else {
                            value = '';
                        }
                    }
                    if (isRequired && $.trim(value) == '') {
                        return 'This field is required';
                    }
                    if (isRequired && ! eval(jsValidationFunction + '("' + value + '")')) {
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