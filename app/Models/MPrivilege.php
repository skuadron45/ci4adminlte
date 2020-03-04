<?php

namespace App\Models;

use \Config\Database;

class MPrivilege
{

    public function getPrivileges($userGroupId)
    {
        $db = Database::connect();
        $builder = $db->table('tbl_user_privileges');
        $builder->where('user_group_id', $userGroupId);
        $query = $builder->get();

        $records = $query->getResultArray();
        $privileges = [];

        foreach ($records as $record) {
            $privileges[] = array(
                'module' => $record['module_id'],
                'is_view' => '1',
                'is_add' => $record['can_add'],
                'is_edit' => $record['can_edit'],
                'is_delete' => $record['can_delete'],
            );
        }
        return $privileges;
    }

    public function delete($paramId, $userId = 0)
    {
        $where = array(
            'id' => $paramId
        );
        $fill = array(
            'is_deleted' => 1,
            'deleted_by' => $userId
        );

        $db = Database::connect();
        $db->transStart();

        $builder = $db->table('tbl_user_groups');
        $builder->where($where);
        $builder->update($fill);

        // Penghapusan detail tbl_user_privileges bisa menggunaan trigger
        $where = array(
            'user_group_id' => $paramId
        );
        $builder = $db->table('tbl_user_privileges');
        $builder->delete($where);

        $db->transComplete();
    }

    public function update($postData, $userGroupId)
    {
        $group = $postData['group'];
        $privileges = $postData['privileges'];

        $where = array(
            'id' => $userGroupId
        );
        $fill = array(
            'group_name' => $group
        );

        $db = Database::connect();
        $db->transStart();

        $builder = $db->table('tbl_user_groups');
        $builder->where($where);
        $builder->update($fill);

        $where = array(
            'user_group_id' => $userGroupId
        );

        $builder = $db->table('tbl_user_privileges');
        $builder->delete($where);


        if (count($privileges) > 0) {
            foreach ($privileges as $key => $privilege) {
                $moduleId = $key;
                $record = array(
                    'user_group_id' => $userGroupId,
                    'module_id' => $moduleId,
                    'can_add' => isset($privilege['is_add']) ? 1 : 0,
                    'can_edit' => isset($privilege['is_edit']) ? 1 : 0,
                    'can_delete' => isset($privilege['is_delete']) ? 1 : 0,
                );
                $where = array(
                    'module_id' => $moduleId,
                    'user_group_id' => $userGroupId
                );

                $builder = $db->table('tbl_user_privileges');
                $builder->where($where);
                $builder->replace($record);
            }
        }

        $db->transComplete();
    }

    public function store($postData)
    {

        $group = $postData['group'];
        $privileges = $postData['privileges'];

        $fill = array(
            'group_name' => $group
        );


        $db = Database::connect();
        $db->transStart();
        $builder = $db->table('tbl_user_groups');
        $builder->insert($fill);
        $userGroupId = $db->insertID();
        if ($userGroupId > 0) {
            if (count($privileges) > 0) {
                $records = [];
                foreach ($privileges as $key => $privilege) {
                    $record = array(
                        'user_group_id' => $userGroupId,
                        'module_id' => $key,
                        'can_add' => isset($privilege['is_add']) ? 1 : 0,
                        'can_edit' => isset($privilege['is_edit']) ? 1 : 0,
                        'can_delete' => isset($privilege['is_delete']) ? 1 : 0,
                    );
                    $records[] = $record;
                }
                $builder = $db->table('tbl_user_privileges');
                $builder->insertBatch($records);
            }
        }
        $db->transComplete();
    }
}
