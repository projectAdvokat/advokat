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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// login, register, logout
$route['login']['get']    = 'AuthPage/login';
$route['register']['get']    = 'AuthPage/register';
$route['logout']['get'] = 'Api/Auth/logout';
// $route['register'] = '';

$route['api/register']['POST'] = 'AuthPage/regis';

// admin

$route['dashboard/users']['get']      = 'Dashboard/AllUsers';

$route['api/admin/users/(:num)/ban']['post']      = 'Api/admin/ban_user/$1';
$route['api/admin/lawyers/(:num)/verify']['post'] = 'Api/admin/verify_lawyer/$1';
$route['api/admin/articles/(:num)/ban']['post']   = 'Api/admin/ban_article/$1';
$route['api/admin/reports/finance']['get']        = 'Api/admin/reports_finance';

// wallet
$route['api/wallet/(:num)']['get']        = 'Api/Wallet/index/$1';

// Ambil saldo wallet user
$route['api/wallet']['GET'] = 'Api/Wallet/index';

// Ambil ledger (riwayat transaksi) dengan filter ?from=&to=
$route['api/wallet/ledger']['GET'] = 'Api/Wallet/ledger';

// User request payout (marketer/lawyer)
$route['api/wallet/payout-request']['POST'] = 'Api/Wallet/request_payout';

// Admin approve payout
$route['api/wallet/payout/approve']['POST'] = 'Api/Wallet/approve_payout';


// chat
$route['api/chats']['GET'] = 'Api/Chat/index';
$route['api/chats/messages']['POST'] = 'Api/Chat/messages';
$route['chat/booking/(:num)'] = 'ChatPage/index/$1';
// $route['api/chats']['POST'] = 'Api/Chat/create';
$route['api/chats/(:num)/messages']['POST'] = 'Api/Chat/send_messages/$1';



// lawyer
$route['lawyers/list'] = 'LawyerPage/index';
$route['api/lawyers']['GET'] = 'Api/Lawyer/index';
$route['lawyers/booking/(:num)'] = 'LawyerPage/booking/$1';  
// $route['api/lawyers/(:num)']['GET'] = 'Api/Lawyer



// articles

$route['api/articles']['GET'] = 'Api/Articles/index';  
$route['api/articles/create']['POST'] = 'Api/Articles/create';
$route['api/articles/delete/(:any)']['GET'] = 'Api/Articles/delete/$1';
$route['api/articles/show/(:num)']['GET'] = 'Api/Articles/show/$1';
$route['articles/show/(:num)']['GET'] = 'ArticlesPage/show/$1';

$route['dashboard/articles']['GET'] = 'Dashboard/MyArticles';  
$route['dashboard/articles/create']['GET'] = 'Dashboard/create';
$route['dashboard/articles/edit/(:any)']['GET'] = 'Dashboard/get_by_slug/$1';
$route['dashboard/articles/update/(:any)']['POST'] = 'Dashboard/update_article/$1';
$route['articles']['GET'] = 'ArticlesPage/index';  
$route['dashboard/articles/store']['POST'] = 'Dashboard/store';
$route['article/detail/(:num)']['GET'] = 'ArticlesPage/show/$1';  
$route['dashboard/articles/delete/(:any)']['GET'] = 'Dashboard/delete/$1';
$route['dashboard/chats']['GET'] = 'Dashboard/chats';
$route['dashboard/profile']['GET'] = 'Profile/index';
$route['dashboard/wallet/(:num)']['GET'] = 'Wallet/index/$1';

// dashboard    
$route['booking/xendit_webhook'] = 'api/booking/xendit_webhook';
$route['booking/check_payment_status/(:any)'] = 'booking/check_payment_status/$1';
$route['dashboard'] = 'Dashboard/index';


$route['dashboard/booking'] = 'Dashboard/booking';
$route['booking/success'] = 'Api/Booking/success';

