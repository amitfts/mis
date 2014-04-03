<html>
    <head>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.1.1/css/bootstrap.min.css" />
        @if(Config::get('mis::config.direction') === 'rtl')
            <link rel="stylesheet" href="{{ asset('packages/efusionsoft/mis/assets/css/bootstrap-rtl.min.css') }}" media="all">
            <link rel="stylesheet" href="{{ asset('packages/efusionsoft/mis/assets/css/base-rtl.css') }}" media="all">
        @endif
        <link rel="stylesheet" href="{{ asset('packages/efusionsoft/mis/assets/css/toggle-switch.css') }}" />

        <link rel="stylesheet" href="{{ asset('packages/efusionsoft/mis/assets/css/base.css') }}" media="all">
         @if(Config::get('mis::config.direction') === 'rtl')
            <link rel="stylesheet" href="{{ asset('packages/efusionsoft/mis/assets/css/base-rtl.css') }}" media="all">
        @endif

        @if (!empty($favicon))
        <link rel="icon" {{ !empty($faviconType) ? 'type="$faviconType"' : '' }} href="{{ $favicon }}" />
        @endif

        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <script src="{{ asset('packages/efusionsoft/mis/assets/js/dashboard/base.js') }}"></script>

        <title>{{ (!empty($siteName)) ? $siteName : "Mis"}} - {{isset($title) ? $title : '' }}</title>
    </head>
    <body>
        @include(Config::get('mis::views.header'))
        {{ isset($breadcrumb) ? Breadcrumbs::create($breadcrumb) : ''; }}
        <div id="content">
            @yield('content')
        </div>
    </body>
</html>