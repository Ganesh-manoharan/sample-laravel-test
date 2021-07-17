<?php

use App\Menu;
use App\MenuItem;
use App\RoleMenu;
use App\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        DB::table('menus')->truncate();
        MenuItem::truncate();
        RoleMenu::truncate();

        $selfvariable = '_self';
        $data = array(
            [
                'name' => 'sidebar-menu',
                'menu_items' => [
                    [
                        'title' => 'Home',
                        'url' => 'home',
                        'target' => $selfvariable,
                        'order' => 1,
                        'icon_general' => 'img/sidebaricons/Home-icon.svg',
                        'icon_active' => 'img/sidebaricons/Home-icon_active.svg',
                        'roles' => ['System Admin', 'Basic User', 'Review User']
                    ],
                    ['title' => 'Task', 'url' => 'task.form', 'target' => $selfvariable, 'order' => 2, 'icon_general' => 'img/sidebaricons/task.svg', 'icon_active' => 'img/sidebaricons/task_active.svg', 'roles' => ['System Admin', 'Basic User', 'Review User', 'Department Admin']],
                    ['title' => 'Teams', 'url' => 'teams', 'target' => $selfvariable, 'order' => 4, 'icon_general' => 'img/sidebaricons/Customers-icon.svg', 'icon_active' => 'img/sidebaricons/Customers-icon_active.svg', 'roles' => ['System Admin', 'Basic User', 'Review User','Department Admin']],
                    ['title' => 'Clients', 'url' => 'clients', 'target' => $selfvariable, 'order' => 5, 'icon_general' => 'img/sidebaricons/Market-icon.svg', 'icon_active' => 'img/sidebaricons/Market-icon_active.svg', 'roles' => ['System Admin', 'Basic User', 'Review User', 'Department Admin']],
                    ['title' => 'Funds', 'url' => 'funds', 'target' => $selfvariable, 'order' => 6, 'icon_general' => 'img/sidebaricons/fund.svg', 'icon_active' => 'img/sidebaricons/fund_active.svg', 'roles' => ['System Admin', 'Basic User', 'Review User', 'Department Admin']],
                    ['title' => 'Reports', 'url' => 'reports', 'target' => $selfvariable, 'order' => 2, 'icon_general' => 'img/sidebaricons/report.svg', 'icon_active' => 'img/sidebaricons/report_active.svg', 'roles' => ['Admin']],
                    ['title' => 'Documents', 'url' => 'document_index', 'target' => $selfvariable, 'order' => 8, 'icon_general' => 'img/sidebaricons/document_inactive.svg', 'icon_active' => 'img/sidebaricons/document_active.svg', 'roles' => ['System Admin']],
                    ['title' => 'File Delivery', 'url' => 'ftp_documents_index', 'target' => $selfvariable, 'order' => 1, 'icon_general' => 'img/sidebaricons/document_inactive.svg', 'icon_active' => 'img/sidebaricons/document_active.svg', 'roles' => ['Client User']],
                    ['title' => 'Companies', 'url' => 'admin_home', 'target' => $selfvariable, 'order' => 1, 'icon_general' => 'img/sidebaricons/Customers-icon.svg', 'icon_active' => 'img/sidebaricons/Customers-icon_active.svg', 'roles' => ['Admin']],
                    ['title' => 'Reports', 'url' => 'report_schedule', 'target' => $selfvariable, 'order' => 7, 'icon_general' => 'img/sidebaricons/report.svg', 'icon_active' => 'img/sidebaricons/report_active.svg', 'roles' => ['System Admin']],
                    ['title' => 'Risk', 'url' => 'task.form', 'target' => $selfvariable, 'order' => 3, 'icon_general' => 'img/sidebaricons/risk.svg', 'icon_active' => 'img/sidebaricons/risk_active.svg', 'roles' => ['System Admin', 'Basic User', 'Review User', 'Department Admin']]

                ]
            ],
            [
                'name' => 'tasks-dashboard-action',
                'menu_items' => [
                    [
                        'title' => 'View',
                        'url' => 'taskdetail',
                        'target' => $selfvariable,
                        'order' => 1,
                        'icon_general' => null,
                        'icon_active' => null,
                        'roles' => ['System Admin', 'Basic User', 'Review User']
                    ],
                    [
                        'title' => 'Task Edit',
                        'url' => 'taskedit',
                        'target' => $selfvariable,
                        'order' => 2,
                        'icon_general' => null,
                        'icon_active' => null,
                        'roles' => ['System Admin', 'Department Admin']
                    ],
                    [
                        'title' => 'Reopen Task',
                        'url' => 'taskReopen',
                        'target' => $selfvariable,
                        'order' => 3,
                        'icon_general' => null,
                        'icon_active' => null,
                        'roles' => ['System Admin', 'Department Admin']
                    ],
                    [
                        'title'=>'Delete','url'=>'taskedit','target'=>$selfvariable,'order'=>4,'icon_general'=>null,'icon_active'=>null,'roles' => ['System Admin','Department Admin']
                    ]

                ]
            ],
        );
        foreach ($data as $item) {
            $menu = Menu::create([
                'name' => $item['name']
            ]);
            foreach ($item['menu_items'] as $menu_item) {
                if ($menu) {
                    $mi = MenuItem::create([
                        'menus_id' => $menu->id,
                        'title' => $menu_item['title'],
                        'url' => $menu_item['url'],
                        'target' => $menu_item['target'],
                        'order' => $menu_item['order'],
                        'icon_general' => $menu_item['icon_general'],
                        'icon_active' => $menu_item['icon_active']
                    ]);
                    foreach ($menu_item['roles'] as $role) {
                        RoleMenu::create([
                            'role_id' => Roles::getRoleByName($role),
                            'menu_items_id' => $mi->id
                        ]);
                    }
                }
            }
        }
        DB::statement("SET foreign_key_checks=1");
    }
}
