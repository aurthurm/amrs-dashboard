<?php 
use Illuminate\Support\Facades\Request;

$role = session('role');
// dd($role);
$dashboard = '';
if (isset($role['App\\Http\\Controllers\\Dashboard\\DashboardController']['index']) && ($role['App\\Http\\Controllers\\Dashboard\\DashboardController']['index'] == "allow"))
    $dashboard = '<li class="menu-item" id="dashboard">
                    <a href="/dashboard" class=" menu-link">
                        <span class="menu-label">
                            <span class="menu-name">Dashboard</span>
                        </span>
                    </a>
                </li>';
$manage = '';
// if ((isset($role['App\\Http\\Controllers\\Roles\\RolesController']['index']) && ($role['App\\Http\\Controllers\\Roles\\RolesController']['index'] == "allow")) ||(isset($role['App\\Http\\Controllers\\Users\\UsersController']['index']) && ($role['App\\Http\\Controllers\\Users\\UsersController']['index'] == "allow")) || (isset($role['App\\Http\\Controllers\\Facilities\\FacilitiesController']['index']) && ($role['App\\Http\\Controllers\\Facilities\\FacilitiesController']['index'] == "allow")) )
// {
$manage = '<li class="menu-item " id="manage">
            <a href="#" class="open-dropdown menu-link">
                <span class="menu-label">
                    <span class="menu-name">Manage
                        <span class="menu-arrow"></span>
                    </span>
                    <span class="menu-info"></span>
                </span>
            </a>
            <ul class="sub-menu" id="manageul">';
if ((isset($role['App\\Http\\Controllers\\Users\\UsersController']['index']) && ($role['App\\Http\\Controllers\\Users\\UsersController']['index'] == "allow")) )
{
    $manage .= '<li class="menu-item" id="user">
                <a href="/user" class=" menu-link">
                    <span class="menu-label">
                        <span class="menu-name">Users</span>
                    </span>
                </a>
                </li>';

    $manage.= '<li class="menu-item" id="userfacilitymap">
                <a href="/userfacilitymap" class=" menu-link">
                    <span class="menu-label">
                        <span class="menu-name">User Facility Map</span>
                    </span>
                </a>
                </li>';
}
if((isset($role['App\\Http\\Controllers\\Facilities\\FacilitiesController']['index']) && ($role['App\\Http\\Controllers\\Facilities\\FacilitiesController']['index'] == "allow")))
{
    $manage.= '<li class="menu-item" id="facilities">
                <a href="/facilities" class=" menu-link">
                    <span class="menu-label">
                        <span class="menu-name">Facilities</span>
                    </span>
                </a>
                </li>';
}
if((isset($role['App\\Http\\Controllers\\Roles\\RolesController']['index']) && ($role['App\\Http\\Controllers\\Roles\\RolesController']['index'] == "allow")) )
{
    $manage.= '<li class="menu-item" id="roles">
                <a href="/roles" class=" menu-link">
                    <span class="menu-label">
                        <span class="menu-name">Roles</span>
                    </span>
                </a>
                </li>';
}
$manage.= '</ul></li>';
// }

$amrdata = '';
if (isset($role['App\\Http\\Controllers\\Amrdata\\AmrdataController']['index']) && ($role['App\\Http\\Controllers\\Amrdata\\AmrdataController']['index'] == "allow"))
    $amrdata = '<li class="menu-item" id="amrdata">
                    <a href="/amrdata" class="menu-link">
                        <span class="menu-label">
                            <span class="menu-name">AMR Data</span>
                        </span>
                    </a>
                    </li>
                    <li class="menu-item" id="reports">
                    <a href="#" class="menu-link">
                        <span class="menu-label">
                            <span class="menu-name">Reports</span>
                        </span>
                    </a>
                </li>';
?>
<aside class="admin-sidebar">
    <div class="admin-sidebar-brand">
        <!-- begin sidebar branding-->
        <img class="admin-brand-logo" src="assets/img/logo.svg" width="40" alt="atmos Logo">
        <span class="admin-brand-content"><a href="javascript:void(0);">AMRS</a></span>
        <!-- end sidebar branding-->
        <div class="ml-auto">
            <!-- sidebar pin-->
            <a href="#" class="admin-pin-sidebar btn-ghost btn btn-rounded-circle"></a>
            <!-- sidebar close for mobile device-->
            <a href="#" class="admin-close-sidebar"></a>
        </div>
    </div>
    <div class="admin-sidebar-wrapper js-scrollbar">
        <!-- Menu List Begins-->
        <ul class="menu">
            <?php 
                echo $dashboard;
                echo $manage;
                echo $amrdata;
            ?>
        </ul>
        <!-- Menu List Ends-->
    </div>

</aside>
