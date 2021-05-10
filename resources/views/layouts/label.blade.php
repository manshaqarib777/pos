@include('partials.head')
    <body class="bg-default">
        <div class="wrapper">
            <div class="content">
                <div id="app" class="pt-2 m-0">
                    @yield('content')
                </div>
            </div>
            <!-- End Custom template -->
        </div>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{asset('js/report.js')}}"></script>
        @stack('script')
    </body>
</html>
