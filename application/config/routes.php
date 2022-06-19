<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
// echo date('Ymdhis');

$route['default_controller'] = "welcome";
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Categories
$route['category']= "Category/index";
$route['category/create']= "Category/create";
$route['category/edit/(:any)'] = "Category/edit/$1";
$route['category/store']['post'] = "Category/store";
$route['category/show'] = "Category/show/$1";
$route['category/update/(:any)']['put'] = "Category/update/$1";
$route['category/delete/(:num)']['delete'] = "Category/delete/$1";

// Lists
$route['list'] = "ShoppingList/index";
$route['list/create'] = "ShoppingList/create";
$route['list/edit/(:any)'] = "ShoppingList/edit/$1";
$route['list/store']['post'] = "ShoppingList/store";
$route['list/show/(:any)'] = "ShoppingList/show/$1";
$route['list/update/(:any)']['patch'] = "ShoppingList/update/$1";
$route['list/delete/(:any)']['delete'] = "ShoppingList/delete/$1";








