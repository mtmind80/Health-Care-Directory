@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Users &amp; Access</a>
                </li>
                <li class="crumb-trail">Users</li>
            </ol>
        </div>
        <div class="topbar-right">
        </div>
    </header>
@stop

@section('content')
    <!-- Image popup -->
    <div id="userAvatar" class="popup-basic popup-lg mfp-with-anim mfp-hide">
        <img class="img-responsive" src="none" alt="none">
    </div>

    <div id="content" class="animated fadeIn list-items admin-form">
        @include('errors._list')
        <div class="clearfix">
            <div class="col-xs-12 col-sm-6 pl0 ml0 pr0 mr0 mb15">
                <div class="btn-group">
                    @if (Auth::user()->isAllowTo('create-user'))
                        <button id="button-create" class="btn btn-success mr10" type="submit">
                            <i class="fa fa-plus mr10"></i>Add New
                        </button>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 pl0 ml0 pr0 mr0 mb15 search-container">
                @if (Auth::user()->isAllowTo('search-user'))
                    {!! Form::open(['route' => 'user_search_path', 'id' => 'searchForm']) !!}
                    <span class="field search-input-container">
                        {!! Form::text('needle', $needle, ['class' => 'gui-input search-input', 'id' => 'needle']) !!}
                    </span>
                    <button id="button-search" class="btn btn-info search-button">
                        <i class="fa fa-search mr10"></i>Search
                    </button>
                    @if (!empty($needle))
                        <button class="btn btn-default reset-button equis" type="button" data-location="users">x</button>
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
                        <th class="td-user-avatar xs-hidden">Foto</th>
                        <th class="td-sortable">{!! SortableTrait::link('first_name', 'First Name') !!}</th>
                        <th class="td-sortable">{!! SortableTrait::link('last_name', 'Last Name') !!}</th>
                        <th class="td-sortable xs-hidden">{!! SortableTrait::link('email') !!}</th>
                        <th class="xs-hidden">Roles</th>
                        <th class="actions">Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $user)
                            <tr data-id="{{ $user->id }}" class="not-tag {{ !empty($user->disabled) ? 'disabled' : '' }}">
                                <td class="xs-hidden td-user-avatar posrel">
                                    <a class="show-image" href="javascript:void(0)" data-toggle="tooltip" title="aumentar">
                                        {!! !empty($user->disabled) ?  '<div class="ribbon disabled"></div>' : '' !!}
                                        @if (!empty($user->avatar))
                                            <img src="{{ $siteUrl }}/images/avatars/{{  $user->avatar }}" alt="{{ $user->avatar }}" height="40"/>
                                        @else
                                            <img src="{{ $siteUrl }}/images/avatars/{{ $config['defaultAvatar'] }}" alt="default avatar" height="40"/>
                                        @endif
                                    </a>
                                </td>
                                @if (Auth::user()->isAllowTo('update-user'))
                                    <td>
                                        <span data-toggle="tooltip" title="Click to edit">
                                            <a class="x-editable" href="#"
                                               data-pk="{{ $user->id }}"
                                               data-name="first_name"
                                               data-value="{{ $user->first_name }}"
                                               data-js-validation-function="isPersonName"
                                               data-js-validation-error-message="Invalid entry."
                                               data-php-validation-rule="required|personName"
                                               data-type="text"
                                               data-title="First Name:"
                                               data-url="{{ route('user_inline_update_path') }}">
                                                {{ $user->first_name }}
                                            </a>
                                        </span>
                                    </td>
                                    <td>
                                        <span data-toggle="tooltip" title="Click to edit">
                                            <a class="x-editable" href="#"
                                               data-pk="{{ $user->id }}"
                                               data-name="last_name"
                                               data-value="{{ $user->last_name }}"
                                               data-js-validation-function="isPersonName"
                                               data-js-validation-error-message="Invalid entry."
                                               data-php-validation-rule="required|personName"
                                               data-type="text"
                                               data-title="Last Name:"
                                               data-url="{{ route('user_inline_update_path') }}">
                                                {{ $user->last_name }}
                                            </a>
                                        </span>
                                    </td>
                                    <td class="xs-hidden">
                                        <span data-toggle="tooltip" title="Click to edit">
                                            <a class="x-editable" href="#"
                                               data-pk="{{ $user->id }}"
                                               data-name="email"
                                               data-value="{{ $user->email }}"
                                               data-js-validation-function="isEmail"
                                               data-js-validation-error-message="Invalid email."
                                               data-php-validation-rule="required|email"
                                               data-type="text"
                                               data-title="Email:"
                                               data-url="{{ route('user_inline_update_path') }}">
                                                {{ $user->email }}
                                            </a>
                                        </span>
                                    </td>
                                @else
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->last_name }}</td>
                                    <td class="xs-hidden">{{ $user->email }}</td>
                                @endif
                                <td class="role-name xs-hidden">{!! implode('<br>', $user->roleNames) !!}</td>
                                <td class="centered actions">
                                    <ul class="nav navbar-nav">
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i></a>
                                            <ul class="dropdown-menu animated animated-short flipInX" role="menu">
                                                @if (Auth::user()->isAllowTo('update-user'))
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="edit" data-id="{{ $user->id }}">
                                                            <span class="glyphicons glyphicons-edit"></span>Edit
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (Auth::user()->id != $user->id)
                                                    @if (Auth::user()->isAllowTo('update-user'))
                                                        <li>
                                                            <a href="javascript:void(0);" class="action" data-action="status" data-id="{{ $user->id }}">
                                                                @if (empty($user->disabled))
                                                                    <span class="glyphicons glyphicons-ban"></span>Disable
                                                                @else
                                                                    <span class="glyphicons glyphicons-ok"></span>Enable
                                                                @endif
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if (Auth::user()->isAllowTo('delete-user'))
                                                        <li class="menu-separator"></li>
                                                        <li>
                                                            <a href="javascript:void(0);" class="action" data-action="delete" data-id="{{ $user->id }}">
                                                                <span class="glyphicons glyphicons-circle_remove"></span>Delete
                                                            </a>
                                                        </li>
                                                    @endif
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
                    @if (!$users->total())
                        <span>There is no item to show.</span>
                    @else
                        @if ($users->perPage() > $users->total())
                            <span>Showing {!! $users->total() !!} {{ $users->total() == 1 ? 'item' : 'items' }}</span>
                        @else
                            <span>Showing {{ $users->perPage() }} of {!! $users->total() !!} {{ $users->total() == 1 ? 'item': 'items' }}</span>
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 pagination-pages">
                Items per page:
                <select id="pageItems" class="form-control">
                    <option value="{{ route('user_list_path', array_merge(Request::query(), ['page' => 0, 'perPage' => 10])) }}"{{ Request::input('perPage') == 10 ? ' selected' : '' }}>10</option>
                    <option value="{{ route('user_list_path', array_merge(Request::query(), ['page' => 0, 'perPage' => 20])) }}"{{ Request::input('perPage') == 20 ? ' selected' : '' }}>20</option>
                    <option value="{{ route('user_list_path', array_merge(Request::query(), ['page' => 0, 'perPage' => $users->total()])) }}"{{ Request::input('perPage') == $users->total() ? ' selected' : '' }}>All</option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-4 pull-right pagination-handlers text-right">
                @include('components.pagination.custom', ['paginator' => $users, 'route' => 'user_list_path', 'query' => http_build_query(Input::except(['page', '_token']))])
            </div>
        </div>

        {!! Form::open(['method'=>'DELETE', 'url' => 'users', 'id' => 'deleteForm']) !!}
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
                window.location = "{{ route('user_create_path') }}";
            });

            $('.show-image').click(function(){
                var src = $(this).find('img').attr('src');
                $('#userAvatar').find('img').attr('src', src).attr('alt', 'img');

                $(this).parents('tbody').find('.show-image').removeClass('active-animation');
                $(this).addClass('active-animation item-checked');

                $.magnificPopup.open({
                    removalDelay: 500, //delay removal by X to allow out-animation,
                    items: {
                        src: '#userAvatar'
                    },
                    callbacks: {
                        beforeOpen: function(e) {
                            this.st.mainClass = 'mfp-slideDown';
                        }
                    },
                    midClick: true
                });
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
                window.location = "{{ asset('users') }}/" + $(this).attr('data-id') + '/togglestatus';
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="edit"]', function(){
                window.location = "{{ asset('users') }}/" + $(this).attr('data-id') + '/edit';
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