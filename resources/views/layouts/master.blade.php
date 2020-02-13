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
<script>
$(document).ready(function() {
    var path = '<?php echo Request::path();?>';
    var splitUrl = path.split('/');
    if(splitUrl[0]=="amrdata")
    {
        $("#amrdata").addClass('active');  
    }
    else if(splitUrl[0]=="user" ||splitUrl[0]=="userfacilitymap" ||splitUrl[0]=="facilities")
    {
        $("#manage").addClass('opened');
        $('#manageul').css('display','block');
        $("#"+splitUrl[0]).addClass('active');
    }
    else if(splitUrl[0]=="reports" )
    {
        $("#reports").addClass('opened');
        $("#"+splitUrl[0]).addClass('active');
    }
});
</script>