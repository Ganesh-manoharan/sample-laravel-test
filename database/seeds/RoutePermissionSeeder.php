<?php

use App\Roles;
use App\Permission;
use App\PermissionRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoutePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        Permission::truncate();
        
        PermissionRole::truncate();
        $permissionData=array(
            [
                'key'=>'retriveTaskFormDetails',
                'controller'=>'TaskController',
                'method'=>'retriveTaskFormDetails',
                'description'=>'To retrive the Task Details based on the request input',
                'role'=>['System Admin','Basic User','Review User','Department Admin']
            ],
            [
                'key'=>'issue.task.form',
                'controller'=>'TaskController',
                'method'=>'addtask_index',
                'description'=>'To create the Issue Task Details based on the request input',
                'role'=>['System Admin','Department Admin']

            ],
            [
                'key'=>'taskedit',
                'controller'=>'TaskController',
                'method'=>'edittask',
                'description'=>'To edit the Task Details based on the request input',
                'role'=>['System Admin', 'Department Admin']

            ],
            [
                'key'=>'update_task',
                'controller'=>'TaskController',
                'method'=>'update_task',
                'description'=>'To update the Task Details based on the request input',
                'role'=>['System Admin','Department Admin']

            ],
	    
	      [
                'key'=>'deletecompany',
                'controller'=>'ClientsController',
                'method'=>'deletecompany',
                'description'=>'delete the company records',
                'role'=>['Admin']

          ], ['key' => 'home_page', 'controller' => 'HomeController', 'method' => 'index', 'description' => 'User home page', 'role'=>['System Admin','Basic User','Review User']],
          ['key' => 'task_approval', 'controller' => 'TaskController', 'method' => 'task_approval', 'description' => 'approve the task', 'role'=>['System Admin','Department Admin','Review User','Basic User']],
          ['key' => 'dependency_company', 'controller' => 'TaskController', 'method' => 'dependency_companyid', 'description' => 'select the dependancy task based on the client selection', 'role'=>['System Admin','Basic User','Review User','Department Admin']],
          ['key' => 'fundgroupby_selectionbycompanyid', 'controller' => 'TaskController', 'method' => 'fundgroupby_companyid', 'description' => 'show the fundgroup dropdown based on company selection', 'role'=>['System Admin','Basic User','Review User','Department Admin']],
          ['key' => 'Departments_by_clients', 'controller' => 'TaskController', 'method' => 'departments_by_clients', 'description' => 'Department list for selected clients', 'role'=>['System Admin','Basic User','Review User','Department Admin']],
          ['key' => 'subfundgroupby_selectionbyfundgroupid', 'controller' => 'TaskController', 'method' => 'subfundby_fundid', 'description' => 'show the subfundgroup dropdown based on fundgroup selection', 'role'=>['System Admin']],
          ['key' => 'usersby_department', 'controller' => 'TaskController', 'method' => 'usersby_departmentid', 'description' => 'show the regulatory grouping dropdown based on users selection', 'role'=>['System Admin','Basic User','Review User','Department Admin']],
          ['key' => 'fetch_documentsby_type', 'controller' => 'DocumentController', 'method' => 'getdocumentby_type', 'description' => 'fetch the document type based on keyword', 'role'=>['System Admin']],
          ['key' => 'saving_task', 'controller' => 'TaskController', 'method' => 'store_taskdetails', 'description' => 'Saving the task into database', 'role'=>['System Admin','Department Admin']],
          ['key' => 'task approval', 'controller' => 'TaskController', 'method' => 'update_taskdetails', 'description' => 'complete the task', 'role'=>['System Admin','Review User','Basic User']],
          ['key' => 'addTask-validation', 'controller' => 'TaskController', 'method' => 'addtask_validation', 'description' => 'add the validations to the task creation1 & 2', 'role'=>['System Admin']],
          ['key' => 'addtask_stepone_validation', 'controller' => 'TaskController', 'method' => 'addtask_stepone_validation', 'description' => 'step validations', 'role'=>['System Admin']],
          ['key' => 'index_docs_to_apache', 'controller' => 'PDFController', 'method' => 'index', 'description' => 'Indexing the documents into apache solr', 'role'=>['System Admin']],
          ['key' => 'View_documents', 'controller' => 'DocumentController', 'method' => 'doc_viewer', 'description' => 'Viewing the documents by using the PDFTron', 'role'=>['System Admin','Review User','Basic User','Client User']],
          ['key' => 'list_tasks', 'controller' => 'DocumentController', 'method' => 'list_task_dependent', 'description' => 'list_documents', 'role'=>['System Admin']],
          ['key' => 'add_document_tile', 'controller' => 'DocumentController', 'method' => 'document_tile', 'description' => 'Adding the document tile on the task creation step#2', 'role'=>['System Admin','Review User','Basic User']],
          ['key' => 'Task_Docuemnts', 'controller' => 'TaskDetailController', 'method' => 'get_task_documents', 'description' => 'Fetching the documents for the particular task', 'role'=>['System Admin','Review User','Basic User']],
          ['key' => 'awaiting_approval', 'controller' => 'TaskController', 'method' => 'awaiting_approval', 'description' => 'page redirection to awaiting approval form', 'role'=>['System Admin','Review User','Basic User']],
          ['key' => 'teams', 'controller' => 'TeamsController', 'method' => 'index', 'description' => 'show the teams page', 'role'=>['System Admin','Review User','Basic User']],
          ['key' => 'indexallusers', 'controller' => 'TeamsController', 'method' => 'index_all_users', 'description' => 'index the all the users', 'role'=>['System Admin','Review User','Basic User']],
          ['key' => 'search the department', 'controller' => 'TeamsController', 'method' => 'department_search', 'description' => 'search the departments', 'role'=>['System Admin','Review User','Basic User']],
          ['key' => 'search the users', 'controller' => 'TeamsController', 'method' => 'user_search', 'description' => 'search the users', 'role'=>['System Admin','Review User','Basic User']],
          ['key' => 'adding_department', 'controller' => 'DepartmentController', 'method' => 'get_data_for_adding_dept', 'description' => 'add departments1', 'role'=>['System Admin']],
          ['key' => 'save_new_department', 'controller' => 'DepartmentController', 'method' => 'new_department_save', 'description' => 'add departments2', 'role'=>['System Admin']],
          ['key' => 'department_details', 'controller' => 'DepartmentController', 'method' => 'department_detail', 'description' => 'department details', 'role'=>['System Admin','Review User','Basic User']],
          ['key' => 'fetch_department_details', 'controller' => 'DepartmentController', 'method' => 'fetchdepartmentdetails', 'description' => 'fetch department details in popup', 'role'=>['System Admin']],
          ['key' => 'deletethesingledepartmentrecord', 'controller' => 'DepartmentController', 'method' => 'deletethesingledepartmentrecord', 'description' => 'delete the department records', 'role'=>['System Admin']],
          ['key' => 'add_new_user_show_form', 'controller' => 'UserController', 'method' => 'add_new_user_show_form', 'description' => 'Add New User', 'role'=>['System Admin']],
          ['key' => 'save_users', 'controller' => 'UserController', 'method' => 'add_new_user', 'description' => 'Add New User', 'role'=>['System Admin']],
          ['key' => 'user_profile', 'controller' => 'UserController', 'method' => 'user_profile', 'description' => 'add new user profile', 'role'=>['System Admin','Review User','Basic User']],
          ['key' => 'delete_department_members', 'controller' => 'DepartmentController', 'method' => 'delete_department_members', 'description' => 'delete user profile', 'role'=>['System Admin']],
          ['key' => 'update_user_profile', 'controller' => 'UserController', 'method' => 'user_profile_update', 'description' => 'update user profile', 'role'=>['System Admin']],
          ['key' => 'clients', 'controller' => 'ClientsController', 'method' => 'index', 'description' => 'show the client page', 'role'=>['System Admin','Review User','Basic User']],
          ['key' => 'seaarch_department_in_clients', 'controller' => 'ClientsController', 'method' => 'department_client_search', 'description' => 'Search department based on show the clients', 'role'=>['System Admin','Review User','Basic User']],
          ['key' => 'save_clientdetails', 'controller' => 'ClientsController', 'method' => 'new_clients_save', 'description' => 'Save the client details', 'role'=>['System Admin']],
          ['key' => 'view_clientdetails', 'controller' => 'ClientsController', 'method' => 'viewclientdetails', 'description' => 'view the client details', 'role'=>['System Admin','Review User','Basic User']],
          ['key' => 'fetchclientdetails', 'controller' => 'ClientsController', 'method' => 'fetchclientdetails', 'description' => 'fetch the client details', 'role'=>['System Admin']],
          ['key' => 'adddepartmentsassignvalue', 'controller' => 'ClientsController', 'method' => 'adddepartmentassignedvalue', 'description' => 'departments assign to the clients', 'role'=>['System Admin']],
          ['key' => 'addfundgroupsassignedvalue', 'controller' => 'ClientsController', 'method' => 'addfundgroupsassignedvalue', 'description' => 'fundgroups assign to the clients', 'role'=>['System Admin']],
          ['key' => 'deletedepartmentassignedvalue', 'controller' => 'ClientsController', 'method' => 'deletedepartmentassignedvalue', 'description' => 'delete the departments assigned to the clients', 'role'=>['System Admin']],
          ['key' => 'deletefundgroupsassignedvalue', 'controller' => 'ClientsController', 'method' => 'deletefundgroupsassignedvalue', 'description' => 'delete the fundgroups assigned to the clients', 'role'=>['System Admin']],
          ['key' => 'deletethesingleclientrecord', 'controller' => 'ClientsController', 'method' => 'deletethesingleclientrecord', 'description' => 'delete the single client records', 'role'=>['System Admin']],
          ['key' => 'delete client user', 'controller' => 'UserController', 'method' => 'delete_client_users', 'description' => 'delete the user from clients', 'role'=>['System Admin']],
          ['key' => 'funds_index', 'controller' => 'FundController', 'method' => 'funds', 'description' => 'show the funds page', 'role'=>['System Admin','Review User','Basic User']],
          ['key' => 'search the funds', 'controller' => 'FundController', 'method' => 'fund_search', 'description' => 'search the funds', 'role'=>['System Admin','Review User','Basic User']],
          ['key' => 'Insertion & updations of Fund groups', 'controller' => 'FundController', 'method' => 'new_funds_save', 'description' => 'edit and updations of fundgroups', 'role'=>['System Admin']],
          ['key' => 'View_Fund_details', 'controller' => 'FundController', 'method' => 'viewfunddetails', 'description' => 'view fund details', 'role'=>['System Admin','Review User','Basic User']],
          ['key' => 'Edit_Fund_details', 'controller' => 'FundController', 'method' => 'edit_funddetails', 'description' => 'edit fund details', 'role'=>['System Admin']],
          ['key' => 'deletethesinglefundrecord', 'controller' => 'FundController', 'method' => 'deletethesinglefundrecord', 'description' => 'delete the single fund records', 'role'=>['System Admin']],
          ['key' => 'task_detail_page', 'controller' => 'TaskDetailController', 'method' => 'taskdetail_index', 'description' => 'Task detail page', 'role'=>['System Admin','Review User','Basic User']],
          ['key' => 'task_home', 'controller' => 'TaskController', 'method' => 'index', 'description' => 'Displaying list of task and statistics on task home page', 'role'=>['System Admin','Review User','Basic User']],
          ['key' => 'task_create_form', 'controller' => 'TaskController', 'method' => 'addtask_index', 'description' => 'Task creation pages step#1 and step#2', 'role'=>['System Admin']],
          ['key' => 'fetchtaskdetails', 'controller' => 'TaskController', 'method' => 'fetchtaskdetails', 'description' => 'Fetch task details', 'role'=>['System Admin','Review User','Basic User']],
          ['key' => 'approvetask', 'controller' => 'TaskController', 'method' => 'approvetask', 'description' => 'Approve the task details', 'role'=>['System Admin','Review User','Department Admin']],
          ['key' => 'approve_all', 'controller' => 'TaskController', 'method' => 'approveall', 'description' => 'Approve All', 'role'=>['System Admin','Review User','Department Admin']],
          ['key' => 'mis_results', 'controller' => 'TaskDetailController', 'method' => 'mis_result', 'description' => 'add mis results for admin', 'role'=>['System Admin','Review User','Basic User']],
          ['key' => 'search_keywords', 'controller' => 'PDFController', 'method' => 'suggest_autocomplete', 'description' => 'auto complete the search keyword', 'role'=>['System Admin','Review User','Basic User']],
          ['key' => 'task_detail_client_popup', 'controller' => 'TaskDetailController', 'method' => 'task_detail_client', 'description' => 'add taskdetails using popup modal', 'role'=>['System Admin','Review User','Basic User']],
          ['key' => 'task_detail_assigned_popup', 'controller' => 'TaskDetailController', 'method' => 'task_detail_assigned', 'description' => 'task detail assigned in popup', 'role'=>['System Admin','Review User','Basic User']],
          ['key' => 'store_issues_details', 'controller' => 'TaskDetailController', 'method' => 'store_issues_details', 'description' => 'store issue details to database', 'role'=>['System Admin']],
          ['key' => 'task_dependency_check', 'controller' => 'TaskDetailController', 'method' => 'dependency_check', 'description' => 'Check dependency task for a partiuclar task', 'role'=>['System Admin','Review User','Basic User']],
          ['key' => 'mis_validation', 'controller' => 'TaskDetailController', 'method' => 'mis_validation', 'description' => 'Validate the MIS result against to the user', 'role'=>['System Admin','Review User','Basic User']],
          ['key' => 'mis_field', 'controller' => 'TaskController', 'method' => 'mis_field', 'description' => 'add the mis fields', 'role'=>['System Admin','Department Admin']],
          ['key' => 'task_edit', 'controller' => 'TaskDetailController', 'method' => 'task_edit', 'description' => 'Edit the task', 'role'=>['System Admin','Department Admin']],
          ['key' => 'task_reopen', 'controller' => 'TaskDetailController', 'method' => 'task_reopen', 'description' => 'Reopen a completed task', 'role'=>['System Admin','Department Admin']],

          ['key' => 'Insertion & updations of Sub Fund groups', 'controller' => 'FundController', 'method' => 'new_sub_funds_save', 'description' => 'edit and updations of subfund', 'role'=>['System Admin']],
          ['key' => 'indexSubfunds', 'controller' => 'FundController', 'method' => 'index_subfunds', 'description' => 'index the all subfunds', 'role'=>['System Admin','Review User','Basic User']],
          ['key' => 'View_Sub_Fund_details', 'controller' => 'FundController', 'method' => 'viewsubfunddetails', 'description' => 'view sub fund details', 'role'=>['System Admin','Review User','Basic User']],
          ['key' => 'Delete_Sub_Fund_Record', 'controller' => 'FundController', 'method' => 'deletesubfundrecord', 'description' => 'delete the single sub fund records', 'role'=>['System Admin']],
          ['key' => 'report_generate', 'controller' => 'ReportsController', 'method' => 'index', 'description' => 'to generate report templates', 'role'=>['Admin']],

          ['key' => 'documents_index', 'controller' => 'DocumentController', 'method' => 'document_index', 'description' => 'List the documents for the company', 'role'=>['System Admin','Client User']],
          ['key' => 'documents_create', 'controller' => 'DocumentController', 'method' => 'document_create', 'description' => 'Show the documents uploading form', 'role'=>['System Admin','Client User']],
          ['key' => 'documents_save', 'controller' => 'DocumentController', 'method' => 'document_save', 'description' => 'Saving the documents', 'role'=>['System Admin','Client User']],

          ['key' => 'ftp_documents_index', 'controller' => 'ClientFTPController', 'method' => 'ftp_documents_index', 'description' => 'Listing the documents', 'role'=>['Client User']],
          ['key' => 'ftp_documents_save', 'controller' => 'ClientFTPController', 'method' => 'ftp_document_save', 'description' => 'Listing the documents', 'role'=>['Client User']],

          ['key' => 'company_index', 'controller' => 'AdminController', 'method' => 'index', 'description' => 'Listing the company for Nexus admin', 'role'=>['Admin']],
          ['key' => 'create_admin', 'controller' => 'AdminController', 'method' => 'create_admin', 'description' => 'Creating the Company', 'role'=>['Admin']],
          ['key' => 'report_schedule', 'controller' => 'ReportsController', 'method' => 'schedule', 'description' => 'scheduling the reports for their company', 'role'=>['System Admin']],
          ['key' => 'create_reports', 'controller' => 'ReportsController', 'method' => 'create_reports', 'description' => 'store the report information to database', 'role'=>['System Admin']],
          ['key' => 'view_reports', 'controller' => 'ReportsController', 'method' => 'viewreportdetails', 'description' => 'view reports details', 'role'=>['System Admin']],

          ['key' => 'update_reports', 'controller' => 'ReportsController', 'method' => 'update_reports', 'description' => 'update the reports details', 'role'=>['System Admin']],
          ['key' => 'delete_reports', 'controller' => 'ReportsController', 'method' => 'deletereports', 'description' => 'delete the reports details', 'role'=>['System Admin']],
          ['key' => 'delete_clients', 'controller' => 'ClientsController', 'method' => 'deletethesingleclientrecord', 'description' => 'delete client records', 'role'=>['System Admin']],
      ['key'=>'fetchsubcategory','controller'=>'ReportsController','method'=>'fetchsubcategory','description'=>'fetchsubcategory','role'=>['System Admin','Review User','Basic User']],
      ['key'=>'fetchtags','controller'=>'ReportsController','method'=>'fetchtags','description'=>'fetch tags details','role'=>['System Admin','Review User','Basic User']],
      ['key'=>'delete_documents','controller'=>'DocumentController','method'=>'deletedocuments','description'=>'delete documents','role'=>['System Admin']],
      ['key'=>'deletecompany','controller'=>'ClientsController','method'=>'deletecompany','description'=>'delete company','role'=>['Admin']],
      ['key'=>'viewcompanydetails','controller'=>'AdminController','method'=>'viewcompanydetails','description'=>'View Company details','role'=>['Admin']],
      ['key'=>'addcompany_validation','controller'=>'AdminController','method'=>'addcompany_validation','description'=>'add the company validation','role'=>['Admin']],
      ['key'=>'delete_companyuser','controller'=>'UserController','method'=>'delete_company_users','description'=>'delete the company users','role'=>['System Admin']],
      ['key'=>'form_validation','controller'=>'TaskController','method'=>'form_validation','description'=>'Common form validations for systemadmin popup modals','role'=>['System Admin']],
      ['key'=>'show_report','controller'=>'ReportsController','method'=>'jsreport','description'=>'to display the jsreport page','role'=>['Admin']],
      ['key'=>'activity','controller'=>'ActivityController','method'=>'fetch','description'=>'To retrive the Activity of each model','role'=>['System Admin','Basic User','Review User','Department Admin']],
      ['key'=>'form_fields','controller'=>'TaskController','method'=>'generateFormFields','description'=>'To retrive the questionary form fields','role'=>['System Admin','Basic User','Review User','Department Admin']],
      ['key'=>'workspace','controller'=>'TaskController','method'=>'retriveFormFieldsWorkspace','description'=>'To retrive the workspace for questionary form','role'=>['System Admin','Basic User','Review User','Department Admin']],
      ['key'=>'form_details','controller'=>'TaskController','method'=>'questionnaire_formdetails','description'=>'To retrive the Questionary form details','role'=>['System Admin','Basic User','Review User','Department Admin']],
      ['key'=>'fielddetails','controller'=>'TaskController','method'=>'questionnaire_fieldsdetails','description'=>'To retrive the Questionary field details','role'=>['System Admin','Basic User','Review User','Department Admin']]
    );
            DB::statement("SET foreign_key_checks=0");
            foreach($permissionData as $permission)
            {
                $RoutePermissionDetails=Permission::where('key',$permission['key'])->first();
                Permission::where('key',$permission['key'])->delete();
                $permissionDetails=Permission::create([
                    'key'=>$permission['key'],
                    'controller'=>$permission['controller'],
                    'method'=>$permission['method'],
                    'description'=>$permission['description']
                ]);
                foreach($permission['role'] as $role)
                {
                    if($RoutePermissionDetails)
                    {
                        PermissionRole::where('permission_id',$RoutePermissionDetails->id)
                    ->where('role_id',Roles::getRoleByName($role))
                    ->delete();
                    }
                    $permissionRole=PermissionRole::create([
                        'role_id'=>Roles::getRoleByName($role),
                        'permission_id'=>$permissionDetails->id
                    ]);
                    $permissionRole->save();
                }
            }
            DB::statement("SET foreign_key_checks=1");
    }
}
