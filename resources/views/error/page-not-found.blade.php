<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" name="viewport">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<title>IASByHeart | Unauthorised </title>
<link rel="icon" type="image/x-icon" href="{{ asset('assets/images/logo/ias-logo.png') }}"/>
<link rel="icon" href="{{ asset('assets/images/logo/ias-logo.png') }}" type="image/png" sizes="16x16">
<!--vendors-->

<link href="https://fonts.googleapis.com/css?family=Hind+Vadodara:400,500,600" rel="stylesheet">
<!--Material Icons-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/materialdesignicons/materialdesignicons.min.css') }}">
<!--Bootstrap + atmos Admin CSS-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/atmos.min.css') }}">
<!-- Additional library for page -->

</head>
<body class="jumbo-page">


<main class="admin-main  bg-pattern">
    <div class="container">
        <div class="row m-h-100 ">
            <div class="col-md-8 col-lg-4  m-auto">
                <div class="card shadow-lg p-t-20 p-b-20">
                    <div class="card-body text-center">
                            
                        
                        <img width="200" alt="image" src="{{ asset('assets/img/404.svg') }}">
                        <h1 class="display-1 fw-600 font-secondary">404</h1>
                        <h5>Oops, the page you are looking for does not exist.</h5>
                        <p class="opacity-75">
                                You may want to head back to the dashboard. If you think something is broken, report a problem to the Administrator of <strong>IASBYHEART Team</strong>.
                        </p>
                        <img alt="image" src="{{ asset('assets/images/logo/ias-logo.png') }}" style="width:30%;height:auto">
                        <div class="p-t-10">
                                @if(session('login') == true)
                                <a href="/dashboard" class="btn btn-lg btn-primary">Go Back Dashboard</a>
                            @else
                            <a href="/login" class="btn btn-lg btn-primary">Go Back Login</a>
                            @endif

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>





</body>
</html>