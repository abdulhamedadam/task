<!DOCTYPE html>

@if(app()->getLocale() =='ar')
    <html direction="rtl" dir="rtl" style="direction: rtl">

    @else
    <html lang="en">

    @endif
<!--begin::Head-->
<head>
    <base href="../../"/>
    <title>Task</title>
    <meta charset="utf-8"/>
    <meta name="description"
          content="The most advanced Bootstrap Admin Theme on Bootstrap Market trusted by over 4,000 beginners and professionals. Multi-demo, Dark Mode, RTL support. Grab your copy now and get life-time updates for free."/>
    <meta name="keywords"
          content="keen, bootstrap, bootstrap 5, bootstrap 4, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta property="og:locale" content="en_US"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="Keen - Multi-demo Bootstrap 5 HTML Admin Dashboard Theme"/>
    <meta property="og:url" content="https://keenthemes.com/keen"/>
    <meta property="og:site_name" content="Keenthemes | Keen"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts.head')

</head>
<!--end::Head-->
<!--begin::Body-->

    <body  id="kt_app_body" data-kt-app-layout="dark-sidebar"
           data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true"
           data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-minimize="on"
           data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true"
           data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true"
           data-kt-app-toolbar-enabled="true"  class="app-default" >


<script>var defaultThemeMode = "light";
    var themeMode;
    if (document.documentElement) {
        if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
        } else {
            if (localStorage.getItem("data-bs-theme") !== null) {
                themeMode = localStorage.getItem("data-bs-theme");
            } else {
                themeMode = defaultThemeMode;
            }
        }
        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }
        document.documentElement.setAttribute("data-bs-theme", themeMode);
    }</script>
<!--end::Theme mode setup on page load-->
<!--begin::App-->
<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <!--begin::Page-->
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
        <!--begin::Header-->

        <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">


            <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                <!--begin::Content wrapper-->
            @yield('content')



            <!--end::Footer-->
            </div>
            <!--end:::Main-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>
<!--end::App-->

<!--begin::Javascript-->

@include('layouts.footer-scripts')

<!--end::Javascript-->
</body>
<!--end::Body-->
</html>
