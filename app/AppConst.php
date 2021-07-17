<?php

namespace App;

class AppConst
{
   const EMAIL = 'email';
   const EMAIL_HASH = 'email_hash';
   const PASSWORD = 'password';
   const STATUS = 'status';
   const REQUIRED = 'required';
   const STRING = 'string';
   const ROLE_ID = 'role_id';
   const TOKEN = 'token';
   const DEVICE_ID = 'device_id';
   const ERROR = 'error';
   const PICTURE = 'picture';
   const USERS = 'users';
   const DRIVER = 'driver';
   const PROVIDER = 'provider';
   const CACHE = 'cache';
   const MYSQL = 'mysql';
   const DATABASE_URL = 'DATABASE_URL';
   const IPADDRESS='127.0.0.1';
   const DATEFORMATS="Y-m-d";
   const EXISTS="El atributo seleccionado: no es v?lido.";
   const REGEX="El formato de :attribute no es v?lido";
   const TASK_CREATED_BY_ID = 'tasks.created_by_id';
   const COMMON_PAGINATE = 'common.paginate';
   const DOC_SPLIT_STRING = '___split___';
   const TASK_ID='tasks.id';
   const TASK_DEPARTMENT_TASK_ID='task_departments.task_id';
   const TASK_DEPARTMENT_DEPARTMENT_ID='task_departments.department_id';
   const TASK_CLIENTS_TASK_ID='task_clients.task_id';
   const TASK_USERS_TASK_ID='task_users.task_id';
   const TASK_CLIENTS_CLIENT_ID='task_clients.client_id';
   const TASK_CLIENTS_CREATED_AT='task_clients.created_at';
   const TASK_USERS_CREATED_AT='task_users.created_at';
   const TASK_DEPARTMENTS_IS_ALL='task_departments.is_all';
   const TASK_USERS_COMPANY_USER_ID='task_users.company_user_id';
   const TASK_CHALLENGE_STATUS='tasks.task_challenge_status';
   const DEPARTMENTS_ID = 'departments.id';
   const CLIENTS_ID = 'clients.id';
   const COMPANY_CLIENTS_CLIENTID = 'company_clients.client_id';
   const COMPANY_CLEINTS_COMPANYID = 'company_clients.company_id';
   const CLIENTS = 'clients.*';
   const USERS_ID = 'users.id';
   const FUND_GROUPS_ID = 'fund_groups.id';
   const TASKS_CREATEDAT = 'tasks.created_at';
   const TASKS = 'tasks.*';
   const CLIENTS_DEADLINE = 'clients.deadline_priority';
   const DEPARTMENT_MEMBERS_DEPARTMENT_ID = 'department_members.department_id';
   const COMPANY_USERS_ID = 'company_users.id';
   const DEPT_MEMS_COMUSRID = 'department_members.company_user_id';
   const CMP_DEP_ID = 'company_departments.department_id';
   const CMP_DEP_CMPID= 'company_departments.company_id';
}
?>