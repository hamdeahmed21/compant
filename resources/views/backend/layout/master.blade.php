@include('backend.layout.head')


<body class="sidebar-fixed sidebar-dark header-light header-fixed" id="body">
<script>
    NProgress.configure({ showSpinner: false });
    NProgress.start();
</script>

<div class="mobile-sticky-body-overlay"></div>

<div class="wrapper">

    <!--
====================================
——— LEFT SIDEBAR WITH FOOTER
=====================================
-->
    @include('backend.layout.aside')



    <div class="page-wrapper">
       @include('backend.layout.header')

       @yield('content')




        </div>

    </div>
</div>


@include('backend.layout.footer')


</body>
</html>

