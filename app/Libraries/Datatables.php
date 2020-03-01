<?php
if (!defined('BASEPATH')) {
    defined('BASEPATH') or exit('No direct script access allowed');
}

/**
 * @property CI_Controller $CI
 * @property Defaultdatatablemodel $model
 */
class Datatables
{
    private $model = NULL;
    private $table = null;
    private $selectDbColumns = [];

    private $dtHandlers = array();

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->model = new Defaultdatatablemodel();
    }
    public function setTable($table)
    {
        $this->table = $table;
        $this->selectDbColumn();
    }

    public function selectDbColumn($column = '*', $reset = true)
    {
        if ($reset === true) {
            $this->selectDbColumns[] = [];
        }
        $this->selectDbColumns[] = $column;
    }

    public function getOutput($requestData)
    {
        $this->model->setTable($this->table);
        $this->model->selectDbColumn($this->selectDbColumns);
        $this->model->setRequestData($requestData);
        $this->model->setDtHandlers($this->dtHandlers);
        $output = array(
            "draw" => $this->model->getDraw(),
            "recordsTotal" => $this->model->getRecordsTotal(),
            "recordsFiltered" => $this->model->getRecordsFiltered(),
            "data" => $this->model->getData()
        );
        return $output;
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
}

interface Datatablemodel
{
}

/**
 * @property CI_Controller $CI
 */
class Defaultdatatablemodel implements Datatablemodel
{

    private $requestData = [];
    private $countAll = 0;
    private $countFiltered = 0;
    private $countColumn = 'id';

    private $table = null;
    private $selectDbColumns = [];

    private $dtHandlers = array();

    private $CI;
    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function setTable($table)
    {
        $this->table = $table;
    }

    public function selectDbColumn($selectDbColumns)
    {
        $this->selectDbColumns = $selectDbColumns;
    }

    public function setDtHandlers($dtHandlers)
    {
        $this->dtHandlers = $dtHandlers;
    }

    public function setRequestData($requestData)
    {
        $this->requestData = $requestData;
        $this->countAll = $this->getCountAll();
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

    private function getRecords($requestData)
    {
        $this->buildQuery($requestData);
        $query = $this->CI->db->get();
        return $query->result_array();
    }

    private function getCountAll()
    {
        $this->CI->db->select("COUNT($this->countColumn) as count", TRUE);
        $query = $this->CI->db->get($this->table);
        $row = $query->row_array();
        return $row['count'];
    }

    private function getCountFiltered($requestData, $countAll = null)
    {

        $isSearch = isset($requestData['search']);
        $searchValue = isset($requestData['search']['value']) ? $requestData['search']['value'] : '';

        if ($isSearch && !empty($searchValue)  && $countAll !== null) {
            $this->CI->db->select("COUNT($this->countColumn) as count", TRUE);
            $this->filter($requestData);
            $query = $this->CI->db->get($this->table);
            $row = $query->row_array();
            return $row['count'];
        }
        return $countAll;
    }

    private function buildQuery($requestData)
    {
        $this->select();
        $this->CI->db->from($this->table);
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
                $this->CI->db->limit($limit, $offset);
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
                        $this->CI->db->group_start();
                        $this->CI->db->like($searchableField, $searchValue);
                    } else {
                        $this->CI->db->or_like($searchableField, $searchValue);
                    }
                    if ($i === ($searchableFieldsCount - 1)) {
                        $this->CI->db->group_end();
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
                        $this->CI->db->order_by($dtHandlerDbField, $orderDir);
                    }
                }
            }
        }
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
