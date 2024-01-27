<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->get('/', 'Home::index');
$routes->get('/admin', 'Auth::index');
$routes->get('/auth/login', 'Auth::login');
$routes->post('/auth/login', 'Auth::login');

$routes->get('/auth/logout', 'Auth::logout');
$routes->get('/auth/checksession', 'Auth::check_session');


$routes->get('/admin/permission_denied', 'Admin\PagePermission::denied');

$routes->get('/admin/dashboard', 'Admin\Dashboard::index');
$routes->get('/admin/dashboard/dashboard2', 'Admin\Dashboard::dashboard2');
$routes->get('/admin/dashboard/dashboard3', 'Admin\Dashboard::dashboard3');
$routes->get('/admin/dashboard/dashboard4', 'Admin\Dashboard::dashboard4');

// $routes->get('/admin/user', 'Admin\Dashboard::index');


// $route[ADMIN.'user/add'] = ADMIN."HWT_User/showForm";
// $route[ADMIN.'user/edit/(:any)'] = ADMIN."HWT_User/showForm/$1";
// $route[ADMIN.'user/save'] = ADMIN."HWT_User/save";
// $route[ADMIN.'user/view/(:any)'] = ADMIN."HWT_User/view/$1";

/* User */
/*Phrases*/

$routes->get('/admin/users/', 'Admin\UserController::index');
$routes->post('/admin/users/ajax_list/', 'Admin\UserController::ajax_list');
$routes->get('/admin/users/add/', 'Admin\UserController::add');
$routes->get('/admin/users/edit/(:any)', 'Admin\UserController::add/$1');
$routes->post('/admin/users/store/', 'Admin\UserController::store');
$routes->post('/admin/users/delete/', 'Admin\UserController::delete');
$routes->post('/admin/users/status/', 'Admin\UserController::status');

$routes->get('/admin/classes/', 'Admin\ClassesController::index');
$routes->post('/admin/classes/ajax_list/', 'Admin\ClassesController::ajax_list');
$routes->get('/admin/classes/add/', 'Admin\ClassesController::add');
$routes->get('/admin/classes/edit/(:any)', 'Admin\ClassesController::add/$1');
$routes->post('/admin/classes/store/', 'Admin\ClassesController::store');
$routes->post('/admin/classes/delete/', 'Admin\ClassesController::delete');
$routes->post('/admin/classes/status/', 'Admin\ClassesController::status');

$routes->get('/admin/schedule/', 'Admin\ScheduleController::index');
$routes->post('/admin/schedule/ajax_list/', 'Admin\ScheduleController::ajax_list');
$routes->get('/admin/schedule/add/', 'Admin\ScheduleController::add');
$routes->get('/admin/schedule/edit/(:any)', 'Admin\ScheduleController::add/$1');
$routes->post('/admin/schedule/store/', 'Admin\ScheduleController::store');
$routes->post('/admin/schedule/delete/', 'Admin\ScheduleController::delete');
$routes->post('/admin/schedule/status/', 'Admin\ScheduleController::status');













$routes->get('/admin/manageuser', 'Admin\ManageUser::index');

$routes->get('/admin/manageuser/user_list', 'Admin\ManageUser::userList');
$routes->get('/admin/manageuser/user_delete/(:any)', 'Admin\ManageUser::userDelete/$1');
$routes->get('/admin/manageuser/user_change_status', 'Admin\ManageUser::userStatusMod');
$routes->get('/admin/manageuser/user_add', 'Admin\ManageUser::userAdd');
$routes->post('/admin/manageuser/user_add', 'Admin\ManageUser::userAdd');
$routes->get('/admin/manageuser/user_edit/(:any)', 'Admin\ManageUser::userEdit/$1');
$routes->post('/admin/manageuser/user_edit/(:any)', 'Admin\ManageUser::userEdit/$1');



/*QA Form */
$routes->get('/admin/qa_form/', 'Admin\QA_Campain_Form::index');
$routes->get('/admin/qa_form/(:segment)', 'Admin\QA_Campain_Form::index/$1');
$routes->post('/admin/qa_form/submit/', 'Admin\QA_Campain_Form::qa_submit');
$routes->get('/admin/qa_form/delete/(:num)/', 'Admin\QA_Campain_Form::qa_delete/$1');
$routes->get('/admin/qa_form/edit/(:num)/', 'Admin\QA_Campain_Form::edit/$1');
$routes->post('/admin/qa_form/edit_save/', 'Admin\QA_Campain_Form::edit_save');



/*QA*/
$routes->get('/admin/qa/', 'Admin\QA::index');
$routes->get('/admin/qa/add/', 'Admin\QA::add');
$routes->post('/admin/qa/save/', 'Admin\QA::save');
$routes->get('/admin/qa/edit/(:num)', 'Admin\QA::edit/$1');
$routes->post('/admin/qa/save_qa/', 'Admin\QA::save_qa');
$routes->post('/admin/qa/save_edit/', 'Admin\QA::save_edit');
$routes->post('/admin/qa/sending_email/', 'Admin\QA::sending_email');
$routes->get('/admin/qa/sending_test_email/', 'Admin\QA::sending_test_email');
$routes->post('/admin/qa/secound_opinion/', 'Admin\QA::secound_opinion');

/*Phrases*/

$routes->get('/admin/phrases/', 'Admin\Phrases::index');
$routes->get('/admin/phrases/add/', 'Admin\Phrases::add');
$routes->get('/admin/phrases/edit/(:any)', 'Admin\Phrases::add/$1');
$routes->post('/admin/phrases/save/', 'Admin\Phrases::save');
$routes->post('/admin/phrases/delete/', 'Admin\Phrases::delete');

//Questions Route
$routes->get('/admin/questions', 'Admin\Questions::index');
$routes->get('/admin/questions/create', 'Admin\Questions::create');
$routes->post('/admin/questions', 'Admin\Questions::store');
$routes->get('/admin/questions/(:num)/edit', 'Admin\Questions::edit/$1');
$routes->post('/admin/questions/(:num)', 'Admin\Questions::update/$1');
$routes->post('/admin/questions/delete/(:num)', 'Admin\Questions::delete/$1');

//Call Log Route
$routes->get('/admin/call-log/import', 'Admin\CallLogController::import');
$routes->post('/admin/call-log/import', 'Admin\CallLogController::import_store');
$routes->get('/admin/call-log/upload', 'Admin\CallLogController::upload');
$routes->post('/admin/call-log/upload', 'Admin\CallLogController::upload_store');
$routes->get('/call-log/import', 'Cron\CallLogController::import_store');

//QA Route
$routes->get('/admin/qa/review', 'Admin\QA::review');
$routes->get('/admin/qa/review/(:num)', 'Admin\QA::response/$1');
$routes->post('/admin/qa/review/(:num)', 'Admin\QA::response_store/$1');

//CC
$routes->get('/admin/purge-cc', 'Admin\TranscriptionController::purge_cc');