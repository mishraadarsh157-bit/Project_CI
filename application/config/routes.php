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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'Login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'Login';
$route['logged_in'] = 'Login/logged_in';
$route['dashboard'] = 'dashboard';
$route['dashfetch'] = 'dashboard/fetch';

////user

$route['usermaster'] = 'usermaster';
$route['userfetch'] = 'usermaster/fetch';
$route['userinsert'] = 'usermaster/insert';
$route['useredit/(:num)'] = 'usermaster/edit/$1';
$route['userupdate/(:num)'] = 'usermaster/update/$1';
$route['userdelete/(:num)'] = 'usermaster/delete/$1';

/////client

$route['clientmaster'] = 'clientmaster';
$route['clientfetch'] = 'clientmaster/fetch';
$route['fetchstates'] = 'clientmaster/fetchstates';
$route['fetchcities/(:num)'] = 'clientmaster/fetchcities/$1';
$route['clientinsert'] = 'clientmaster/insert';
$route['clientedit/(:num)'] = 'clientmaster/edit/$1';
$route['clientupdate/(:num)'] = 'clientmaster/update/$1';
$route['clientdelete/(:num)'] = 'clientmaster/delete/$1';

////item

$route['itemmaster'] = 'itemmaster';
$route['itemfetch'] = 'itemmaster/fetch';
$route['iteminsert'] = 'itemmaster/insert';
$route['itemedit/(:num)'] = 'itemmaster/edit/$1';
$route['itemupdate/(:num)'] = 'itemmaster/update/$1';
$route['itemdelete/(:num)'] = 'itemmaster/delete/$1';

//////invoice

$route['invoice'] = 'invoice';
$route['invoicefetch'] = 'invoice/fetch';
$route['invoiceClient/(:any)'] = 'invoice/invoiceClient/$1';
$route['invoiceClientdata/(:any)'] = 'invoice/invoiceClientdata/$1';
$route['invoiceItem'] = 'invoice/invoiceItem';
$route['invoiceItemdata'] = 'invoice/invoiceItemdata';
$route['InvoiceNo'] = 'invoice/invNo';
$route['invoiceInsert'] = 'invoice/insert';
$route['invoiceUpdateForm/(:num)'] = 'invoice/updateform/$1';
