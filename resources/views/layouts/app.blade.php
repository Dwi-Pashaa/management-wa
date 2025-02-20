<!DOCTYPE html>
<html lang="en">

<head>
	<meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('title')</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="" />
	<meta name="keywords" content="">
	<meta name="author" content="Phoenixcoded" />
	<!-- Favicon icon -->
	<link rel="icon" href="{{ $platformImage }}" type="image/x-icon">

	<!-- vendor css -->
	<link rel="stylesheet" href="{{asset('')}}css/style.css">
    @stack('css')
</head>

<body class="">
	<!-- [ Pre-loader ] start -->
	<div class="loader-bg">
		<div class="loader-track">
			<div class="loader-fill"></div>
		</div>
	</div>
	<!-- [ Pre-loader ] End -->
	<!-- [ navigation menu ] start -->
	@include('components.topbar')
	<!-- [ navigation menu ] end -->
	<!-- [ Header ] start -->
	@include('components.sidebar')
	<!-- [ Header ] end -->

	<!-- [ Main Content ] start -->
	<div class="pcoded-main-container">
		<div class="pcoded-content">
			<!-- [ breadcrumb ] start -->
			<div class="page-header">
				<div class="page-block">
					<div class="row align-items-center">
						<div class="col-md-12">
							<div class="page-header-title">
								<h5 class="m-b-10">@yield('title')</h5>
							</div>
							<ul class="breadcrumb">
								<li class="breadcrumb-item">
                                    <a href="index.html"><i class="feather icon-home"></i></a>
								</li>
								<li class="breadcrumb-item">
                                    <a href="#!">@yield('title')</a>
                                </li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!-- [ breadcrumb ] end -->
			<!-- [ Main Content ] start -->
			@yield('content')
			<!-- [ Main Content ] end -->
		</div>
	</div>
	<!-- [ Main Content ] end -->

    @stack('modal')

	<!-- Required Js -->
	<script src="{{asset('')}}js/vendor-all.min.js"></script>
	<script src="{{asset('')}}js/plugins/bootstrap.min.js"></script>
	<script src="{{asset('')}}js/pcoded.min.js"></script>
    @stack('js')

	<script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</body>

</html>