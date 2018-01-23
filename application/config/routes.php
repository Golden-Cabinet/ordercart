<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

//----------------------------------------------------------------------------------------------------------------------
//   400 / 500 HTTP status code default routes
//----------------------------------------------------------------------------------------------------------------------
$route['404_override'] = '';

//----------------------------------------------------------------------------------------------------------------------
//  Login/Register
//----------------------------------------------------------------------------------------------------------------------

$route['logout'] = 'users/logout';
$route['login'] = 'users/login';
$route['forgot-password'] = 'users/forgot_password';
$route['reset-password'] = 'users/reset_password';
$route['reset-password/(:any)'] = 'users/reset_password/$1';
$route['register'] = 'users/register';
$route['registration-beta/(:any)'] = 'users/register/$1';
$route['register/error'] = 'users/profile';

//----------------------------------------------------------------------------------------------------------------------
//  Settings
//----------------------------------------------------------------------------------------------------------------------

$route['settings/users'] = 'users/users';
$route['settings/users/(:num)'] = 'users/index/$1';
$route['settings/users/add'] = 'users/add';
$route['settings/users/delete/(:num)'] = 'users/delete/$1';
$route['settings/users/edit/(:num)'] = 'users/edit/$1';
$route['settings/users/edit'] = 'users/edit';


$route['settings/roles'] = 'Roles';
$route['settings/permissions'] = 'Permissions';
$route['settings/permissions/add'] = 'Permissions/add';

$route['users/(:num)'] = 'users/index/$1';

//------------------------------------------------------------------------------------------
//  All routes for the Pages Controller & 404 override - This controller is used for routing static pages.
//------------------------------------------------------------------------------------------

$route['default_controller'] = 'pages';
$route['(order|about|resources|location|dividends|faq|policies|whoweare|source)'] = 'pages/$1';
$route['xml'] = 'pages/xml';
$route['404_override'] = 'pages/error_404';

//------------------------------------------------------------------------------------------
// Formula Routes
//------------------------------------------------------------------------------------------

$route['formulas'] = 'formula/formula';
$route['formulas/add'] = 'formula/formula/add';
$route['formulas/edit/(:num)'] = 'formula/formula/edit/$1';
$route['formulas/edit'] = 'formula/formula/edit';
$route['formulas/delete/(:num)'] = 'formula/formula/delete/$1';
$route['formulas/build'] = 'formula/formula/build';
$route['formulas/view/(:num)'] = 'formula/formula/view/$1';
$route['formulas/cost'] = 'formula/formula/getFormulaCost';
$route['formulas/ingredients'] = 'formula/formula/getFormulaIngredients';
$route['formulas/shipping-cost'] = 'formula/formula/getShippingCost';
$route['formulas/checkname'] = 'formula/formula/checkname';
$route['formulas/share/(:num)'] = 'formula/formula/share/$1';
$route['formulas/share'] = 'formula/formula/share';
$route['formulas/unshare/(:num)'] = 'formula/formula/unshare/$1';

/**
 * Store Routes
 */

// Category
$rout['store/categories'] = 'store/categories';
$route['store/categories/add'] = 'store/categories/add';
$route['store/categories/edit/(:num)'] = 'store/categories/edit/$1';
$route['store/categories/delete/(:num)'] = 'store/categories/delete/$1';

// Product Types
$route['store/product-types'] = 'store/productTypes';
$route['store/product-types/add'] = 'store/productTypes/add';
$route['store/product-types/edit/(:num)'] = 'store/productTypes/edit/$1';
$route['store/product-types/edit'] = 'store/productTypes/edit';
$route['store/product-types/delete/(:num)'] = 'store/productTypes/delete/$1';

$route['store/products/(:num)'] = 'store/products/index/$1';
$route['store/products/category/(:any)'] = 'store/products/category/$1';



// Product Types
$route['store/product'] = 'store/productTypes';



// API  Calls
$route['store/products/api/products'] = 'store/products/getProducts';
// Brands
$route['store/brands'] = 'store/brands';
$route['store/brands/add'] = 'store/brands/add';
$route['store/brands/edit/(:num)'] = 'store/brands/edit/$1';
$route['store/brands/delete/(:num)'] = 'store/brands/delete/$1';

//-------------------------------------------------------
//  Orders
//-----------------------------------------------------

$route['store/orders'] = 'store/orders';
$route['store/orders/add'] = 'store/orders/add';
$route['store/orders/edit/(:num)'] = 'store/orders/edit/$1';
$route['store/orders/delete/(:num)'] = 'store/orders/delete/$1';
$route['store/orders/view/(:num)'] = 'store/orders/view/$1';
$route['store/orders/(:any)'] = 'store/orders/ordersByStatus/$1';
$route['store/orders/update/status'] = 'store/orders/updateOrderStatus';

//-------------------------------------------------------
//  Account Settings
//-------------------------------------------------------

$route['profile'] = 'users/editProfile';

//-------------------------------------------------------
//  Account Settings
//-------------------------------------------------------

$route['dashboard'] = 'dashboard/dashboard';


/* End of file routes.php */
/* Location: ./application/config/routes.php */