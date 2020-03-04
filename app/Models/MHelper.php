<?php

namespace APP\Models;

use \Config\Database;

class MHelper
{

    private function select($table, $fields = [], $where = null)
    {
        $db = Database::connect();
        $builder = $db->table($table);
        foreach ($fields as $key => $escape) {
            if (is_numeric($key)) {
                $builder->select($escape);
            } else {
                $builder->select($key, $escape);
            }
        }

        if (isset($where)) {
            $builder->where($where);
        }

        $query = $builder->get();
        return $query;
    }

    public function rowArray($table, $fields = [], $where = null)
    {
        $query = $this->select($table, $fields, $where);
        $row = ($query) ? $query->getRowArray() : NUll;
        return ($row) ? $row : NULL;
    }

    public function resultArray($table, $fields = ['*'], $where = null)
    {
        $query = $this->select($table, $fields, $where);
        return ($query) ? $query->getResultArray() : [];
    }

    public function updateOrInsert($id, $table, array $fillData, $userId = null)
    {
        if (isParamId($id)) {
            $where = array(
                'id' => $id
            );
            $avaiable = $this->rowArray($table, ['id'], $where);
            if ($avaiable) {
                $fillData['updated_by'] = $userId;
                return $this->update($table, $fillData, $where);
            }
            return "Data tidak ditemukan!";
        } else {
            $fillData['created_by'] = $userId;
            return $this->insert($table, $fillData);
        }
    }

    public function updateWithId($id, $table, array $fillData)
    {
        if (isParamId($id)) {
            $where = array(
                'id' => $id
            );

            $avaiable = $this->rowArray($table, ['id'], $where);
            if ($avaiable) {
                return $this->update($table, $fillData, $where);
            }
        }

        return "Data tidak ditemukan!";
    }

    public function update($table, array $fillData, $where)
    {
        $db = Database::connect();
        $db->transStart();

        $builder = $db->table($table);
        $builder->update($fillData, $where);

        $db->transComplete();
    }

    public function insert($table, array $fillData)
    {
        $db = Database::connect();
        $db->transStart();

        $builder = $db->table($table);
        $builder->insert($fillData);

        $db->transComplete();
    }
    public function delete($table, $where)
    {

        $db = Database::connect();
        $db->transStart();

        $builder = $db->table($table);
        $builder->delete($where);

        $db->transComplete();
    }

    public function replace($table, array $fillData, $where)
    {
        $db = Database::connect();
        $db->transStart();

        $builder = $db->table($table);
        $builder->where($where);
        $builder->replace($fillData);

        $db->transComplete();
    }
    
    public function insert_id()
    {
        $db = Database::connect();
        return $db->insertID();
    }
}
