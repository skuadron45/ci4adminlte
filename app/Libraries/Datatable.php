<?php

namespace App\Libraries;

use Config\Database;

class Datatable
{
    private $table = null;
    private $selectDbColumns = [];

    private $dtHandlers = array();

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function selectDbColumn($column = '*', $reset = true)
    {
        if ($reset === true) {
            $this->selectDbColumns[] = [];
        }
        $this->selectDbColumns[] = $column;
    }

    public function addDtNumberHandler()
    {
        $render = function ($record, $value, $meta) {
            return $meta['offset'] + 1;
        };
        $this->addDtHandler(0, '', false, false, $render);
    }

    public function addDtDb($dtIndex, $dbField, $orderable = true, $searchable = true, $render = null)
    {
        $this->addDtHandler($dtIndex, $dbField, $orderable, $searchable, $render);
    }

    private function addDtHandler($dtIndex, $dbField = null, $orderable = true, $searchable = true, $render = null)
    {
        $dtHandler = [];
        $dtHandler['dbField'] = $dbField;
        $dtHandler['orderable'] = isset($dbField) ? $orderable : false;
        $dtHandler['searchable'] = isset($dbField) ? $searchable : false;
        $dtHandler['render'] = function ($record, $value, $meta) {
            return $value;
        };

        if (isset($render)) {
            $dtHandler['render'] = $render;
        }
        $this->dtHandlers[$dtIndex] = $dtHandler;
    }

    public function getOutput($requestData)
    {
        $model = new DefaultDatatableModel($this->table, $requestData);
        $model->setDtHandlers($this->dtHandlers);
        // $model->selectDbColumn($this->selectDbColumns);

        $output = array(
            "draw" => isset($requestData['draw']) ? intval($requestData['draw']) : 0,
            "recordsTotal" => $model->getRecordsTotal(),
            "recordsFiltered" => $model->getRecordsFiltered(),
            "data" => $model->getData()
        );
        return $output;
    }
}

interface DatatableModel
{
}

class DefaultDatatableModel implements DatatableModel
{

    private $requestData = [];
    private $countAll = 0;
    private $countFiltered = 0;
    private $countColumn = 'id';

    private $table = null;

    private $dtHandlers = array();

    private $builder = null;

    public function __construct($table, $requestData)
    {
        $this->table = $table;
        $this->requestData = $requestData;

        $db = Database::connect();
        $this->builder = $db->table($this->table);

        $this->countAll = $this->getCountAll();
    }

    public function setDtHandlers($dtHandlers)
    {
        $this->dtHandlers = $dtHandlers;
    }

    public function selectDbColumn($selectDbColumns)
    {
    }

    public function getDraw()
    {
        $requestData = $this->requestData;
        return isset($requestData['draw']) ? intval($requestData['draw']) : 0;
    }

    public function getRecordsTotal()
    {
        return $this->countAll;
    }

    public function getRecordsFiltered()
    {
        $requestData = $this->requestData;
        $this->countFiltered = $this->getCountFiltered($requestData, $this->countAll);
        return $this->countFiltered;
    }

    public function getData()
    {
        $requestData = $this->requestData;
        $data = $this->renderData($requestData);
        return $data;
    }


    private function getCountAll()
    {
        $this->builder->select("COUNT($this->countColumn) as count", TRUE);
        $query = $this->builder->get();
        $row = $query->getRowArray();
        return $row['count'];
    }

    private function getCountFiltered($requestData, $countAll = null)
    {

        $isSearch = isset($requestData['search']);
        $searchValue = isset($requestData['search']['value']) ? $requestData['search']['value'] : '';

        if ($isSearch && !empty($searchValue)  && $countAll !== null) {

            $this->builder->select("COUNT($this->countColumn) as count", TRUE);
            $this->filter($requestData);
            $query = $this->builder->get();
            $row = $query->getRowArray();
            return $row['count'];
        }
        return $countAll;
    }

    private function buildQuery($requestData)
    {
        $this->select();
        $this->limit($requestData);
        $this->filter($requestData);
        $this->order($requestData);
    }

    private function select()
    {
    }

    private function limit($requestData)
    {
        if (isset($requestData['start']) && isset($requestData['length'])) {
            $offset = $requestData['start'];
            $limit = $requestData['length'];
            if ($limit != -1) {
                $this->builder->limit($limit, $offset);
            }
        }
    }

    private function filter($requestData)
    {
        $hasSearch = isset($requestData['search']);
        if ($hasSearch) {
            $searchValue = isset($requestData['search']['value']) ? $requestData['search']['value'] : null;

            if (!empty($searchValue)) {

                $dtHandlers = $this->dtHandlers;
                $requestColumns = $requestData['columns'];

                $searchableFields = [];

                for ($j = 0; $j < count($requestColumns); $j++) {
                    $renderRow[$j] = "";
                    $dtHandler = isset($dtHandlers[$j]) ? $dtHandlers[$j] : null;
                    if (isset($dtHandler)) {
                        if ($dtHandler['searchable']) {
                            $searchableFields[] = $dtHandler['dbField'];
                        }
                    }
                }

                $searchableFieldsCount = count($searchableFields);
                for ($i = 0; $i < $searchableFieldsCount; $i++) {
                    $searchableField = $searchableFields[$i];
                    if ($i === 0) {
                        $this->builder->groupStart();
                        $this->builder->like($searchableField, $searchValue);
                    } else {
                        $this->builder->orLike($searchableField, $searchValue);
                    }
                    if ($i === ($searchableFieldsCount - 1)) {
                        $this->builder->groupEnd();
                    }
                }
            }
        }
    }
    private function order($request)
    {
        $dtHandlers = $this->dtHandlers;

        $needOrdering = isset($request['order']);
        if ($needOrdering) {
            $orders = $request['order'];
            for ($i = 0; $i < count($orders); $i++) {
                $order = $orders[$i];
                $orderColumn = $order['column'];
                $orderDir = $order['dir'];
                $dtHandler = isset($dtHandlers[$orderColumn]) ? $dtHandlers[$orderColumn] : null;
                if (isset($dtHandler)) {
                    $isOrderable = $dtHandler['orderable'];
                    if ($isOrderable === true) {
                        $dtHandlerDbField = $dtHandler['dbField'];
                        $this->builder->orderBy($dtHandlerDbField, $orderDir);
                    }
                }
            }
        }
    }

    private function getRecords($requestData)
    {
        $this->buildQuery($requestData);
        $query = $this->builder->get();
        return $query->getResultArray();
    }

    private function renderData($requestData)
    {
        $offset = $requestData['start'];
        $records = $this->getRecords($requestData);
        $requestColumns = $requestData['columns'];
        $dtHandlers = $this->dtHandlers;
        $renderRecords = [];
        for ($i = 0; $i < count($records); $i++) {
            $record = $records[$i];

            $renderRow = [];
            for ($j = 0; $j < count($requestColumns); $j++) {
                $renderRow[$j] = "";
                $dtHandler = isset($dtHandlers[$j]) ? $dtHandlers[$j] : null;
                if (isset($dtHandler)) {
                    $value = "";
                    $dtHandlerDbField = null;
                    $hasDtHandlerDbField = isset($dtHandler['dbField']);
                    if ($hasDtHandlerDbField) {
                        $dtHandlerDbField = $dtHandler['dbField'];
                        $value = isset($record[$dtHandlerDbField]) ? $record[$dtHandlerDbField] : '';
                    }
                    $dtHandlerRender = $dtHandler['render'];
                    $meta = array(
                        'row' => $i,
                        'dt' => $j,
                        'dbField' => $dtHandlerDbField,
                        'offset' => $i + $offset,
                    );


                    if (is_callable($dtHandlerRender)) {
                        $value = $dtHandlerRender($record, $value, $meta);
                    } else {
                        $value = $dtHandlerRender;
                    }
                    $renderRow[$j] = cleanString($value);
                }
            }
            $renderRecords[] = $renderRow;
        }
        return $renderRecords;
    }
}
