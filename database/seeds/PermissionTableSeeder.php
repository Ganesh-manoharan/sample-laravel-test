<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        
        DB::table('permission')->truncate();
        $data = array(
            array('key' => 'home_page', 'controller' => 'HomeController', 'method' => 'index', 'description' => 'User home page', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'task_approval', 'controller' => 'TaskController', 'method' => 'task_approval', 'description' => 'approve the task', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'dependency_company', 'controller' => 'TaskController', 'method' => 'dependency_companyid', 'description' => 'select the dependancy task based on the client selection', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'fundgroupby_selectionbycompanyid', 'controller' => 'TaskController', 'method' => 'fundgroupby_companyid', 'description' => 'show the fundgroup dropdown based on company selection', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'Departments_by_clients', 'controller' => 'TaskController', 'method' => 'departments_by_clients', 'description' => 'Department list for selected clients', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'subfundgroupby_selectionbyfundgroupid', 'controller' => 'TaskController', 'method' => 'subfundby_fundid', 'description' => 'show the subfundgroup dropdown based on fundgroup selection', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'usersby_department', 'controller' => 'TaskController', 'method' => 'usersby_departmentid', 'description' => 'show the regulatory grouping dropdown based on users selection', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'fetch_documentsby_type', 'controller' => 'DocumentController', 'method' => 'getdocumentby_type', 'description' => 'fetch the document type based on keyword', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'saving_task', 'controller' => 'TaskController', 'method' => 'store_taskdetails', 'description' => 'Saving the task into database', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'task approval', 'controller' => 'TaskController', 'method' => 'update_taskdetails', 'description' => 'complete the task', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'addTask-validation', 'controller' => 'TaskController', 'method' => 'addtask_validation', 'description' => 'add the validations to the task creation1 & 2', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'addtask_stepone_validation', 'controller' => 'TaskController', 'method' => 'addtask_stepone_validation', 'description' => 'step validations', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'index_docs_to_apache', 'controller' => 'PDFController', 'method' => 'index', 'description' => 'Indexing the documents into apache solr', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'View_documents', 'controller' => 'DocumentController', 'method' => 'doc_viewer', 'description' => 'Viewing the documents by using the PDFTron', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'add_document_tile', 'controller' => 'DocumentController', 'method' => 'document_tile', 'description' => 'Adding the document tile on the task creation step#2', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'Task_Docuemnts', 'controller' => 'TaskDetailController', 'method' => 'get_task_documents', 'description' => 'Fetching the documents for the particular task', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'awaiting_approval', 'controller' => 'TaskController', 'method' => 'awaiting_approval', 'description' => 'page redirection to awaiting approval form', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'teams', 'controller' => 'TeamsController', 'method' => 'index', 'description' => 'show the teams page', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'indexallusers', 'controller' => 'TeamsController', 'method' => 'index_all_users', 'description' => 'index the all the users', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'search the department', 'controller' => 'TeamsController', 'method' => 'department_search', 'description' => 'search the departments', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'search the users', 'controller' => 'TeamsController', 'method' => 'user_search', 'description' => 'search the users', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'adding_department', 'controller' => 'DepartmentController', 'method' => 'get_data_for_adding_dept', 'description' => 'add departments1', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'save_new_department', 'controller' => 'DepartmentController', 'method' => 'new_department_save', 'description' => 'add departments2', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'department_details', 'controller' => 'DepartmentController', 'method' => 'department_detail', 'description' => 'department details', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'fetch_department_details', 'controller' => 'DepartmentController', 'method' => 'fetchdepartmentdetails', 'description' => 'fetch department details in popup', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'deletethesingledepartmentrecord', 'controller' => 'DepartmentController', 'method' => 'deletethesingledepartmentrecord', 'description' => 'delete the department records', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'add_new_user_show_form', 'controller' => 'UserController', 'method' => 'add_new_user_show_form', 'description' => 'Add New User', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'save_users', 'controller' => 'UserController', 'method' => 'add_new_user', 'description' => 'Add New User', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'user_profile', 'controller' => 'UserController', 'method' => 'user_profile', 'description' => 'add new user profile', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'delete_department_members', 'controller' => 'DepartmentController', 'method' => 'delete_department_members', 'description' => 'delete user profile', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'update_user_profile', 'controller' => 'UserController', 'method' => 'user_profile_update', 'description' => 'update user profile', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'clients', 'controller' => 'ClientsController', 'method' => 'index', 'description' => 'show the client page', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'seaarch_department_in_clients', 'controller' => 'ClientsController', 'method' => 'department_client_search', 'description' => 'Search department based on show the clients', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'save_clientdetails', 'controller' => 'ClientsController', 'method' => 'new_clients_save', 'description' => 'Save the client details', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'view_clientdetails', 'controller' => 'ClientsController', 'method' => 'viewclientdetails', 'description' => 'view the client details', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'fetchclientdetails', 'controller' => 'ClientsController', 'method' => 'fetchclientdetails', 'description' => 'fetch the client details', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'adddepartmentsassignvalue', 'controller' => 'ClientsController', 'method' => 'adddepartmentassignedvalue', 'description' => 'departments assign to the clients', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'addfundgroupsassignedvalue', 'controller' => 'ClientsController', 'method' => 'addfundgroupsassignedvalue', 'description' => 'fundgroups assign to the clients', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'deletedepartmentassignedvalue', 'controller' => 'ClientsController', 'method' => 'deletedepartmentassignedvalue', 'description' => 'delete the departments assigned to the clients', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'deletefundgroupsassignedvalue', 'controller' => 'ClientsController', 'method' => 'deletefundgroupsassignedvalue', 'description' => 'delete the fundgroups assigned to the clients', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'deletethesingleclientrecord', 'controller' => 'ClientsController', 'method' => 'deletethesingleclientrecord', 'description' => 'delete the single client records', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'delete client user', 'controller' => 'UserController', 'method' => 'delete_client_users', 'description' => 'delete the user from clients', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'funds_index', 'controller' => 'FundController', 'method' => 'funds', 'description' => 'show the funds page', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'search the funds', 'controller' => 'FundController', 'method' => 'fund_search', 'description' => 'search the funds', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'Insertion & updations of Fund groups', 'controller' => 'FundController', 'method' => 'new_funds_save', 'description' => 'edit and updations of fundgroups', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'View_Fund_details', 'controller' => 'FundController', 'method' => 'viewfunddetails', 'description' => 'view fund details', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'Edit_Fund_details', 'controller' => 'FundController', 'method' => 'edit_funddetails', 'description' => 'edit fund details', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'deletethesinglefundrecord', 'controller' => 'FundController', 'method' => 'deletethesinglefundrecord', 'description' => 'delete the single fund records', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'task_detail_page', 'controller' => 'TaskDetailController', 'method' => 'taskdetail_index', 'description' => 'Task detail page', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'task_home', 'controller' => 'TaskController', 'method' => 'index', 'description' => 'Displaying list of task and statistics on task home page', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'task_create_form', 'controller' => 'TaskController', 'method' => 'addtask_index', 'description' => 'Task creation pages step#1 and step#2', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'fetchtaskdetails', 'controller' => 'TaskController', 'method' => 'fetchtaskdetails', 'description' => 'Fetch task details', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'approvetask', 'controller' => 'TaskController', 'method' => 'approvetask', 'description' => 'Approve the task details', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'approve_all', 'controller' => 'TaskController', 'method' => 'approveall', 'description' => 'Approve All', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'mis_results', 'controller' => 'TaskDetailController', 'method' => 'mis_result', 'description' => 'add mis results for admin', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'search_keywords', 'controller' => 'PDFController', 'method' => 'suggest_autocomplete', 'description' => 'auto complete the search keyword', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'task_detail_client_popup', 'controller' => 'TaskDetailController', 'method' => 'task_detail_client', 'description' => 'add taskdetails using popup modal', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'task_detail_assigned_popup', 'controller' => 'TaskDetailController', 'method' => 'task_detail_assigned', 'description' => 'task detail assigned in popup', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'store_issues_details', 'controller' => 'TaskDetailController', 'method' => 'store_issues_details', 'description' => 'store issue details to database', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'task_dependency_check', 'controller' => 'TaskDetailController', 'method' => 'dependency_check', 'description' => 'Check dependency task for a partiuclar task', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'mis_validation', 'controller' => 'TaskDetailController', 'method' => 'mis_validation', 'description' => 'Validate the MIS result against to the user', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'mis_field', 'controller' => 'TaskController', 'method' => 'mis_field', 'description' => 'add the mis fields', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'task_edit', 'controller' => 'TaskDetailController', 'method' => 'task_edit', 'description' => 'Edit the task', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'task_reopen', 'controller' => 'TaskDetailController', 'method' => 'task_reopen', 'description' => 'Reopen a completed task', 'created_at' => now(), 'updated_at' => now()),

            array('key' => 'Insertion & updations of Sub Fund groups', 'controller' => 'FundController', 'method' => 'new_sub_funds_save', 'description' => 'edit and updations of subfund', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'indexSubfunds', 'controller' => 'FundController', 'method' => 'index_subfunds', 'description' => 'index the all subfunds', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'View_Sub_Fund_details', 'controller' => 'FundController', 'method' => 'viewsubfunddetails', 'description' => 'view sub fund details', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'Delete_Sub_Fund_Record', 'controller' => 'FundController', 'method' => 'deletesubfundrecord', 'description' => 'delete the single sub fund records', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'report_generate', 'controller' => 'ReportsController', 'method' => 'index', 'description' => 'to generate report templates', 'created_at' => now(), 'updated_at' => now()),

            array('key' => 'documents_index', 'controller' => 'DocumentController', 'method' => 'document_index', 'description' => 'List the documents for the company', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'documents_create', 'controller' => 'DocumentController', 'method' => 'document_create', 'description' => 'Show the documents uploading form', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'documents_save', 'controller' => 'DocumentController', 'method' => 'document_save', 'description' => 'Saving the documents', 'created_at' => now(), 'updated_at' => now()),

            array('key' => 'ftp_documents_index', 'controller' => 'ClientFTPController', 'method' => 'ftp_documents_index', 'description' => 'Listing the documents', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'ftp_documents_save', 'controller' => 'ClientFTPController', 'method' => 'ftp_document_save', 'description' => 'Listing the documents', 'created_at' => now(), 'updated_at' => now()),

            array('key' => 'company_index', 'controller' => 'AdminController', 'method' => 'index', 'description' => 'Listing the company for Nexus admin', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'create_admin', 'controller' => 'AdminController', 'method' => 'create_admin', 'description' => 'Creating the Company', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'report_schedule', 'controller' => 'ReportsController', 'method' => 'schedule', 'description' => 'scheduling the reports for their company', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'create_reports', 'controller' => 'ReportsController', 'method' => 'create_reports', 'description' => 'store the report information to database', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'view_reports', 'controller' => 'ReportsController', 'method' => 'viewreportdetails', 'description' => 'view reports details', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'update_reports', 'controller' => 'ReportsController', 'method' => 'update_reports', 'description' => 'update the reports details', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'delete_reports', 'controller' => 'ReportsController', 'method' => 'deletereports', 'description' => 'delete the reports details', 'created_at' => now(), 'updated_at' => now()),
            array('key' => 'delete_clients', 'controller' => 'ClientsController', 'method' => 'deletethesingleclientrecord', 'description' => 'delete client records', 'created_at' => now(), 'updated_at' => now()),
	    array('key'=>'fetchsubcategory','controller'=>'ReportsController','method'=>'fetchsubcategory','description'=>'fetchsubcategory','created_at'=>now(),'updated_at'=>now()),
	    array('key'=>'fetchtags','controller'=>'ReportsController','method'=>'fetchtags','description'=>'fetch tags details','created_at'=>now(),'updated_at'=>now()),
        array('key'=>'delete_documents','controller'=>'DocumentController','method'=>'deletedocuments','description'=>'delete documents','created_at'=>now(),'updated_at'=>now())

        );
        DB::table('permission')->insert($data);
        DB::statement("SET foreign_key_checks=1");
    }
}
