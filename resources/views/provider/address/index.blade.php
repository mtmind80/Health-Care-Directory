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
                    <a href="javascript:void(0)" class="no-link">Secondary Addresses</a>
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
                    @if (Auth::user()->isAllowTo('create-provider-address'))
                        <button id="button-create" class="btn btn-success mr10" type="submit">
                            <i class="fa fa-plus mr10"></i>Add New
                        </button>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 pl0 ml0 pr0 mr0 mb15 search-container">
                @if (Auth::user()->isAllowTo('search-provider-address'))
                    {!! Form::open(['url' => route('provider_address_search_path', ['provider_id' => $provider_id]), 'id' => 'searchForm']) !!}
                    <span class="field search-input-container">
                            {!! Form::text('needle', $needle, ['class' => 'gui-input search-input', 'id' => 'needle']) !!}
                        </span>
                    <button id="button-search" class="btn btn-info search-button">
                        <i class="fa fa-search mr10"></i>Search
                    </button>
                    @if (!empty($needle))
                        <button class="btn btn-default reset-button equis" type="button" data-location="provideraddresses/{{ $provider_id }}">x</button>
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
                        <th class="td-sortable">{!! SortableTrait::link('address_types.name|provider_addresses.address_type_id', 'Address Type', ['provider_id' => $provider_id]) !!}</th>
                        <th class="">Address</th>
                        <th class="td-sortable xs-hidden">{!! SortableTrait::link('city', 'City', ['provider_id' => $provider_id]) !!}</th>
                        <th class="td-sortable xs-hidden">{!! SortableTrait::link('zipcode', 'Zip Code', ['provider_id' => $provider_id]) !!}</th>
                        <th class="td-sortable xs-hidden">{!! SortableTrait::link('states.full_name|provider_addresses.state_id', 'State', ['provider_id' => $provider_id]) !!}</th>
                        <th class="td-sortable xs-hidden">{!! SortableTrait::link('countries.name|provider_addresses.country_id', 'Country', ['provider_id' => $provider_id]) !!}</th>
                        <th class="actions">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($addresses as $address)
                            <tr data-id="{{ $address->id }}" class="{{ !empty($address->disabled) ? 'disabled' : '' }}">
                                <td>{{ $address->type->name }}</td>
                                <td class="xs-hidden">{{ $address->address }}{!! !empty($address->address_2) ? '<br>'.$address->address_2 : '' !!}</td>
                                <td class="not-xs-hidden">{!! $address->location !!}</td>
                                <td class="xs-hidden">{{ $address->city }}</td>
                                <td class="xs-hidden">{{ $address->zipcode }}</td>
                                <td class="xs-hidden">{{ $address->state->full_name }}</td>
                                <td class="xs-hidden">{{ $address->country->name }}</td>
                                <td class="centered actions">
                                    <ul class="nav navbar-nav">
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i></a>
                                            <ul class="dropdown-menu animated animated-short flipInX" role="menu">
                                                @if (Auth::user()->isAllowTo('update--provider-address'))
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="edit" data-id="{{ $address->id }}">
                                                            <span class="glyphicons glyphicons-edit"></span>Edit
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (Auth::user()->isAllowTo('delete-provider-address'))
                                                    <li class="menu-separator"></li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="delete" data-id="{{ $address->id }}">
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
                    @if (!$addresses->total())
                        <span>There is no item to show.</span>
                    @else
                        @if ($addresses->perPage() > $addresses->total())
                            <span>Showing {!! $addresses->total() !!} {{ $addresses->total() == 1 ? 'item' : 'items' }}</span>
                        @else
                            <span>Showing {{ $addresses->perPage() }} of {!! $addresses->total() !!} {{ $addresses->total() == 1 ? 'item': 'items' }}</span>
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 pagination-pages">
                Items per page:
                <select id="pageItems" class="form-control">
                    <option value="{{ route('provider_address_list_path', array_merge(Request::query(), ['provider_id' => $provider_id, 'page' => 0, 'perPage' => 10])) }}"{{ Request::input('perPage') == 10 ? ' selected' : '' }}>10</option>
                    <option value="{{ route('provider_address_list_path', array_merge(Request::query(), ['provider_id' => $provider_id, 'page' => 0, 'perPage' => 20])) }}"{{ Request::input('perPage') == 20 ? ' selected' : '' }}>20</option>
                    <option value="{{ route('provider_address_list_path', array_merge(Request::query(), ['provider_id' => $provider_id, 'page' => 0, 'perPage' => $addresses->total()])) }}"{{ Request::input('perPage') == $addresses->total() ? ' selected' : '' }}>All</option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-4 pull-right pagination-handlers text-right">
                @include('components.pagination.custom', ['paginator' => $addresses, 'route' => 'provider_address_list_path', 'query' => http_build_query(Input::except(['page', '_token']))])
            </div>
        </div>

        {!! Form::open(['method'=>'DELETE', 'route' => 'provider_address_delete_path', 'id' => 'deleteForm']) !!}
            {!! Form::hidden('provider_id', $provider_id) !!}
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
                window.location = "{{ route('provider_address_create_path', ['provider_id' => $provider_id]) }}";
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
                window.location = "{{ asset('provideraddresses') }}/" + $(this).attr('data-id') + '/edit';
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