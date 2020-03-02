<?php

namespace APP\Models;

use \Config\Database;

class MHelper
{

    protected $db;

    private $errors = [];

    private function getErrorMessage()
    {
        $total = count($this->errors);
        return $total > 0 ? $this->errors[$total - 1] : '';
    }

    private function verifyErrorMessage()
    {
        $this->db = Database::connect();
        if (!empty($this->db->error()['message'])) {
            $this->errors[] = $this->db->error()['message'];
        }
    }

    private function select($table, $fields = [], $where = null)
    {
        $db = Database::connect();
        $this->db = $db->table($table);
        foreach ($fields as $key => $escape) {
            if (is_numeric($key)) {
                $this->db->select($escape);
            } else {
                $this->db->select($key, $escape);
            }
        }

        if (isset($where)) {
            $this->db->where($where);
        }

        $query = $this->db->get();
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
        $this->db->trans_start();
        $this->db->update($table, $fillData, $where);
        $this->verifyErrorMessage();
        $this->db->trans_complete();
        $errorMessage = $this->getErrorMessage();
        return $errorMessage;
    }

    public function insert($table, array $fillData)
    {
        $this->db->trans_start();
        $this->db->insert($table, $fillData);
        $this->verifyErrorMessage();
        $this->db->trans_complete();
        $errorMessage = $this->getErrorMessage();
        return $errorMessage;
    }
    public function delete($table, $where)
    {
        $this->db->trans_start();
        $this->db->delete($table, $where);
        $this->verifyErrorMessage();
        $this->db->trans_complete();
        $errorMessage = $this->getErrorMessage();
        return $errorMessage;
    }

    public function replace($table, array $fillData, $where)
    {
        $this->db->trans_start();
        $this->db->where($where);
        $this->db->replace($table, $fillData);
        $this->verifyErrorMessage();
        $this->db->trans_complete();
        $errorMessage = $this->getErrorMessage();
        return $errorMessage;
    }
    public function insert_id()
    {
        return $this->db->insert_id();
    }
}
