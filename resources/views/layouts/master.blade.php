@include('./partials.head')
<body>
	<div class="wrapper">
		<div class="main-header" data-background-color="{{$setting->skin}}">
			<!-- Logo Header -->
			@include('./partials.header')
			<!-- End Logo Header -->
			<!-- Navbar Header -->
			@include('./partials.navbar')
			<!-- End Navbar -->
		</div>
		<!-- Sidebar -->
		@include('./partials.sidebar')
		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header mb-1">
						<h4 class="page-title">
							@yield('title')
						</h4>
						@stack('breadcrumbs')

					</div>
					<div class="row" id="app">
						@include('./partials.alerts')
						@yield('content')
					</div>
				</div>

			</div>
		@include('./partials.copyright')
		</div>
	</div>
	<!--   Core JS Files   -->
	@include('./partials.jsDependencies')
</body>
</html>
