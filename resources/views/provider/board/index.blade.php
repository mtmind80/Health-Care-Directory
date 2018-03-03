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
                    <a href="javascript:void(0)" class="no-link">Boards</a>
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
                    @if (Auth::user()->isAllowTo('create-professional-board'))
                        <button id="button-create" class="btn btn-success mr10" type="submit">
                            <i class="fa fa-plus mr10"></i>Add New
                        </button>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 pl0 ml0 pr0 mr0 mb15 search-container">
                @if (Auth::user()->isAllowTo('search-professional-board'))
                    {!! Form::open(['url' => route('professional_board_search_path', ['professional_id' => $professional_id]), 'id' => 'searchForm']) !!}
                    <span class="field search-input-container">
                            {!! Form::text('needle', $needle, ['class' => 'gui-input search-input', 'id' => 'needle']) !!}
                        </span>
                    <button id="button-search" class="btn btn-info search-button">
                        <i class="fa fa-search mr10"></i>Search
                    </button>
                    @if (!empty($needle))
                        <button class="btn btn-default reset-button equis" type="button" data-location="professionalboards/{{ $professional_id }}">x</button>
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
                        <th class="td-sortable xs-hidden">{!! SortableTrait::link('speciality_types.name|professional_boards.speciality_type_id', 'Speciality Type', ['professional_id' => $professional_id]) !!}</th>
                        <th class="td-sortable xs-hidden">{!! SortableTrait::link('speciality_subtypes.name|professional_boards.speciality_subtype_id', 'Speciality Subtype', ['professional_id' => $professional_id]) !!}</th>
                        <th class="td-sortable">{!! SortableTrait::link('bodies.name|professional_boards.body_id', 'Body', ['professional_id' => $professional_id]) !!}</th>
                        <th class="td-sortable">{!! SortableTrait::link('certifications.name|professional_boards.certification_id', 'Certification', ['professional_id' => $professional_id]) !!}</th>
                        <th class="td-sortable xs-hidden">{!! SortableTrait::link('states.full_name|professional_boards.state_idd', 'State', ['professional_id' => $professional_id]) !!}</th>
                        <th class="td-sortable xs-hidden">{!! SortableTrait::link('countries.name|professional_boards.country_id', 'Country', ['professional_id' => $professional_id]) !!}</th>
                        <th class="td-sortable xs-hidden">{!! SortableTrait::link('number', 'Number', ['professional_id' => $professional_id]) !!}</th>
                        <th class="td-sortable xs-hidden">{!! SortableTrait::link('issued_at', 'Issued', ['professional_id' => $professional_id]) !!}</th>
                        <th class="td-sortable">{!! SortableTrait::link('expired_at', 'Expired', ['professional_id' => $professional_id]) !!}</th>
                        <th class="actions">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($boards as $board)
                            <tr data-id="{{ $board->id }}" class="{{ !empty($board->disabled) ? 'disabled' : '' }}">
                                <td class="xs-hidden">{{ $board->specialityType->name }}</td>
                                <td class="xs-hidden">{{ $board->specialitySubtype->name }}</td>
                                <td class="">{{ $board->body->name }}</td>
                                <td class="">{{ $board->certification->name }}</td>
                                <td class="xs-hidden">{{ $board->state->full_name }}</td>
                                <td class="xs-hidden">{{ $board->country->name }}</td>
                                <td class="xs-hidden">{{ $board->number }}</td>
                                <td class="xs-hidden">{{ $board->htmlIssuedAt }}</td>
                                <td class="">{!! $board->htmlExpiredAt !!}</td>
                                <td class="centered actions">
                                    <ul class="nav navbar-nav">
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i></a>
                                            <ul class="dropdown-menu animated animated-short flipInX" role="menu">
                                                @if (Auth::user()->isAllowTo('update-professional-board'))
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="edit" data-id="{{ $board->id }}">
                                                            <span class="glyphicons glyphicons-edit"></span>Edit
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (Auth::user()->isAllowTo('delete-professional-board'))
                                                    <li class="menu-separator"></li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="delete" data-id="{{ $board->id }}">
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
                    @if (!$boards->total())
                        <span>There is no item to show.</span>
                    @else
                        @if ($boards->perPage() > $boards->total())
                            <span>Showing {!! $boards->total() !!} {{ $boards->total() == 1 ? 'item' : 'items' }}</span>
                        @else
                            <span>Showing {{ $boards->perPage() }} of {!! $boards->total() !!} {{ $boards->total() == 1 ? 'item': 'items' }}</span>
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 pagination-pages">
                Items per page:
                <select id="pageItems" class="form-control">
                    <option value="{{ route('professional_board_list_path', array_merge(Request::query(), ['professional_id' => $professional_id, 'page' => 0, 'perPage' => 10])) }}"{{ Request::input('perPage') == 10 ? ' selected' : '' }}>10</option>
                    <option value="{{ route('professional_board_list_path', array_merge(Request::query(), ['professional_id' => $professional_id, 'page' => 0, 'perPage' => 20])) }}"{{ Request::input('perPage') == 20 ? ' selected' : '' }}>20</option>
                    <option value="{{ route('professional_board_list_path', array_merge(Request::query(), ['professional_id' => $professional_id, 'page' => 0, 'perPage' => $boards->total()])) }}"{{ Request::input('perPage') == $boards->total() ? ' selected' : '' }}>All</option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-4 pull-right pagination-handlers text-right">
                @include('components.pagination.custom', ['paginator' => $boards, 'route' => 'professional_board_list_path', 'query' => http_build_query(Input::except(['page', '_token']))])
            </div>
        </div>

        {!! Form::open(['method'=>'DELETE', 'route' => 'professional_board_delete_path', 'id' => 'deleteForm']) !!}
            {!! Form::hidden('professional_id', $professional_id) !!}
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
                window.location = "{{ route('professional_board_create_path', ['professional_id' => $professional_id]) }}";
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
                window.location = "{{ asset('professionalboards') }}/" + $(this).attr('data-id') + '/edit';
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