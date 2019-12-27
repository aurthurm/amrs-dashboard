<!DOCTYPE html>
<html lang="en">
<head>
@include('layoutsections.header')
@include('layoutsections.scripts')
</head>
<body class="jumbo-page">

<main class="admin-main  ">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-lg-4  bg-white">
                    @if (session('status'))
                    <div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-5" role="alert" id="show_alert_index" >
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <script>$('#show_alert_index').delay(3000).fadeOut();</script>
                @endif
                <div class="row align-items-center m-h-100">
                    <div class="mx-auto col-md-8">
                        <div class="p-b-20 text-center">
                            <p>
                                <img src="assets/img/logo.svg" width="80" alt="">

                            </p>
                            <p class="admin-brand-content">
                                atmos
                            </p>
                        </div>
                        <h3 class="text-center p-b-20 fw-400">Login</h3>
                        <form class="needs-validation" action="/login_submit" method="post">
                            @csrf
                            <div class="form-row">
                                <div class="form-group floating-label col-md-12">
                                    <label>Username</label>
                                    <input type="text" required id="username" name="username" class="form-control" placeholder="Username">
                                </div>
                                <div class="form-group floating-label col-md-12">
                                    <label>Password</label>
                                    <input type="password" id="password" name="password" required class="form-control "  >
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block btn-lg">Login</button>

                        </form>
                        <p class="text-right p-t-10">
                            <a href="#!" class="text-underline">Forgot Password?</a>
                        </p>
                    </div>

                </div>
               
            </div>
            <div class="col-lg-8 d-none d-md-block bg-cover" style="background-image: url('assets/img/login.svg');">

            </div>
        </div>
    </div>
</main>
@include('layoutsections.footer')


</body>
</html>
