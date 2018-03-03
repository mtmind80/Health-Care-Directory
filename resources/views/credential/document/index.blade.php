@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="{{ route('credential_list_path') }}">Credentials</a>
                </li>
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Provider: "{{ $credentialProfessionalName }}"</a>
                </li>
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Documents</a>
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
                    @if (Auth::user()->isAllowTo('create-credential-document'))
                        <button id="button-create" class="btn btn-success mr10" type="submit">
                            <i class="fa fa-plus mr10"></i>Add New
                        </button>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 pl0 ml0 pr0 mr0 mb15 search-container">
                @if (Auth::user()->isAllowTo('search-credential-document'))
                    {!! Form::open(['url' => route('credential_document_search_path', ['credential_id' => $credential_id]), 'id' => 'searchForm']) !!}
                    <span class="field search-input-container">
                            {!! Form::text('needle', $needle, ['class' => 'gui-input search-input', 'id' => 'needle']) !!}
                        </span>
                    <button id="button-search" class="btn btn-info search-button">
                        <i class="fa fa-search mr10"></i>Search
                    </button>
                    @if (!empty($needle))
                        <button class="btn btn-default reset-button equis" type="button" data-location="credentialdocuments/{{ $credential_id }}">x</button>
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
                        <th class="td-sortable">{!! SortableTrait::link('document_type_id', 'Document Type', ['credential_id' => $credential_id]) !!}</th>
                        <th class="actions">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($credentialDocuments as $credentialDocument)
                            <tr data-id="{{ $credentialDocument->id }}" class="{{ !empty($credentialDocument->disabled) ? 'disabled' : '' }}">
                                <td>{{ $credentialDocument->type->name }} </td>
                                <td class="centered actions">
                                    <ul class="nav navbar-nav">
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i></a>
                                            <ul class="dropdown-menu animated animated-short flipInX" role="menu">
                                                @if (Auth::user()->isAllowTo('update-credential-document-action'))
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="credentialdocumentactions" data-id="{{ $credentialDocument->id }}">
                                                            <span class="fa fa-gears mr11"></span>View Actions
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (Auth::user()->isAllowTo('delete-credential-document'))
                                                    <li class="menu-separator"></li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="delete" data-id="{{ $credentialDocument->id }}">
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
                    @if (!$credentialDocuments->total())
                        <span>There is no item to show.</span>
                    @else
                        @if ($credentialDocuments->perPage() > $credentialDocuments->total())
                            <span>Showing {!! $credentialDocuments->total() !!} {{ $credentialDocuments->total() == 1 ? 'item' : 'items' }}</span>
                        @else
                            <span>Showing {{ $credentialDocuments->perPage() }} of {!! $credentialDocuments->total() !!} {{ $credentialDocuments->total() == 1 ? 'item': 'items' }}</span>
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 pagination-pages">
                Items per page:
                <select id="pageItems" class="form-control">
                    <option value="{{ route('credential_document_list_path', array_merge(Request::query(), ['credential_id' => $credential_id, 'page' => 0, 'perPage' => 10])) }}"{{ Request::input('perPage') == 10 ? ' selected' : '' }}>10</option>
                    <option value="{{ route('credential_document_list_path', array_merge(Request::query(), ['credential_id' => $credential_id, 'page' => 0, 'perPage' => 20])) }}"{{ Request::input('perPage') == 20 ? ' selected' : '' }}>20</option>
                    <option value="{{ route('credential_document_list_path', array_merge(Request::query(), ['credential_id' => $credential_id, 'page' => 0, 'perPage' => $credentialDocuments->total()])) }}"{{ Request::input('perPage') == $credentialDocuments->total() ? ' selected' : '' }}>All</option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-4 pull-right pagination-handlers text-right">
                @include('components.pagination.custom', ['paginator' => $credentialDocuments, 'route' => 'credential_document_list_path', 'query' => http_build_query(Input::except(['page', '_token']))])
            </div>
        </div>

        {!! Form::open(['method'=>'DELETE', 'route' => 'credential_document_delete_path', 'id' => 'deleteForm']) !!}
            {!! Form::hidden('credential_id', $credential_id) !!}
            <input type="hidden" id="strCid" name="strCid" value="">
        {!! Form::close() !!}
    </div>
@endsection

@section('js-files')
    <script>
        $(function(){
            $('#pageItems').change(function(){
                window.location.href = $(this).val();
            });

            $('#button-create').click(function(){
                window.location = "{{ route('credential_document_create_path', ['credential_id' => $credential_id]) }}";
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

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="credentialdocumentactions"]', function(){
                window.location = "{{ asset('credentialdocumentactions') }}/" + $(this).attr('data-id');
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="delete"]', function(){
                uiConfirm({callback: 'confirmDelete', params: [$(this).attr('data-id')]});
            });
        });

        function confirmDelete(params)
        {
            $('#strCid').val(params);
            $('#deleteForm').submit();
        }
    </script>
@stop