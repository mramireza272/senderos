<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/png" href="/img/logos/logo_fav.png"/>

    <title>
        @yield('titulo')
    </title>

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/nifty.min.css" rel="stylesheet">

    <link href="/premium/icon-sets/icons/line-icons/premium-line-icons.min.css" rel="stylesheet">
    <link href="/premium/icon-sets/icons/solid-icons/premium-solid-icons.min.css" rel="stylesheet">

    <link href="/css/themes/type-a/theme-lime.css" rel="stylesheet">

    <!--datepicker-->
    <link rel="stylesheet" type="text/css" href="/css/bootstrap-datetimepicker.min.css">
    <link href="/css/datepicker3.css" rel="stylesheet">

    <!--Nestable List [ OPTIONAL ]-->
    <link href="/plugins/nestable-list/nestable-list.css" rel="stylesheet">

    <!--=================================================-->
    <link rel="stylesheet" href="/plugins/chosen/chosen.css">
    {{--
    <link href="/plugins/pace/pace.min.css" rel="stylesheet">
    <script src="/plugins/pace/pace.min.js"></script>
    --}}

    {{-- <link href="/css/demo/nifty-demo.min.css" rel="stylesheet"> --}}

    <!--Animate.css [ OPTIONAL ]-->
    <link href="/plugins/animate-css/animate.css" rel="stylesheet">
    @yield('customcss')

</head>

<body>
    <div id="container" class="effect aside-float aside-bright mainnav-sm navbar-fixed">

        @include('templates.navbar')

        <div class="boxed">

            <div id="content-container">
                <div id="page-head">

                    <div id="page-title">
                        <h1 class="page-header text-overflow">
                            @yield('titulo_pagina')
                        </h1>
                    </div>
                       
                </div>

                <div id="page-content">
                    @yield('content')
                </div>
            </div>

            <aside id="aside-container">
                <div id="aside">
                    <div class="nano">
                        <div class="nano-content">
                            @include('templates.aside')
                        </div>
                    </div>
                </div>
            </aside>

            <nav id="mainnav-container">
                <div id="mainnav">

                    <div id="mainnav-menu-wrap">
                        <div class="nano">
                            <div class="nano-content">
                                @include('templates.navigation')
                            </div>
                        </div>
                    </div>

                </div>
            </nav>

        </div>

        <footer id="footer">

            <div class="show-fixed pad-rgt pull-right">
                You have <a href="#" class="text-main"><span class="badge badge-danger">3</span> pending action.</a>
            </div>

            <div class="hide-fixed pull-right pad-rgt">
                <strong>Versión: </strong> {{ Session::get('Current.version')}}
            </div>

            <p class="pad-lft">Gobierno de la Ciudad de México.</p>



        </footer>

        <button class="scroll-top btn">
            <i class="pci-chevron chevron-up"></i>
        </button>

    </div>

    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/nifty.min.js"></script>


    <!--Datepicker-->
    <script type="text/javascript" src="/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="/js/locales/bootstrap-datetimepicker.es.js"></script>

    <!--Nestable List [ OPTIONAL ]-->
    <script src="/plugins/nestable-list/jquery.nestable.js"></script>
    <!--=================================================-->

    <!--Demo script [ DEMONSTRATION ]-->
    {{--<script src="/js/demo/nifty-demo.min.js"></script>--}}
    <script src="/plugins/chosen/chosen.jquery.js" type="text/javascript"></script>
    <script src="/plugins/chosen/init.js" type="text/javascript" charset="utf-8"></script>
    <!--Bootbox Modals [ OPTIONAL ]-->
    <script src="/plugins/bootbox/bootbox.min.js"></script>
    <!--Select2 [ OPTIONAL ]-->
    <script src="/plugins/select2/js/select2.min.js"></script>
    <script src="/plugins/select2/js/i18n/es.js"></script>


    <!--Modals [ SAMPLE ]-->
    <script src="/plugins/ui-modals/ui-modals.js"></script>
    @yield('customjs')


</body>
</html>