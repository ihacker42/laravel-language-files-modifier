<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Language Manager</title>
    <meta content="Language Manager" name="description" />
    <link rel="shortcut icon" href="/favicon.ico">
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/sweetalert2.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div id="wrapper">
	        @include('layouts.topbar')
	        @include('layouts.sidebar');
		<div class="content-page">
	        @yield('contents')
    	    @include('layouts.footer')
        </div>
    </div>

    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/metismenu.min.js"></script>
    <script src="/assets/js/jquery.slimscroll.js"></script>
    <script src="/assets/js/waves.min.js"></script>
	<script src="/assets/js/notify.min.js"></script>
    <!-- App js -->
    <script src="/assets/js/app.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.js" integrity="sha256-7OUNnq6tbF4510dkZHCRccvQfRlV3lPpBTJEljINxao=" crossorigin="anonymous"></script>
    @if(Session::has('message'))
        <script>
        //type = success,warn,info,error;
        $.notify("{{ Session::get('message') }}", "{{ Session::get('type') }}");
        </script>
    @endif
	@include('script')
    @yield('javascript')
</body>
</html>