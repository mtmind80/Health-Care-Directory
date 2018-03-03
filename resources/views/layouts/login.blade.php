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

    <title>{!! isset($seo['pageTitlePrefix']) ? html_entity_decode($seo['pageTitlePrefix']) : html_entity_decode($defaultSEO['pageTitlePrefix']) !!}{!! isset($seo['pageTitle']) ? html_entity_decode($seo['pageTitle']) : ($lang == 'sp' ? 'Ingresar' : 'Login') !!}</title>

    <link rel="shortcut icon" href="{{ $siteUrl }}/images/cisneros-favicon.ico">

    <!-- Font CSS (Via CDN) -->
    {!! Html::style('http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800') !!}
    {!! Html::style('http://fonts.googleapis.com/css?family=Roboto:400,500,700,300') !!}

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
        PNotify
        xeditor,
        address,
        typeahead,
        magnific-popup,
        html5imageupload,
        summernote-modified,
        dockmodal
    -->

    {!! Html::style($siteUrl . '/vendor/css/vendor.min.css') !!}

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    {!! Html::script($siteUrl . '/js/html5shiv.min.js') !!}
    {!! Html::script($siteUrl . '/js/respond.min.js') !!}
    <![endif]-->

    <!-- My base CSS:
        ui.dialog,
        PNotify,
        important,
        validate
    -->
    {!! Html::style($siteUrl . '/css/common-base.min.css') !!}

    <!-- My login CSS: -->
    {!! Html::style($siteUrl . '/css/login.css') !!}
</head>
<body itemscope itemtype="http://schema.org/WebPage" class="external-page sb-l-c sb-r-c login-body">
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

    @yield('content')

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
        summernote-ext-fontstyle
        dockmodal,
        jquery-ui-timepicker
    -->
    {!! Html::script($siteUrl . '/vendor/js/vendor.min.js') !!}

    <!-- My base JS:
        ui.dialog,
        PNotify,
        validators_en,
        jquery.validate
    -->
    {!! Html::script($siteUrl . '/js/common-base.min.js') !!}

    <!-- global JS variables -->
    <script>
        var base_url = "{{ asset('/') }}";
        var lang = "{{ $lang }}";
    </script>

    <!-- page specific -->
    @yield('js-files')
</body>
</html>
