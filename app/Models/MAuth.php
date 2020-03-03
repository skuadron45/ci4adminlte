<?php
namespace App\Models;

use \Config\Database;

class MAuth
{

    public function __construct()
    {
    }

    public function validateUser($username)
    {
        $db = Database::connect();
        $builder = $db->table('v_users');

        $builder->select('*');
        $builder->where('username', $username);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function getUserPrivileges($userGroupId)
    {
        $db = Database::connect();
        $builder = $db->table('v_modules');

        // Jika usergroup -1/null, maka user adalah Super Admin
        $isSuperAdmin = !isset($userGroupId) || $userGroupId == "-1";

        $allPrivileges = [];

        /**
         * Dapatkan module yang tidak perlu privilege
         */
        $builder->select('id');
        $builder->select('module_name');
        $builder->select('module_id_path');
        $builder->select('module_url');

        if ($isSuperAdmin) {
            /**
             * Untuk super_admin filter gunakan field super_admin
             */
            $builder->where('super_admin', 1);
        } else {
            /**
             * Untuk administrator filter gunakan field need_privilege
             */
            $builder->where('need_privilege', 0);
        }

        // Filter untuk module system admin
        $builder->where('module_type', 1);

        $query = $builder->get();
        $modules = $query->getResultArray();
        foreach ($modules as $module) {
            $moduleId = $module['id'];

            $allPrivileges[$moduleId] = array(
                'module_id' => $moduleId,
                'module_name' => $module['module_name'],
                'module_id_path' => $module['module_id_path'],
                'module_url' => $module['module_url'],
                'can_add' => '1',
                'can_delete' => '1',
                'can_edit' => '1'
            );
        }

        // Jika bukan super admin, periksa user privileges
        if ($isSuperAdmin == false) {

            // Lakukan pengecekan privileges ke table user privileges
            $builder = $db->table('v_user_privileges');
            $builder->select('module_id');
            $builder->select('module_name');
            $builder->select('module_id_path');
            $builder->select('module_url');
            $builder->select('can_add');
            $builder->select('can_delete');
            $builder->select('can_edit');

            $builder->where('user_group_id', $userGroupId);

            $query = $builder->get();
            $privileges = $query->getResultArray();
            foreach ($privileges as $privilege) {
                $moduleId = $privilege['module_id'];

                $allPrivileges[$moduleId] = array(
                    'module_id' => $moduleId,
                    'module_name' => $privilege['module_name'],
                    'module_id_path' => $privilege['module_id_path'],
                    'module_url' => $privilege['module_url'],
                    'can_add' => $privilege['can_add'],
                    'can_edit' => $privilege['can_edit'],
                    'can_delete' => $privilege['can_delete'],
                );
            }
        }


        return $allPrivileges;
    }
}
