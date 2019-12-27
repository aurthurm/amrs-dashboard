<!DOCTYPE html>
<html lang="en">
<head>
    @include('layoutsections.header')
    @include('layoutsections.scripts')
<style>
.mandatory{color: #f30f00;}
</style>
</head>
<!--body with default sidebar pinned -->
<body class="sidebar-pinned">
<!--sidebar Begins-->

@include('layoutsections.sidenav')

<!--sidebar Ends-->


<main class="admin-main">

    <!--site header begins-->
        @include('layoutsections.headernav')
    <!--site header ends -->

    <section class="admin-content">
            <!-- BEGIN PlACE PAGE CONTENT HERE -->
            <!--  container or container-fluid as per your need           -->
                <!-- <div class="container">
                <section class="content"> -->

                    @section('content')
                        
                    @show

                    
                    <!-- </section>
                </div> -->
            <!-- END PLACE PAGE CONTENT HERE -->
    </section>

</main>

@include('layoutsections.footer')
</body>
</html>
