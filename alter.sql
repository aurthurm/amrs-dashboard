---Sudarmathi (15 Apr 2020)
INSERT INTO `resources` (`resource_id`, `display_name`, `status`) VALUES ('App\\Http\\Controllers\\Facilities\\FacilitiesController', 'Facilities', 'active'), ('App\\Http\\Controllers\\Amrdata\\AmrdataController', 'Amrdata', 'active');
INSERT INTO `resources` (`resource_id`, `display_name`, `status`) VALUES ('App\\Http\\Controllers\\Users\\UsersController', 'Users', 'active'), ('App\\Http\\Controllers\\Roles\\RolesController', 'Roles', 'active');
INSERT INTO `resources` (`resource_id`, `display_name`, `status`) VALUES ('App\\Http\\Controllers\\Admin\\AdminController', 'Login', 'active')

INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\Users\\UsersController', 'add', 'Add'), ('App\\Http\\Controllers\\Users\\UsersController', 'edit', 'Edit'), ('App\\Http\\Controllers\\Users\\UsersController', 'index', 'Access'), ('App\\Http\\Controllers\\Admin\\AdminController', 'resetPassword', 'Reset Password'), ('App\\Http\\Controllers\\Users\\UsersController', 'userfacilitymap', 'User Facility Map');

INSERT INTO `privileges` (`resource_id`, `privilege_name`, `display_name`) VALUES ('App\\Http\\Controllers\\Facilities\\FacilitiesController', 'add', 'Add'), ('App\\Http\\Controllers\\Facilities\\FacilitiesController', 'edit', 'Edit'), ('App\\Http\\Controllers\\Facilities\\FacilitiesController', 'index', 'Access'),
('App\\Http\\Controllers\\Amrdata\\AmrdataController', 'add', 'Add'), ('App\\Http\\Controllers\\Amrdata\\AmrdataController', 'edit', 'Edit'), ('App\\Http\\Controllers\\Amrdata\\AmrdataController', 'index', 'Access'),
('App\\Http\\Controllers\\roles\\rolesController', 'add', 'Add'), ('App\\Http\\Controllers\\roles\\rolesController', 'edit', 'Edit'), ('App\\Http\\Controllers\\roles\\rolesController', 'index', 'Access')

