@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Providers</a>
                </li>
                <li class="crumb-trail">List</li>
            </ol>
        </div>
        <div class="topbar-right">
            <div class="ib topbar-dropdown">
            </div>
            @if (!empty($advanceSearch))
                <div class="ml15 ib va-m" id="toggle_sidemenu_r">
                    <a href="#" class="pl5 prel mt5"><span class="dib pr25 mt5">Advance Search</span><i class="pab top-4 mt0 right0 fa fa-sign-in fs22 text-primary"></i></a>
                </div>
            @endif
        </div>
    </header>
@stop

@section('content')
    <div id="content" class="animated fadeIn list-items admin-form">
        @include('errors._list')
        <div class="clearfix">
            <div class="col-xs-12 col-sm-6 pl0 ml0 pr0 mr0 mb15">
                <div class="btn-group">
                    @if (Auth::user()->isAllowTo('create-provider'))
                        <button id="button-create" class="btn btn-success mr10" type="submit">
                            <i class="fa fa-plus mr10"></i>Add New
                        </button>
                    @endif
                    @if (Auth::user()->isAllowTo('export-provider'))
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="fa fa-file-o mr10"></i>Export
                                <span class="caret ml5"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('provider_to_excel_path') }}"><i class="fa fa-file-excel-o mr10"></i> Excel</a>
                                </li>
                                <li>
                                    <a href="{{ route('provider_to_pdf_path') }}"><i class="fa fa-file-pdf-o mr10"></i> Pdf</a>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 pl0 ml0 pr0 mr0 mb15 search-container">
                @if (Auth::user()->isAllowTo('search-provider'))
                    {!! Form::open(['route' => 'provider_search_path', 'id' => 'searchForm']) !!}
                    <span class="field search-input-container">
                            {!! Form::text('needle', $needle, ['class' => 'gui-input search-input', 'id' => 'needle']) !!}
                        </span>
                    <button id="button-search" class="btn btn-info search-button">
                        <i class="fa fa-search mr10"></i>Search
                    </button>
                    @if (!empty($needle))
                        <button class="btn btn-default reset-button equis" type="button" data-location="providers">x</button>
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
                        <th class="">Name</th>
                        <th class="td-sortable">{!! SortableTrait::link('provider_types.name|providers.provider_type_id', 'Type') !!}</th>
                        <th class="td-sortable">{!! SortableTrait::link('provider_subtypes.name|providers.provider_subtype_id', 'Sub Type') !!}</th>
                        <th class="xs-hidden text-center">{!! SortableTrait::link('under_contract', 'Under Contract') !!}</th>
                        <th class="xs-hidden">Location</th>
                        <th class="td-sortable xs-hidden">{!! SortableTrait::link('phone') !!}</th>
                        <th class="td-sortable xs-hidden">{!! SortableTrait::link('email') !!}</th>
                        <th class="actions">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($providers as $provider)
                            <tr data-id="{{ $provider->id }}" class="{{ !empty($provider->disabled) ? 'disabled' : '' }}">
                                <td><a href="{{ route('provider_edit_path', ['id' => $provider->id]) }}" data-toggle="tooltip" title="Click to edit">{{ $provider->name }}</a></td>
                                <td>{!! $provider->type->name !!}</td>
                                <td>{!! $provider->subType->name !!}</td>
                                <td class="xs-hidden text-center">{!! $provider->htmlIsUnderContract !!}</td>
                                <td class="xs-hidden">{!! $provider->location !!}</td>
                                <td class="xs-hidden">{!! $provider->phone !!}</td>
                                <td class="xs-hidden">{!! $provider->email !!}</td>
                                <td class="centered actions">
                                    <ul class="nav navbar-nav">
                                        <li class="dropdown">
                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i></a>
                                            <ul class="dropdown-menu animated animated-short flipInX" role="menu">
                                                @if (Auth::user()->isAllowTo('show-provider'))
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="show" data-id="{{ $provider->id }}">
                                                            <span class="fa fa-eye mr12"></span>Profile
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (Auth::user()->isAllowTo('update-provider'))
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="edit" data-id="{{ $provider->id }}">
                                                            <span class="glyphicons glyphicons-edit"></span>Edit
                                                        </a>
                                                    </li>
                                                        <li class="menu-separator"></li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="addresses" data-id="{{ $provider->id }}">
                                                            <span class="ml3 fa fa-map-marker mr15"></span>Addresses
                                                        </a>
                                                    </li>
                                                    
                                                    @if ($provider->isProfessional)
                                                        <li>
                                                            <a href="javascript:void(0);" class="action" data-action="affiliations" data-id="{{ $provider->professional->id }}">
                                                                <span class="fa fa-hand-spock-o mr10"></span>Affiliations
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);" class="action" data-action="boards" data-id="{{ $provider->professional->id }}">
                                                                <span class="fa fa-graduation-cap mr10"></span>Boards
                                                            </a>
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="conditions" data-id="{{ $provider->id }}">
                                                            <span class="fa fa-heart mr10"></span>Conditions
                                                        </a>
                                                    </li>
                                                    @if ($provider->isProfessional)   
                                                        <li>
                                                            <a href="javascript:void(0);" class="action" data-action="fellowships" data-id="{{ $provider->professional->id }}">
                                                                <span class="fa fa-users mr12"></span>Fellowships
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);" class="action" data-action="identifications" data-id="{{ $provider->professional->id }}">
                                                                <span class="fa fa-credit-card mr12"></span>Identifications
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);" class="action" data-action="internships" data-id="{{ $provider->professional->id }}">
                                                                <span class="fa fa-book mr12"></span>Internships
                                                            </a>
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="malpractices" data-id="{{ $provider->id }}">
                                                            <span class="fa fa-gavel mr12"></span>Malpractices
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="procedures" data-id="{{ $provider->id }}">
                                                            <span class="fa fa-magic mr10"></span>Procedures
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="references" data-id="{{ $provider->id }}">
                                                            <span class="fa fa-child ml2 mr12"></span>References
                                                        </a>
                                                    </li>
                                                    @if ($provider->isProfessional)
                                                        <li>
                                                            <a href="javascript:void(0);" class="action" data-action="residencies" data-id="{{ $provider->professional->id }}">
                                                                <span class="fa fa-building-o mr12"></span>Residencies
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);" class="action" data-action="schools" data-id="{{ $provider->professional->id }}">
                                                                <span class="fa fa-institution mr12"></span>Schools
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endif
                                                @if (Auth::user()->isAllowTo('delete-provider'))
                                                    <li class="menu-separator"></li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="action" data-action="delete" data-id="{{ $provider->id }}">
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
                    @if (!$providers->total())
                        <span>There is no item to show.</span>
                    @else
                        @if ($providers->perPage() > $providers->total())
                            <span>Showing {!! $providers->total() !!} {{ $providers->total() == 1 ? 'item' : 'items' }}</span>
                        @else
                            <span>Showing {{ $providers->perPage() }} of {!! $providers->total() !!} {{ $providers->total() == 1 ? 'item': 'items' }}</span>
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 pagination-pages">
                Items per page:
                <select id="pageItems" class="form-control">
                    <option value="{{ route('provider_list_path', array_merge(Request::query(), ['page' => 0, 'perPage' => 10])) }}"{{ Request::input('perPage') == 10 ? ' selected' : '' }}>10</option>
                    <option value="{{ route('provider_list_path', array_merge(Request::query(), ['page' => 0, 'perPage' => 20])) }}"{{ Request::input('perPage') == 20 ? ' selected' : '' }}>20</option>
                    <option value="{{ route('provider_list_path', array_merge(Request::query(), ['page' => 0, 'perPage' => $providers->total()])) }}"{{ Request::input('perPage') == $providers->total() ? ' selected' : '' }}>All</option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-4 pull-right pagination-handlers text-right">
                @include('components.pagination.custom', ['paginator' => $providers, 'route' => 'provider_list_path', 'query' => http_build_query(Input::except(['page', '_token']))])
            </div>
        </div>

        {!! Form::open(['method'=>'DELETE', 'route' => 'provider_delete_path', 'id' => 'deleteForm']) !!}
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

            $('#button-create').click(function(){
                window.location = "{{ route('provider_create_path') }}";
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="show"]', function(){
                window.location = "{{ asset('providers') }}/" + $(this).attr('data-id') + '/show';
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="edit"]', function(){
                window.location = "{{ asset('providers') }}/" + $(this).attr('data-id') + '/edit';
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="addresses"]', function(){
                window.location = "{{ asset('provideraddresses') }}/" + $(this).attr('data-id');
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="affiliations"]', function(){
                window.location = "{{ asset('professionalaffiliations') }}/" + $(this).attr('data-id');
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="boards"]', function(){
                window.location = "{{ asset('professionalboards') }}/" + $(this).attr('data-id');
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="conditions"]', function(){
                window.location = "{{ asset('providerconditions') }}/" + $(this).attr('data-id');
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="fellowships"]', function(){
                window.location = "{{ asset('professionalfellowships') }}/" + $(this).attr('data-id');
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="identifications"]', function(){
                window.location = "{{ asset('professionalidentifications') }}/" + $(this).attr('data-id');
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="internships"]', function(){
                window.location = "{{ asset('professionalinternships') }}/" + $(this).attr('data-id');
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="malpractices"]', function(){
                window.location = "{{ asset('providermalpractices') }}/" + $(this).attr('data-id');
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="procedures"]', function(){
                window.location = "{{ asset('providerprocedures') }}/" + $(this).attr('data-id');
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="references"]', function(){
                window.location = "{{ asset('providerreferences') }}/" + $(this).attr('data-id');
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="residencies"]', function(){
                window.location = "{{ asset('professionalresidencies') }}/" + $(this).attr('data-id');
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="schools"]', function(){
                window.location = "{{ asset('professionalschools') }}/" + $(this).attr('data-id');
            });

            $('table.list-table tbody tr td.actions').on('click', 'a.action[data-action="delete"]', function(){
                uiConfirm({callback: 'confirmDelete', params: [$(this).attr('data-id')]});
            });

            $('.multiselect').multiselect({
                includeSelectAllOption: true
            });

            $('#country_id').change(function(ev){
                if ($('#country_id').val() == 0) {
                    $('#state_id').empty();
                } else {
                    $.ajax({
                        type:"post",
                        url: "{{ route('state_fetch_path') }}",
                        data: {
                            country_id: $(this).val()
                        },
                        beforeSend: function (request){
                            PNotify.removeAll();
                            showSpinner();
                            request.setRequestHeader("X-XSRF-TOKEN", "{{ $encToken }}");
                        },
                        complete: function(){
                            hideSpinner();
                        },
                        success: function(response){
                            var result = $.parseJSON(response);
                            $('#state_id').empty();
                            if (result.success) {
                                var html = ['<option value="0">&nbsp;</option>'];
                                $.each(result.data, function(index, value){
                                    html.push('<option value="'+ index +'">'+ value +'</option>')
                                });
                                $('#state_id').html(html.join(''));
                            } else {
                                pnAlert({
                                    type: 'error',
                                    title: 'Error',
                                    text: result.message,
                                    addClass: 'mt50'
                                });
                            }
                        }
                    });
                }


            });

            $('#provider_type_id').change(function(ev){
                if ($('#provider_type_id').val() == 0) {
                    $('#provider_subtype_id').empty();
                } else {
                    $.ajax({
                        type: "post",
                        url: "{{ route('provider_subtype_fetch_path') }}",
                        data: {
                            provider_type_id: $(this).val()
                        },
                        beforeSend: function (request) {
                            PNotify.removeAll();
                            showSpinner();
                            request.setRequestHeader("X-XSRF-TOKEN", "{{ $encToken }}");
                        },
                        complete: function () {
                            hideSpinner();
                        },
                        success: function (response) {
                            var result = $.parseJSON(response);
                            $('#provider_subtype_id').empty();
                            if (result.success) {
                                var html = ['<option value="0">&nbsp;</option>'];
                                $.each(result.data, function (index, value) {
                                    html.push('<option value="' + index + '">' + value + '</option>')  // person-data-section facility-data-section
                                });
                                $('#provider_subtype_id').html(html.join(''));
                            } else {
                                pnAlert({
                                    type: 'error',
                                    title: 'Error',
                                    text: result.message,
                                    addClass: 'mt50'
                                });
                            }
                        }
                    });
                }
            });

            $('#go_filter').click(function(){
                var route = $('#go_filter').attr('data-route'),
                    url = route,
                    segments = url.split('?'),
                    base,
                    query,
                    items,
                    arr,
                    index,
                    i;

                if (segments.length == 1) {
                    base = url;
                    query = '';
                    items = [];
                } else {                                     // there is a query section in the url:
                    base = segments[0];
                    query = segments[1];
                    items = query.split('&');
                }

                if ($('#city').val() !== '' && !isLocation($('#city').val())) {
                    pnAlert({
                        type: 'error',
                        title: 'Error',
                        text: 'Invalid value for zip code',
                        addClass: 'mt50'
                    });

                    return false;
                }
                if (query == '' || query.indexOf('city') == -1) {       // city does not exist in query:
                    if ($('#city').val() !== '') {
                        items.push('city=' + $('#city').val());
                    }
                } else {                                                // city exists in query:
                    for (i = 0; i < items.length; i++ ) {
                        if (items[i].indexOf('city') >= 0) {
                            if ($('#city').val() !== '') {
                                items[i] = 'city=' + $('#city').val();
                            } else {
                                items.splice(i, 1);                     // remove item
                            }

                            break;
                        }
                    }
                }

                if ($('#zipcode').val() !== '' && !isZipCode($('#zipcode').val())) {
                    pnAlert({
                        type: 'error',
                        title: 'Error',
                        text: 'Invalid value for zip code',
                        addClass: 'mt50'
                    });

                    return false;
                }
                if (query == '' || query.indexOf('zipcode') == -1) {    // zip code does not exist in query:
                    if ($('#zipcode').val() !== '') {
                        items.push('zipcode=' + $('#zipcode').val());
                    }
                } else {                                                // zip code exists in query:
                    for (i = 0; i < items.length; i++ ) {
                        if (items[i].indexOf('zipcode') >= 0) {
                            if ($('#zipcode').val() !== '') {
                                items[i] = 'zipcode=' + $('#zipcode').val();
                            } else {
                                items.splice(i, 1);                     // remove item
                            }

                            break;
                        }
                    }
                }

                if (query == '' || query.indexOf('country_id') == -1) {     // country_id does not exist in query:
                    if ($('#country_id').val() > 0) {
                        items.push('country_id=' + $('#country_id').val());
                    }
                } else {                                                    // country_id exists in query:
                    for (i = 0; i < items.length; i++ ) {
                        if (items[i].indexOf('country_id') >= 0) {
                            if ($('#country_id').val() > 0) {
                                items[i] = 'country_id=' + $('#country_id').val();
                            } else {
                                items.splice(i, 1);                         // remove item
                            }

                            break;
                        }
                    }
                }

                if (query == '' || query.indexOf('state_id') == -1) {     // state_id does not exist in query:
                    if ($('#state_id').val() > 0) {
                        items.push('state_id=' + $('#state_id').val());
                    }
                } else {                                                    // state_id exists in query:
                    for (i = 0; i < items.length; i++ ) {
                        if (items[i].indexOf('state_id') >= 0) {
                            if ($('#state_id').val() > 0) {
                                items[i] = 'state_id=' + $('#state_id').val();
                            } else {
                                items.splice(i, 1);                         // remove item
                            }

                            break;
                        }
                    }
                }

                if (query == '' || query.indexOf('provider_type_id') == -1) {       // provider_type_id does not exist in query:
                    if ($('#provider_type_id').val() > 0) {
                        items.push('provider_type_id=' + $('#provider_type_id').val());
                    }
                } else {                                                            // provider_type_id exists in query:
                    for (i = 0; i < items.length; i++ ) {
                        if (items[i].indexOf('provider_type_id') >= 0) {
                            if ($('#provider_type_id').val() > 0) {
                                items[i] = 'provider_type_id=' + $('#provider_type_id').val();
                            } else {
                                items.splice(i, 1);                                 // remove item
                            }

                            break;
                        }
                    }
                }

                if (query == '' || query.indexOf('provider_subtype_id') == -1) {     // provider_subtype_id does not exist in query:
                    if ($('#provider_subtype_id').val() > 0) {
                        items.push('provider_subtype_id=' + $('#provider_subtype_id').val());
                    }
                } else {                                                            // provider_subtype_id exists in query:
                    for (i = 0; i < items.length; i++ ) {
                        if (items[i].indexOf('provider_subtype_id') >= 0) {
                            if ($('#provider_subtype_id').val() > 0) {
                                items[i] = 'provider_subtype_id=' + $('#provider_subtype_id').val();
                            } else {
                                items.splice(i, 1);                                 // remove item
                            }

                            break;
                        }
                    }
                }

                if (query == '' || query.indexOf('condition_id') == -1) {       // condition_id does not exist in query:
                    if ($('#condition_id').val() > 0) {
                        items.push('condition_id=' + $('#condition_id').val());
                    }
                } else {                                                        // condition_id exists in query:
                    for (i = 0; i < items.length; i++ ) {
                        if (items[i].indexOf('condition_id') >= 0) {
                            if ($('#condition_id').val() > 0) {
                                items[i] = 'condition_id=' + $('#condition_id').val();
                            } else {
                                items.splice(i, 1);                             // remove item
                            }

                            break;
                        }
                    }
                }

                if (query == '' || query.indexOf('procedure_id') == -1) {       // procedure_id does not exist in query:
                    if ($('#procedure_id').val() > 0) {
                        items.push('procedure_id=' + $('#procedure_id').val());
                    }
                } else {                                                        // procedure_id exists in query:
                    for (i = 0; i < items.length; i++ ) {
                        if (items[i].indexOf('procedure_id') >= 0) {
                            if ($('#procedure_id').val() > 0) {
                                items[i] = 'procedure_id=' + $('#procedure_id').val();
                            } else {
                                items.splice(i, 1);                             // remove item
                            }

                            break;
                        }
                    }
                }
                

                /*
                 'city'                => $city,
                 'zipcode'             => $zipcode,
                 'country_id'          => $country_id,
                 'state_id'            => $state_id,
                 'provider_type_id'    => $provider_type_id,
                 'provider_subtype_id' => $provider_subtype_id,
                 'condition_id'        => $condition_id,
                 'procedure_id'        => $procedure_id,

                 */




                if (items.length > 0) {
                    url = base + '?' + items.join('&');
                } else {
                    url = base;
                }

                window.location = url;
            });
        });

        function confirmDelete(params)
        {
            $('#strCid').val(params);
            $('#deleteForm').submit();
        }
    </script>
@stop