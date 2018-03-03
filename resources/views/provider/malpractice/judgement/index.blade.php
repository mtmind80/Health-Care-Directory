@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Provider: "{{ $providerName }}"</a>
                </li>
                <li class="crumb-active">
                    <a href="{{ route('provider_malpractice_list_path', ['provider_id' => $provider_id]) }}">Policy: "{{ $policyNumber }}"</a>
                </li>
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Judgements</a>
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
                    @if (Auth::user()->isAllowTo('create-provider-malpractice-judgement'))
                        <button id="button-create" class="btn btn-success mr10" type="submit">
                            <i class="fa fa-plus mr10"></i>Add New
                        </button>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 pl0 ml0 pr0 mr0 mb15 search-container">
                @if (Auth::user()->isAllowTo('search-provider-malpractice-judgement'))
                    {!! Form::open(['url' => route('provider_malpractice_judgement_search_path', ['malpractice_id' => $malpractice_id]), 'id' => 'searchForm']) !!}
                    <span class="field search-input-container">
                            {!! Form::text('needle', $needle, ['class' => 'gui-input search-input', 'id' => 'needle']) !!}
                        </span>
                    <button id="button-search" class="btn btn-info search-button">
                        <i class="fa fa-search mr10"></i>Search
                    </button>
                    @if (!empty($needle))
                        <button class="btn btn-default reset-button equis" type="button" data-location="providermalpracticejudgements/{{ $malpractice_id }}">x</button>
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
                        <th class="td-sortable">{!! SortableTrait::link('offense_types.name|provider_malpractice_judgements.offense_type_id', 'Offense Type', ['malpractice_id' => $malpractice_id]) !!}</th>
                        <th class="td-sortable xs-hidden">{!! SortableTrait::link('plaintiff_name', 'Plaintiff Name', ['malpractice_id' => $malpractice_id]) !!}</th>
                        <th class="td-sortable xs-hidden text-center">{!! SortableTrait::link('defendant', 'Defendant', ['malpractice_id' => $malpractice_id]) !!}</th>
                        <th class="td-sortable xs-hidden text-center">{!! SortableTrait::link('dismissed', 'Dismissed', ['malpractice_id' => $malpractice_id]) !!}</th>
                        <th class="td-sortable xs-hidden text-center">{!! SortableTrait::link('primary_sourced', 'PSD', ['malpractice_id' => $malpractice_id]) !!}</th>
                        <th class="td-sortable xs-hidden text-center">{!! SortableTrait::link('occurred_at', 'Occurred At', ['malpractice_id' => $malpractice_id]) !!}</th>
                        <th class="td-sortable text-center">{!! SortableTrait::link('reported_at', 'Reported At', ['malpractice_id' => $malpractice_id]) !!}</th>
                        <th class="td-sortable xs-hidden text-center">{!! SortableTrait::link('settled_at', 'Settled At', ['malpractice_id' => $malpractice_id]) !!}</th>
                        <th class="td-sortable xs-hidden text-center">{!! SortableTrait::link('settled_amount', 'Amount', ['malpractice_id' => $malpractice_id]) !!}</th>
                        <th class="actions">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($judgements as $judgement)
                            <tr data-id="{{ $judgement->id }}" class="{{ !empty($judgement->disabled) ? 'disabled' : '' }}">
                                <td>{{ $judgement->offenseType->name }}</td>
                                <td class="xs-hidden">{{ $judgement->plaintiff_name }}</td>
                                <td class="text-center xs-hidden">{!! $judgement->html_defendant !!}</td>
                                <td class="text-center xs-hidden">{!! $judgement->html_dismissed !!}</td>
                                <td class="text-center xs-hidden">{!! $judgement->html_primary_sourced !!}</td>
                                <td class="text-center xs-hidden">{!! $judgement->html_occurred_at !!}</td>
                                <td class="text-center">{!! $judgement->html_reported_at !!}</td>
                                <td class="text-center xs-hidden">{!! $judgement->html_settled_at !!}</td>
                                <td class="text-center xs-hidden">{!! $judgement->html_settled_amount !!}</td>
                                <td class="centered actions">
                                    <ul class="nav navbar-nav">
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i></a>
                                            <ul class="dropdown-menu animated animated-short flipInX" role="menu">
                                                @if (Auth::user()->isAllowTo('update-insurer'))
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="edit" data-id="{{ $judgement->id }}">
                                                            <span class="glyphicons glyphicons-edit"></span>Edit
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (Auth::user()->isAllowTo('delete-provider-malpractice-judgement'))
                                                    <li class="menu-separator"></li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="delete" data-id="{{ $judgement->id }}">
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
                    @if (!$judgements->total())
                        <span>There is no item to show.</span>
                    @else
                        @if ($judgements->perPage() > $judgements->total())
                            <span>Showing {!! $judgements->total() !!} {{ $judgements->total() == 1 ? 'item' : 'items' }}</span>
                        @else
                            <span>Showing {{ $judgements->perPage() }} of {!! $judgements->total() !!} {{ $judgements->total() == 1 ? 'item': 'items' }}</span>
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 pagination-pages">
                Items per page:
                <select id="pageItems" class="form-control">
                    <option value="{{ route('provider_malpractice_judgement_list_path', array_merge(Request::query(), ['malpractice_id' => $malpractice_id, 'page' => 0, 'perPage' => 10])) }}"{{ Request::input('perPage') == 10 ? ' selected' : '' }}>10</option>
                    <option value="{{ route('provider_malpractice_judgement_list_path', array_merge(Request::query(), ['malpractice_id' => $malpractice_id, 'page' => 0, 'perPage' => 20])) }}"{{ Request::input('perPage') == 20 ? ' selected' : '' }}>20</option>
                    <option value="{{ route('provider_malpractice_judgement_list_path', array_merge(Request::query(), ['malpractice_id' => $malpractice_id, 'page' => 0, 'perPage' => $judgements->total()])) }}"{{ Request::input('perPage') == $judgements->total() ? ' selected' : '' }}>All</option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-4 pull-right pagination-handlers text-right">
                @include('components.pagination.custom', ['paginator' => $judgements, 'route' => 'provider_malpractice_judgement_list_path', 'query' => http_build_query(Input::except(['page', '_token']))])
            </div>
        </div>

        {!! Form::open(['method'=>'DELETE', 'route' => 'provider_malpractice_judgement_delete_path', 'id' => 'deleteForm']) !!}
            {!! Form::hidden('malpractice_id', $malpractice_id) !!}
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
                window.location = "{{ route('provider_malpractice_judgement_create_path', ['malpractice_id' => $malpractice_id]) }}";
            });

            $('#needle').blur(function(){
                $(this).parents('label').removeClass('state-error').next('em').remove();
            });

            $('#searchForm').validate({
                rules: {
                    needle: {
                        minlength: 2,
                        text     : true
                    }
                }
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="edit"]', function(){
                window.location = "{{ asset('providermalpracticejudgements') }}/" + $(this).attr('data-id') + '/edit';
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