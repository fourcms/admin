<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @foreach($metaData as $key => $value)
        <meta name="app:{{ $key }}" content="{{ $value }}">
    @endforeach

    <link href="{{ assetver('build/admin/css/vendor.css') }}" rel="stylesheet" />
    <link href="{{ assetver('build/admin/css/main.css') }}" rel="stylesheet" />
</head>
<body class="hold-transition skin-green sidebar-mini">
<div id="app"></div>

<script src="{{ assetver('build/admin/js/vendor.bundle.js') }}"></script>
<script src="/build/admin/tinymce/tinymce.min.js"></script>
<script src="{{ assetver('build/admin/js/main.bundle.js') }}"></script>

@if(config('fourcms.admin.analytics_id'))
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', '{{ config('fourcms.admin.analytics_id') }}', 'auto');
        ga('require', 'autotrack');
        ga('send', 'pageview');
    </script>
@endif

</body>
</html>
