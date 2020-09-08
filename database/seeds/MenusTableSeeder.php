<?php

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('menus')->delete();
        
        \DB::table('menus')->insert(array (
            0 => 
            array (
                'id' => 9,
                'menu_name' => 'role.index',
                'parameters' => NULL,
                'route' => NULL,
                'display_name' => 'Roles',
                'parent_id' => 46,
                'order' => 3,
                'icon' => NULL,
                'created_at' => '2019-01-02 10:04:13',
                'updated_at' => '2019-01-02 10:32:33',
            ),
            1 => 
            array (
                'id' => 16,
                'menu_name' => 'permission.index',
                'parameters' => NULL,
                'route' => NULL,
                'display_name' => 'Permission',
                'parent_id' => 46,
                'order' => 4,
                'icon' => NULL,
                'created_at' => '2019-01-02 10:04:25',
                'updated_at' => '2019-01-02 10:32:33',
            ),
            2 => 
            array (
                'id' => 25,
                'menu_name' => 'user.index',
                'parameters' => NULL,
                'route' => NULL,
                'display_name' => 'Users',
                'parent_id' => 46,
                'order' => 2,
                'icon' => NULL,
                'created_at' => '2019-01-02 09:31:06',
                'updated_at' => '2019-01-02 10:32:16',
            ),
            3 => 
            array (
                'id' => 32,
                'menu_name' => 'assignrole.index',
                'parameters' => NULL,
                'route' => NULL,
                'display_name' => 'Assign Permission',
                'parent_id' => 46,
                'order' => 5,
                'icon' => NULL,
                'created_at' => '2019-01-02 10:04:48',
                'updated_at' => '2019-01-02 10:32:33',
            ),
            4 => 
            array (
                'id' => 46,
                'menu_name' => '#usermanagement',
                'parameters' => NULL,
                'route' => NULL,
                'display_name' => 'User Management',
                'parent_id' => 0,
                'order' => 3,
                'icon' => NULL,
                'created_at' => '2019-01-02 09:26:37',
                'updated_at' => '2019-01-02 10:07:25',
            ),
            5 => 
            array (
                'id' => 47,
                'menu_name' => 'menu-index',
                'parameters' => NULL,
                'route' => NULL,
                'display_name' => 'Menu Builder',
                'parent_id' => 46,
                'order' => 6,
                'icon' => NULL,
                'created_at' => '2019-01-02 10:06:43',
                'updated_at' => '2019-01-02 10:07:25',
            ),
        ));
        
        
    }
}