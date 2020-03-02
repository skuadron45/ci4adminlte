<?php

namespace App\Models;

use \Config\Database;

class MAuth
{

    protected $db;

    public function validateUser($username)
    {
        $db = Database::connect();
        $this->db = $db->table('v_users');

        $this->db->select('*');
        $this->db->where('username', $username);
        $query = $this->db->get();
        return $query->getRowArray();
    }

    public function getUserPrivileges($userGroupId)
    {
        // Jika usergroup -1/null, maka user adalah Super Admin
        $isSuperAdmin = !isset($userGroupId) || $userGroupId == "-1";

        $allPrivileges = [];

        /**
         * Dapatkan module yang tidak perlu privilege
         */
        $this->db->select('id');
        $this->db->select('module_name');
        $this->db->select('module_id_path');
        $this->db->select('module_url');

        if ($isSuperAdmin) {
            /**
             * Untuk super_admin filter gunakan field super_admin
             */
            $this->db->where('super_admin', 1);
        } else {
            /**
             * Untuk administrator filter gunakan field need_privilege
             */
            $this->db->where('need_privilege', 0);
        }

        // Filter untuk module system admin
        $this->db->where('module_type', 1);

        $query = $this->db->get('v_modules');
        $modules = $query->result_array();
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
            $this->db->select('module_id');
            $this->db->select('module_name');
            $this->db->select('module_id_path');
            $this->db->select('module_url');
            $this->db->select('can_add');
            $this->db->select('can_delete');
            $this->db->select('can_edit');

            $this->db->where('user_group_id', $userGroupId);

            $query = $this->db->get('v_user_privileges');
            $privileges = $query->result_array();
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
