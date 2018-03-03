@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="{{ route('provider_list_path') }}">Providers</a>
                </li>
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Provider: "{{ $providerName }}"</a>
                </li>
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Malpractices</a>
                </li>
                <li class="crumb-trail">List</li>
            </ol>
        </div>
        <div class="topbar-right">
            @include('provider._actionmenu', ['professional_id' => $professional_id])
        </div>
    </header>
@stop

@section('content')
    <div id="content" class="animated fadeIn list-items admin-form">
        @include('errors._list')
        <div class="clearfix">
            <div class="col-xs-12 col-sm-6 pl0 ml0 pr0 mr0 mb15">
                <div class="btn-group">
                    @if (Auth::user()->isAllowTo('create-provider-malpractice'))
                        <button id="button-create" class="btn btn-success mr10" type="submit">
                            <i class="fa fa-plus mr10"></i>Add New
                        </button>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 pl0 ml0 pr0 mr0 mb15 search-container">
                @if (Auth::user()->isAllowTo('search-provider-malpractice'))
                    {!! Form::open(['url' => route('provider_malpractice_search_path', ['provider_id' => $provider_id]), 'id' => 'searchForm']) !!}
                    <span class="field search-input-container">
                            {!! Form::text('needle', $needle, ['class' => 'gui-input search-input', 'id' => 'needle']) !!}
                        </span>
                    <button id="button-search" class="btn btn-info search-button">
                        <i class="fa fa-search mr10"></i>Search
                    </button>
                    @if (!empty($needle))
                        <button class="btn btn-default reset-button equis" type="button" data-location="providermalpractices/{{ $provider_id }}">x</button>
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
                        <th class="td-sortable">{!! SortableTrait::link('insurers.name|provider_malpractices.insurer_id', 'Insurer', ['provider_id' => $provider_id]) !!}</th>
                        <th class="td-sortable">{!! SortableTrait::link('policy_types.name|provider_malpractices.policy_type_id', 'Policy Type', ['provider_id' => $provider_id]) !!}</th>
                        <th class="td-sortable xs-hidden">{!! SortableTrait::link('policy_number', 'Policy Number', ['provider_id' => $provider_id]) !!}</th>
                        <th class="td-sortable xs-hidden">{!! SortableTrait::link('started_at', 'Policy Date', ['provider_id' => $provider_id]) !!}</th>
                        <th class="td-sortable xs-hidden">{!! SortableTrait::link('expired_at', 'Expired At', ['provider_id' => $provider_id]) !!}</th>
                        <th class="actions">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($providerMalpractices as $providerMalpractice)
                            <tr data-id="{{ $providerMalpractice->id }}" class="{{ !empty($providerMalpractice->disabled) ? 'disabled' : '' }}">
                                <td>{{ $providerMalpractice->insurer->name }}</td>
                                <td>{{ $providerMalpractice->policyType->name }}</td>
                                <td class="xs-hidden">{{ $providerMalpractice->policy_number }}</td>
                                <td class="xs-hidden">{!! $providerMalpractice->htmlStartedAt !!}</td>
                                <td class="xs-hidden">{!! $providerMalpractice->htmlExpiredAt !!}</td>
                                <td class="centered actions">
                                    <ul class="nav navbar-nav">
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i></a>
                                            <ul class="dropdown-menu animated animated-short flipInX" role="menu">
                                                @if (Auth::user()->isAllowTo('update-provider-malpractice-judgement'))
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="judgements" data-id="{{ $providerMalpractice->id }}">
                                                            <span class="fa fa-gears mr11"></span>View Judgements
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (Auth::user()->isAllowTo('update-provider-malpractice'))
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="edit" data-id="{{ $providerMalpractice->id }}">
                                                            <span class="glyphicons glyphicons-edit"></span>Edit
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (Auth::user()->isAllowTo('delete-provider-malpractice'))
                                                    <li class="menu-separator"></li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="delete" data-id="{{ $providerMalpractice->id }}">
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
                    @if (!$providerMalpractices->total())
                        <span>There is no item to show.</span>
                    @else
                        @if ($providerMalpractices->perPage() > $providerMalpractices->total())
                            <span>Showing {!! $providerMalpractices->total() !!} {{ $providerMalpractices->total() == 1 ? 'item' : 'items' }}</span>
                        @else
                            <span>Showing {{ $providerMalpractices->perPage() }} of {!! $providerMalpractices->total() !!} {{ $providerMalpractices->total() == 1 ? 'item': 'items' }}</span>
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 pagination-pages">
                Items per page:
                <select id="pageItems" class="form-control">
                    <option value="{{ route('provider_malpractice_list_path', array_merge(Request::query(), ['provider_id' => $provider_id, 'page' => 0, 'perPage' => 10])) }}"{{ Request::input('perPage') == 10 ? ' selected' : '' }}>10</option>
                    <option value="{{ route('provider_malpractice_list_path', array_merge(Request::query(), ['provider_id' => $provider_id, 'page' => 0, 'perPage' => 20])) }}"{{ Request::input('perPage') == 20 ? ' selected' : '' }}>20</option>
                    <option value="{{ route('provider_malpractice_list_path', array_merge(Request::query(), ['provider_id' => $provider_id, 'page' => 0, 'perPage' => $providerMalpractices->total()])) }}"{{ Request::input('perPage') == $providerMalpractices->total() ? ' selected' : '' }}>All</option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-4 pull-right pagination-handlers text-right">
                @include('components.pagination.custom', ['paginator' => $providerMalpractices, 'route' => 'provider_malpractice_list_path', 'query' => http_build_query(Input::except(['page', '_token']))])
            </div>
        </div>

        {!! Form::open(['method'=>'DELETE', 'route' => 'provider_malpractice_delete_path', 'id' => 'deleteForm']) !!}
            {!! Form::hidden('provider_id', $provider_id) !!}
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
                window.location = "{{ route('provider_malpractice_create_path', ['provider_id' => $provider_id]) }}";
            });

            $('#needle').blur(function(){
                $(this).parents('label').removeClass('state-error').next('em').remove();
            });

            $( "#searchForm" ).validate({
                rules: {
                    needle: {
                        minlength: 2,
                        text     : true
                    }
                }
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="judgements"]', function(){
                window.location = "{{ asset('providermalpracticejudgements') }}/" + $(this).attr('data-id');
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="edit"]', function(){
                window.location = "{{ asset('providermalpractices') }}/" + $(this).attr('data-id') + '/edit';
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