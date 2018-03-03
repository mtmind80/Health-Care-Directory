@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="{{ route('provider_list_path') }}">Providers</a>
                </li>
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Name: "{{ $providerName }}"</a>
                </li>
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">References</a>
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
                    @if (Auth::user()->isAllowTo('create-provider-reference'))
                        <button id="button-create" class="btn btn-success mr10" type="submit">
                            <i class="fa fa-plus mr10"></i>Add New
                        </button>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 pl0 ml0 pr0 mr0 mb15 search-container">
                @if (Auth::user()->isAllowTo('search-provider-reference'))
                    {!! Form::open(['url' => route('provider_reference_search_path', ['provider_id' => $provider_id]), 'id' => 'searchForm']) !!}
                    <span class="field search-input-container">
                            {!! Form::text('needle', $needle, ['class' => 'gui-input search-input', 'id' => 'needle']) !!}
                        </span>
                    <button id="button-search" class="btn btn-info search-button">
                        <i class="fa fa-search mr10"></i>Search
                    </button>
                    @if (!empty($needle))
                        <button class="btn btn-default reset-button equis" type="button" data-location="providerreferences/{{ $provider_id }}">x</button>
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
                        <th class="td-sortable ">{!! SortableTrait::link('name', 'Name', ['provider_id' => $provider_id]) !!}</th>
                        <th class="td-sortable xs-hidden">{!! SortableTrait::link('title', 'Title', ['provider_id' => $provider_id]) !!}</th>
                        <th class="xs-hidden">Address</th>
                        <th class="td-sortable ">{!! SortableTrait::link('email', 'Email', ['provider_id' => $provider_id]) !!}</th>
                        <th class="td-sortable ">{!! SortableTrait::link('phone', 'Phone', ['provider_id' => $provider_id]) !!}</th>
                        <th class="actions">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($references as $reference)
                            <tr data-id="{{ $reference->id }}" class="{{ !empty($reference->disabled) ? 'disabled' : '' }}">
                                <td class="">
                                    <span data-toggle="tooltip" title="Click to edit">
                                        <a class="x-editable" href="#"
                                           data-pk="{{ $reference->id }}"
                                           data-name="name"
                                           data-value="{{ $reference->name }}"
                                           data-js-validation-function="isPersonName"
                                           data-js-validation-error-message="Invalid name."
                                           data-php-validation-rule="required|personName"
                                           data-type="text"
                                           data-title="Name:"
                                           data-url="{{ route('provider_reference_inline_update_path') }}">
                                            {{ $reference->name }}
                                        </a>
                                    </span>
                                </td>
                                <td class="xs-hidden">
                                        <span data-toggle="tooltip" title="Click to edit">
                                            <a class="x-editable" href="#"
                                               data-pk="{{ $reference->id }}"
                                               data-name="title"
                                               data-value="{{ $reference->title }}"
                                               data-js-validation-function="isPlainText"
                                               data-js-validation-error-message="Invalid title."
                                               data-php-validation-rule="required|plainText"
                                               data-type="text"
                                               data-title="Title:"
                                               data-url="{{ route('provider_reference_inline_update_path') }}">
                                                {{ $reference->title }}
                                            </a>
                                        </span>
                                </td>
                                <td class="">{!! $reference->location !!}</td>
                                <td class="">
                                    <span data-toggle="tooltip" title="Click to edit">
                                        <a class="x-editable" href="#"
                                           data-pk="{{ $reference->id }}"
                                           data-name="email"
                                           data-value="{{ $reference->email }}"
                                           data-js-validation-function="isEmail"
                                           data-js-validation-error-message="Invalid email."
                                           data-php-validation-rule="required|email"
                                           data-type="text"
                                           data-title="Email:"
                                           data-url="{{ route('provider_reference_inline_update_path') }}">
                                            {{ $reference->email }}
                                        </a>
                                    </span>
                                </td>
                                <td class="">
                                    <span data-toggle="tooltip" title="Click to edit">
                                        <a class="x-editable" href="#"
                                           data-pk="{{ $reference->id }}"
                                           data-name="phone"
                                           data-value="{{ $reference->phone }}"
                                           data-js-validation-function="isPhone"
                                           data-js-validation-error-message="Invalid phone."
                                           data-php-validation-rule="required|phone"
                                           data-type="text"
                                           data-title="Phone:"
                                           data-url="{{ route('provider_reference_inline_update_path') }}">
                                            {{ $reference->phone }}
                                        </a>
                                    </span>
                                </td>
                                <td class="centered actions">
                                    <ul class="nav navbar-nav">
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i></a>
                                            <ul class="dropdown-menu animated animated-short flipInX" role="menu">
                                                @if (Auth::user()->isAllowTo('update--provider-reference'))
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="edit" data-id="{{ $reference->id }}">
                                                            <span class="glyphicons glyphicons-edit"></span>Edit
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (Auth::user()->isAllowTo('delete-provider-reference'))
                                                    <li class="menu-separator"></li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="delete" data-id="{{ $reference->id }}">
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
                    @if (!$references->total())
                        <span>There is no item to show.</span>
                    @else
                        @if ($references->perPage() > $references->total())
                            <span>Showing {!! $references->total() !!} {{ $references->total() == 1 ? 'item' : 'items' }}</span>
                        @else
                            <span>Showing {{ $references->perPage() }} of {!! $references->total() !!} {{ $references->total() == 1 ? 'item': 'items' }}</span>
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 pagination-pages">
                Items per page:
                <select id="pageItems" class="form-control">
                    <option value="{{ route('provider_reference_list_path', array_merge(Request::query(), ['provider_id' => $provider_id, 'page' => 0, 'perPage' => 10])) }}"{{ Request::input('perPage') == 10 ? ' selected' : '' }}>10</option>
                    <option value="{{ route('provider_reference_list_path', array_merge(Request::query(), ['provider_id' => $provider_id, 'page' => 0, 'perPage' => 20])) }}"{{ Request::input('perPage') == 20 ? ' selected' : '' }}>20</option>
                    <option value="{{ route('provider_reference_list_path', array_merge(Request::query(), ['provider_id' => $provider_id, 'page' => 0, 'perPage' => $references->total()])) }}"{{ Request::input('perPage') == $references->total() ? ' selected' : '' }}>All</option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-4 pull-right pagination-handlers text-right">
                @include('components.pagination.custom', ['paginator' => $references, 'route' => 'provider_reference_list_path', 'query' => http_build_query(Input::except(['page', '_token']))])
            </div>
        </div>

        {!! Form::open(['method'=>'DELETE', 'route' => 'provider_reference_delete_path', 'id' => 'deleteForm']) !!}
            {!! Form::hidden('provider_id', $provider_id) !!}
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
    <script>
        $(function(){
            $('#pageItems').change(function(){
                window.location.href = $(this).val();
            });

            $('#button-create').click(function(){
                window.location = "{{ route('provider_reference_create_path', ['provider_id' => $provider_id]) }}";
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
                window.location = "{{ asset('providerreferences') }}/" + $(this).attr('data-id') + '/edit';
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
                        return (jsValidationErrorMessage) ? jsValidationErrorMessage : 'Invalid entry';
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