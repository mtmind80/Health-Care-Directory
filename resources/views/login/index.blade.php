@extends('layouts.layout')

@section('content-header')
    <header id="topbar">
        <div class="topbar-left">
            <ol class="breadcrumb">
                <li class="crumb-active">
                    <a href="javascript:void(0)" class="no-link">Logins</a>
                </li>
                <li class="crumb-trail">List</li>
            </ol>
        </div>
        <div class="topbar-right">
        </div>
    </header>
@stop

@section('content')
        <!-- Image popup -->
    <div id="userAvatar" class="popup-basic popup-lg mfp-with-anim mfp-hide">
        <img class="img-responsive" src="{{ $siteUrl }}" alt="">
    </div>

    <div id="content" class="animated fadeIn list-items admin-form">
        @include('errors._list')
        <div class="clearfix">
            <div class="xs-hidden col-xs-12 col-sm-6 pl0 ml0 pr0 mr0 mb15">
            </div>
            <div class="col-xs-12 col-sm-6 pl0 ml0 pr0 mr0 mb15 search-container">
                @if (Auth::user()->isAllowTo('search-login'))
                    {!! Form::open(['route' => 'login_search_path', 'id' => 'searchForm']) !!}
                    <span class="field search-input-container">
                        {!! Form::text('needle', $needle, ['class' => 'gui-input search-input', 'id' => 'needle', 'placeholder' => 'to search for a date, enter as "yyyy-mm-dd"']) !!}
                    </span>
                    <button id="button-search" class="btn btn-info search-button">
                        <i class="fa fa-search mr10"></i>Search
                    </button>
                    @if (!empty($needle))
                        <button class="btn btn-default reset-button equis" type="button" data-location="logins">x</button>
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
                        <th class="td-avatar">Image</th>
                        <th class="td-sortable td-name xs-hidden">{!! SortableTrait::link('first_name', 'User Name') !!}</th>
                        <th class="td-sortable">{!! SortableTrait::link('logged_in', 'Logged In At') !!}</th>
                        <th class="td-sortable">{!! SortableTrait::link('logged_out', 'Logged Out At') !!}</th>
                    </tr>
                    </thead>

                    <tbody id="sortable-body">
                        @foreach ($logins as $login)
                            <tr data-id="{{ $login->id }}" class="{{ !empty($login->disabled) ? 'disabled' : '' }}">
                                @if (!empty($login->user->avatar))
                                    <td>
                                        <a class="show-image" href="javascript:void(0)" data-toggle="tooltip" title="click to enlarge">
                                            <img src="{{ $siteUrl.'/images/avatars/'.$login->user->avatar }}" alt="{{ $login->user->avatar }}" height="40"/>
                                        </a>
                                    </td>
                                @else
                                    <td></td>
                                @endif
                                <td class="xs-hidden">{{ $login->user->fullName }}</td>
                                <td class="">{{ $login->logged_in->format('m/d/Y - H:i') }}</td>
                                <td class="">{{ !empty($login->logged_out) ? $login->logged_out->format('m/d/y H:i') : 'Currently logged in' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row pagination-container clearfix text-center">
            <div class="col-xs-12 col-sm-4">
                <div class="pull-left pagination-info">
                    <span>Showing {{ $logins->perPage() }} of {!! $logins->total() !!} entries</span>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 pagination-pages">
                Items per page:
                <select id="pageItems" class="form-control">
                    <option value="{{ route('login_list_path', array_merge(Request::query(), ['page' => 0, 'perPage' => 10])) }}"{{ Request::input('perPage') == 10 ? ' selected' : '' }}>10</option>
                    <option value="{{ route('login_list_path', array_merge(Request::query(), ['page' => 0, 'perPage' => 20])) }}"{{ Request::input('perPage') == 20 ? ' selected' : '' }}>20</option>
                    <option value="{{ route('login_list_path', array_merge(Request::query(), ['page' => 0, 'perPage' => $logins->total()])) }}"{{ Request::input('perPage') == $logins->total() ? ' selected' : '' }}>All</option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-4 pull-right pagination-handlers text-right">
                @include('components.pagination.custom', ['paginator' => $logins, 'route' => 'login_list_path', 'query' => http_build_query(Input::except(['page', '_token']))])
            </div>
        </div>
    </div>
@endsection

@section('js-files')
    <script>
        $(function(){
            $('#pageItems').change(function(){
                window.location.href = $(this).val();
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
        });
    </script>
@stop