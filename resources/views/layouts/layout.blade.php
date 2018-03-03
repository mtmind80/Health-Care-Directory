<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    @if (env('APP_ENV') != 'production')
        <!-- To prevent most search engine web crawlers from indexing a page --> 
        <meta name="robots" content="noindex">
    @endif

    <title>{!! isset($seo['pageTitlePrefix']) ? html_entity_decode($seo['pageTitlePrefix']) : html_entity_decode($defaultSEO['pageTitlePrefix']) !!}{!! isset($seo['pageTitle']) ? html_entity_decode($seo['pageTitle']) : html_entity_decode($defaultSEO['pageTitle']) !!}</title>

    <link rel="shortcut icon" href="{{ $siteUrl }}/images/{{ $config['favico'] }}">

    <!-- Font CSS (Via CDN) -->
    {!! Html::style('http://fonts.googleapis.com/css?family=Open+Sans:400,600,700') !!}
    {!! Html::style('http://fonts.googleapis.com/css?family=Roboto:300,400,500,700') !!}

    <!-- Fonts CSS -->
    {!! Html::style($siteUrl . '/fonts/fonts.css') !!}

    <!-- Icon Fonts CSS:
        font-awesome-4.5.0,
        icomoon,
        glyphicons,
        glyphicons-pro
    -->
    {!! Html::style($siteUrl . '/fonts/icon-fonts.min.css') !!}

    <!-- Vendor CSS:
        theme,
        adminpanels,
        admin-forms,
        adminmodal,
        xeditor,
        address,
        typeahead,
        magnific-popup,
        html5imageupload,
        summernote-modified,
        dockmodal,
        bootstrap datetimepicker (also for datepicker)
    -->

    {!! Html::style($siteUrl . '/vendor/css/vendor.min.css') !!}

    <!-- use  -->


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    {!! Html::script($siteUrl . '/js/html5shiv.min.js') !!}
    {!! Html::script($siteUrl . '/js/respond.min.js') !!}
    <![endif]-->

    @yield('css-files')

    <!-- My base CSS:
        ui.dialog,
        PNotify,
        important,
        validate
    -->
    {!! Html::style($siteUrl . '/css/common-base.min.css') !!}

    <!-- My backend CSS: -->
    {!! Html::style($siteUrl . '/css/app.css') !!}
</head>
<body itemscope itemtype="http://schema.org/WebPage" id="admin-body">
    <meta itemprop="name" content="{!! !empty($seo['pageTitle']) ? str_replace('"', '',  html_entity_decode($seo['pageTitle'])) : str_replace('"', '',  html_entity_decode($defaultSEO['pageTitle'])) !!}"/>
    <meta itemprop="description" content="{!! !empty($seo['description']) ? html_entity_decode(str_replace('"', '',  $seo['description'])) : str_replace('"', '',  html_entity_decode($defaultSEO['description'])) !!}"/>
    <meta itemprop="keywords" content="{!! !empty($seo['keywords']) ? str_replace('"', '',  html_entity_decode($seo['keywords'])) : str_replace('"', '',  html_entity_decode($defaultSEO['keywords'])) !!}"/>

    <!-- company micro data -->
    <div itemscope itemtype="http://schema.org/Organization">
        <meta itemprop="name" content="{{ html_entity_decode($config['company']) }}">
        <meta itemprop="url" content="{{ asset('/') }}">
        <meta itemprop="logo" content="{{ $siteUrl }}/images/{{ $config['logo'] }}">
    </div>

    <noscript>
        <div class="alert warning">
            <i class="fa fa-left-sides-circle"></i> You seem to have Javascript disabled. This website needs javascript in order to function properly!
        </div>
    </noscript>

    <div id="main">
        @include('layouts._header')
        @include('layouts._nav')
        <section id="content_wrapper">
            @yield('content-header')
            @yield('content')
        </section>
        @if (!empty($advanceSearch))
            @include('widgets._advance_search')
        @endif
    </div>

    <a id="back-to-top" href="javascript:"><i class="fa fa-angle-up"></i></a>

    <!-- Vendor JS:
        jquery,
        jquery-ui,
        bootstrap,
        utility,
        main,
        bootstrap-editable,
        address,
        typeahead 1y2,
        moment,
        admin-form-elements,
        jquery.magnific-popup,
        html5imageupload,
        jquery.ui-interactions,
        summernote-modified,
        summernote-ext-fontstyle,
        dockmodal,
        jquery-ui-timepicker,
        bootstrap datetimepicker (also for datepicker with pickTime: false, in app.js)
    -->
    {!! Html::script($siteUrl . '/vendor/js/vendor.min.js') !!}

    <!-- global JS variables -->
    <script>
        var base_url = "{{ asset('/') }}";
        var site_url = "{{ $siteUrl }}";
        var lang = "{{ $lang }}";
    </script>

    <!-- page specific plugins -->
    @yield('js-plugin-files')

    <!-- My base JS:
        ui.dialog,
        PNotify,
        validators_en,
        jquery.validate
    -->
    {!! Html::script($siteUrl . '/js/common-base.min.js') !!}

    <!-- My backend JS: -->
    {!! Html::script($siteUrl . '/js/app.js') !!}

    @if (!empty($config['idleTimeOut']) && ($iddleTimeOut = (integer)$config['idleTimeOut']))
        @include('widgets._idle_timeout', ['idleTimeOut' => 1000 * 60 * $iddleTimeOut])
    @endif

    <script>
        $(document).ready(function(){
            var actionController = "{{ $action['actionController'] }}",
                actionFunction = "{{ $action['actionFunction'] }}",
                actionParameterId = "{{ $action['actionParameterId'] }}";

            $('#sidebar_left .active').removeClass('active');
            $('#sidebar_left .nav-subitem-selected').removeClass('nav-subitem-selected');

            var actionParent = $('#sidebar_left').find('.' + actionController + '-controller'),
                actionTarget = $('#sidebar_left').find('.' + actionController + '-' + actionFunction);

            if (actionTarget.size() > 1) {
                actionTarget = $('#sidebar_left').find('.' + actionController + '-' + actionFunction + '.id-' + actionParameterId);
            } else if (actionTarget.size() == 0 ) {
                actionTarget = $('#sidebar_left').find('.' + actionController + '-all');
            }

            if (actionTarget.hasClass('reset')) {
                actionTarget.parents('li').addClass('active');
            } else {
                actionParent.parents('li').addClass('active');  // pages-edit-2

                if (!actionParent.hasClass('menu-open')) {
                    actionParent.addClass('menu-open');
                }
                if (!actionTarget.hasClass('nav-subitem-selected')) {
                    actionTarget.addClass('nav-subitem-selected');
                }
            }

            checkViewport();

            var waitForFinalEvent=function(){var b={};return function(c,d,a){a||(a="I am a banana!");b[a]&&clearTimeout(b[a]);b[a]=setTimeout(c,d)}}();
            var fullDateString = new Date();

            $(window).resize(function () {
                waitForFinalEvent(function(){
                    checkViewport();
                    if (typeof resizeVideoPlayer == 'function') {
                        resizeVideoPlayer();
                    }
                }, 100, fullDateString.getTime())
            });

            $('.search-container .reset-button').click(function(){
                window.location = base_url + $(this).data('location');
            });

            @if (!empty($event))
                var evArr = $.parseJSON('{!! $event !!}');
                $(evArr.target).trigger(evArr.name);
            @endif
        });

        function checkViewport()
        {
            $('body').removeClass('xs').removeClass('sm').removeClass('md').removeClass('lg').removeClass('not-xs');
            if( isBreakpoint('xs') ) {
                $('body').addClass('xs');
                $('.list-table .xs-hidden').hide();
            } else {
                $('body').addClass('not-xs');
                if( isBreakpoint('sm') ) {
                    $('body').addClass('sm');
                    $('.list-table .xs-hidden').show();
                } else if( isBreakpoint('md') ) {
                    $('body').addClass('md');
                    $('.list-table .xs-hidden').show();
                } else if( isBreakpoint('lg') ) {
                    $('body').addClass('lg');
                    $('.list-table .xs-hidden').show();
                }
            }
        }
        function isBreakpoint(alias) {
            return $('.device-' + alias).is(':visible');
        }
    </script>

    <!-- page specific js code -->
    @yield('js-files')

    <div class="device-xs visible-xs viewport-item" data-viewport="xs"></div>
    <div class="device-sm visible-sm viewport-item" data-viewport="sm"></div>
    <div class="device-md visible-md viewport-item" data-viewport="md"></div>
    <div class="device-lg visible-lg viewport-item" data-viewport="lg"></div>
</body>
</html>
