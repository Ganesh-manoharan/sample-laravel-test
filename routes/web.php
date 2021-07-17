<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['locale'])->group(function () {
        Route::get('/', 'WelcomeController@landing')->name('landing');
        Auth::routes();

        Route::middleware(['auth'])->group(function () {
           //     Route::middleware('twoFactor')->group(function () {
                        Route::middleware(['userpermission'])->group(function () {
                                Route::get('home', 'Dashboard\HomeController@index')->name('home');
                                Route::prefix('manager')->group(function () {

                                        Route::get('task_approval', 'Task\TaskController@task_approval')->name('task_approval');
                                        Route::get('dependency_company/{formType?}', 'Task\TaskController@dependency_companyid');
                                        Route::get('fundgroupby_company', 'Task\TaskController@fundgroupby_companyid');
                                        Route::get('departments_by_clients', 'Task\TaskController@departments_by_clients');
                                        Route::get('subfundby_company', 'Task\TaskController@subfundby_fundid');
                                        Route::get('usersby_department', 'Task\TaskController@usersby_departmentid');
                                        Route::get('fetch_documentsby_type', 'DocumentController@getdocumentby_type');
                                        Route::get('retriveTaskFormDetails/{type?}', 'Task\TaskController@retriveTaskFormDetails')->name('retriveTaskFormDetails');
                                        Route::post('save_taskdetails', 'Task\TaskController@store_taskdetails')->name('savetaskdetails');
                                        Route::post('completion', 'Task\TaskController@update_taskdetails')->name('completion');
                                        Route::post('addTask-validation', 'Task\TaskController@addtask_validation');
                                        Route::post('addTask-stepone-validation', 'Task\TaskController@addtask_stepone_validation');
                                        Route::post('pdf-to-image', 'Task\PDFController@index')->name('pdf-to-image');
                                        Route::get('doc_viewer', 'DocumentController@doc_viewer');
                                        Route::get('list_tasks','DocumentController@list_task_dependent');
                                        Route::get('add_document', 'DocumentController@document_tile');
                                        Route::get('task_documents/{id}', 'Task\TaskDetailController@get_task_documents');
                                        Route::get('awaiting_approval/{type?}', 'Task\TaskController@awaiting_approval')->name('awaiting_approval');
                                        Route::post('form_validation', 'Task\TaskController@form_validation')->name('form_validation');


                                        Route::prefix('teams')->name('teams')->namespace('Teams')->group(function () {
                                                Route::get('/', 'TeamsController@index')->name('');
                                                Route::get('all_users', 'TeamsController@index_all_users')->name('.allusers');
                                                Route::get('department_search', 'TeamsController@department_search')->name('.department_search');
                                                Route::get('user_search', 'TeamsController@user_search')->name('.user_search');
                                                Route::get('department/add', 'DepartmentController@get_data_for_adding_dept')->name('.department_save');
                                                Route::post('department/add', 'DepartmentController@new_department_save')->name('.department_save');
                                                Route::get('department_details/{id}', 'DepartmentController@department_detail')->name('.department_detail');
                                                Route::get('fetchdepartmentdetails/{id}', 'DepartmentController@fetchdepartmentdetails')->name('.fetchdepartmentdetails');
                                                Route::get('deletethesingledepartmentrecord/{id}', 'DepartmentController@deletethesingledepartmentrecord')->name('.deletethesingledepartmentrecord');
                                                Route::get('user/add', 'UserController@add_new_user_show_form')->name('.user_save');
                                                Route::post('user/add', 'UserController@add_new_user')->name('.user_save');
                                                Route::get('user_profile/{id}', 'UserController@user_profile')->name('.user_profile');
                                                Route::delete('delete/departments/user/{id}', 'DepartmentController@delete_department_members')->name('.delete_department_member');
                                                Route::post('update_user_profile/{type}', 'UserController@user_profile_update')->name('update_user_profile');
                                                Route::delete('delete/clients/user/{id}', 'UserController@delete_client_users')->name('.delete_client_user');
                                                Route::get('delete/companyuser/{id}', 'UserController@delete_company_users')->name('.delete_company_user');
                                        });

                                        Route::prefix('clients')->name('clients')->namespace('Clients')->group(function () {
                                                Route::get('/', 'ClientsController@index')->name('');
                                                Route::get('client_search', 'ClientsController@department_client_search')->name('.client_search');
                                                Route::post('clients_add', 'ClientsController@new_clients_save')->name('.client_save');
                                                Route::get('viewclientdetails/{id}', 'ClientsController@viewclientdetails')->name('.viewclientdetails');
                                                Route::get('fetchclientdetails/{id}', 'ClientsController@fetchclientdetails')->name('.fetchclientdetails');
                                                Route::post('adddepartmentassignedvalue', 'ClientsController@adddepartmentassignedvalue')->name('adddepartmentassignedvalue');
                                                Route::post('addfundgroupsassignedvalue', 'ClientsController@addfundgroupsassignedvalue')->name('addfundgroupsassignedvalue');
                                                Route::get('deletedepartmentassignedvalue/{id}', 'ClientsController@deletedepartmentassignedvalue')->name('deletedepartmentassignedvalue');
                                                Route::get('deletefundgroupsassignedvalue/{id}', 'ClientsController@deletefundgroupsassignedvalue')->name('deletefundgroupsassignedvalues');
                                                Route::get('deletethesingleclientrecord/{id}', 'ClientsController@deletethesingleclientrecord')->name('.deletethesingleclientrecord');
                                                Route::get('deletecompany/{id}', 'ClientsController@deletecompany')->name('.deletecompany');
                                        });

                                        Route::prefix('funds')->name('funds')->namespace('Funds')->group(function () {
                                                Route::get('/', 'FundController@funds')->name('');
                                                Route::get('subfunds', 'FundController@index_subfunds')->name('.subfunds');
                                                Route::get('fund_search', 'FundController@fund_search')->name('.fund_search');
                                                Route::post('fund_save', 'FundController@new_funds_save')->name('.fund_save');
                                                Route::get('viewfunddetails/{id}', 'FundController@viewfunddetails')->name('.viewfunddetails');
                                                Route::get('viewsubfunddetails/{id}', 'FundController@viewsubfunddetails')->name('.viewsubfunddetails');
                                                Route::get('edit_funddetails/{id}', 'FundController@edit_funddetails')->name('.edit_funddetails');
                                                Route::get('deletethesinglefundrecord/{id}', 'FundController@deletethesinglefundrecord')->name('.deletethesinglefundrecord');
                                                Route::post('subfund_save', 'FundController@new_sub_funds_save')->name('.sub_fund_save');
                                                Route::get('deletesubfundrecord/{id}', 'FundController@deletesubfundrecord')->name('.deletesubfundrecord');
                                        });

                                        Route::prefix('task')->group(function () {
                                                Route::get('taskdetail/{id}', 'Task\TaskDetailController@taskdetail_index')->name('taskdetail');
                                                Route::get('home/{department_filter?}/{department?}', 'Task\TaskController@index')->name('task');
                                                Route::get('form/{type?}/{department_filter?}/{department?}', 'Task\TaskController@index')->name('task.form');
                                        Route::get('issue/form/{task_id}/{type}', 'Task\TaskController@addtask_index')->name('issue.task.form');
                                                Route::get('addtask/{type?}', 'Task\TaskController@addtask_index')->name('addtask');
                                                Route::get('mis-field/{type}', 'Task\TaskController@mis_field');
                                                Route::get('fetchthetaskdetails/{id}', 'Task\TaskController@fetchtaskdetails');
                                                Route::post('approvetask', 'Task\TaskController@approvetask')->name('approvetask');
                                                Route::post('approveall', 'Task\TaskController@approveall')->name('approveall');
                                                Route::get('mis_results', 'Task\TaskDetailController@mis_result');
                                                Route::get('suggest/{keyword}', 'Task\PDFController@suggest_autocomplete');
                                                Route::get('task-detail/client-popup', 'Task\TaskDetailController@task_detail_client');
                                                Route::get('task-detail/assigned-popup', 'Task\TaskDetailController@task_detail_assigned')->name('task_detail_assigned');
                                                Route::post('store_issues_details', 'Task\TaskDetailController@store_issues_details')->name('store_issues_details');
                                                Route::get('form/{type}', 'task\taskcontroller@index')->name('issueList');
                                                Route::get('taskdetail/edit/{id}', 'Task\TaskController@edittask')->name('taskedit');
                                                Route::post('taskdetail/edit/{id}', 'Task\TaskController@update_task')->name('update_task');
                                                Route::prefix('questionary')->group(function () {
                                                        Route::get('/form_fields/{fieldType}', 'Task\TaskController@generateFormFields')->name('generateFormFields');
                                                        Route::get('/form/workspace', 'Task\TaskController@retriveFormFieldsWorkspace')->name('retriveFormFieldsWorkspace');
                                                        Route::any('formdetails','Task\TaskController@questionnaire_formdetails')->name('task_questionnaire');
                                                        Route::any('fielddetails','Task\TaskController@questionnaire_fieldsdetails')->name('questionnaire_fieldsdetails');
                                                });
                                        });

                                        Route::prefix('reports')->group(function () {
                                                Route::get('/schedule', 'Reports\ReportsController@schedule')->name('report_schedule');
                                                Route::post('create_reports', 'Reports\ReportsController@create_reports')->name('create_reports');
                                                Route::get('viewreportdetails/{id}', 'Reports\ReportsController@viewreportdetails')->name('viewreportdetails');
                                                Route::get('fetchsubcategory', 'Reports\ReportsController@fetchsubcategory')->name('fetchsubcategory');
                                        });
                                        Route::prefix('documents')->group(function () {
                                                Route::get('document_index', 'DocumentController@document_index')->name('document_index');
                                                Route::get('document_create', 'DocumentController@document_create')->name('document_create');
                                                Route::post('document_save', 'DocumentController@document_save')->name('document_save');
                                                Route::get('delete_documents/{id}', 'DocumentController@deletedocuments')->name('delete_documents');
                                        });
                                });

                                Route::prefix('admin')->group(function () {
                                        Route::prefix('reports')->group(function () {
                                                Route::get('/', 'Reports\ReportsController@index')->name('reports');
                                                Route::get('/showreport', 'Reports\ReportsController@jsreport')->name('showreport');
                                        });
                                });

                                Route::get('fetchtags', 'Reports\ReportsController@fetchtags')->name('fetchtags');
                                Route::get('task_dependency_check', 'Task\TaskDetailController@dependency_check');
                                Route::get('mis_validation', 'Task\TaskDetailController@mis_validation');
                                //Route::get('task/task_edit/{id}', 'Task\TaskDetailController@task_edit')->name('taskEdit');
                                Route::get('task/task_reopen/{id}', 'Task\TaskDetailController@task_reopen')->name('taskReopen');
                                Route::get('ftp_documents_index', 'ClientFTPController@ftp_documents_index')->name('ftp_documents_index');
                                Route::post('ftp_document_save', 'ClientFTPController@ftp_document_save')->name('ftp_document_save');



                                // Nexus Admin
                                Route::prefix('admin')->group(function () {
                                        Route::prefix('reports')->group(function () {
                                                Route::get('/', 'Reports\ReportsController@index')->name('reports');
                                        });
                                });
                                Route::get('admin_home', 'AdminController@index')->name('admin_home');
                                Route::post('create_admin', 'AdminController@create_admin')->name('create_admin');
                                Route::get('viewcompanydetails/{id}', 'AdminController@viewcompanydetails')->name('viewcompanydetails');
                                Route::post('addcompany_validation', 'AdminController@addcompany_validation')->name('addcompany_validation');
                        });
            //    });
        });
});
Route::post('update_reports', 'Reports\ReportsController@update_reports')->name('update_reports');
Route::get('delete_reports/{id}', 'Reports\ReportsController@deletereports')->name('deletereports');

Route::get('issues_index', 'IssuesController@issues_dashboard')->name('issues_index');
Route::get('translate/{lang}', 'WelcomeController@translate')->name('translate');
Route::get('indexing_docs', 'Task\PDFController@indexing_docs');
Route::get('chartdata', 'Dashboard\ChartController@chart_data')->name('chart_data');

Route::get('two_factor', 'Auth\TwoFactorController@showTwoFactorForm');
Route::post('two_factor', 'Auth\TwoFactorController@verifyTwoFactor')->name('twofactor');
