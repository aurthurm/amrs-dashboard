<!DOCTYPE html>
<html lang="en">
<head>
<?php echo $__env->make('layoutsections.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<!--body with default sidebar pinned -->
<body class="sidebar-pinned">
<!--sidebar Begins-->

<?php echo $__env->make('layoutsections.sidenav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<!--sidebar Ends-->


<main class="admin-main">

    <!--site header begins-->
        <?php echo $__env->make('layoutsections.headernav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!--site header ends -->

    <section class="admin-content">
            <!-- BEGIN PlACE PAGE CONTENT HERE -->
            <!--  container or container-fluid as per your need           -->
                <div class="container">

                </div>
            <!-- END PLACE PAGE CONTENT HERE -->
    </section>

</main>

<?php echo $__env->make('layoutsections.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>
<?php /**PATH /var/www/amrs/resources/views/layouts/master.blade.php ENDPATH**/ ?>