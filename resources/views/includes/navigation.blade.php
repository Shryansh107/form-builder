<body class="app sidebar-mini">
    <!--Loader-->
    <div id="global-loader">
        <img src="{{ asset('images/loader.svg') }}" class="loader-img" alt="">
    </div>
    <!--Loader-->

    <!--Page-->
    <div class="page">
        <div class="page-main h-100">

            <!--App-Header (Single Sticky Navbar) -->
            <div class="app-header1 header d-flex align-items-center" style="position: fixed; top: 0; left: 0; right: 0; z-index: 999; background: #ffffff; border-bottom: 1px solid #e5e7eb; height: 64px; box-shadow: none; padding: 0 24px;">
                <div class="container-fluid p-0">
                    <div class="d-flex align-items-center justify-content-between" style="height: 100%;">
                        <div class="d-flex align-items-center gap-3">
                            <a class="header-brand" href="{{ url('/') }}" style="text-decoration: none;">
                                <span style="color:#111111; font-family: 'Inter', sans-serif; font-size: 20px; font-weight: 600; letter-spacing: -0.3px; display: inline-block; vertical-align: middle;" class="header-brand-img mobile-logo">LMS</span>
                            </a>
                            <span style="height: 18px; width: 1px; background-color: #e5e7eb; display: inline-block;"></span>
                            <span style="font-family: 'Inter', sans-serif; font-size: 14px; font-weight: 500; color: #374151; user-select: none;">Form Builder UI</span>
                        </div>

                        {{-- Form builder toolbar controls are positioned absolutely by form.blade.php --}}

                        <div class="d-flex align-items-center">
                        </div>
                    </div>
                </div>
            </div>
            <!--/App-Header-->
        </div>
    </div>
</body>