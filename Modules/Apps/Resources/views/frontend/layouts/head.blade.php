<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') || {{ setting('app_name', locale()) }}</title>
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('frontend') }}/assets/images/favicons/favicon-32x32.png">
    <!-- plugin scripts -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik+Gemstones&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,500i,600,700,800%7CSatisfy&amp;display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/animate.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/plugins/fontawesome-free-5.11.2-web/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/plugins/sama-icons/style.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/magnific-popup.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/vegas.min.css">
    @stack('css')
    <!-- template styles -->
    {{-- <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/style-exam-{{ locale() }}.css"> --}}
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/style-{{ locale() }}.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/responsive.css">

    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '3487768754790238');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=3487768754790238&ev=PageView&noscript=1" />
    </noscript>
    <!-- End Meta Pixel Code -->
    <script>
    !function (w, d, t) {
      w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=i,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};var o=document.createElement("script");o.type="text/javascript",o.async=!0,o.src=i+"?sdkid="+e+"&lib="+t;var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(o,a)};

      ttq.load('CFDD3MJC77U208RTC1BG');
      ttq.page();
    }(window, document, 'ttq');
    </script>
    @stack('social_scripts')
</head>

<body>

    @if (!App::environment(['local']))
        <div class="preloader"><span></span></div><!-- /.preloader -->
    @endif
