<?php

namespace App\Controllers\Admin\User;


use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Controllers\Admin\AdminController;

use App\Libraries\Datatable;

class Usergroup extends AdminController
{

    protected $selectedModule = 3;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->adminlte->setPageTitle('Grup Pengguna');
        $this->adminlte->setContentTitle('Daftar Grup Pengguna');
    }

    public function index()
    {
        $this->adminlte->setContentView('user/usergroup/main');
        parent::render();
    }

    public function getdata()
    {
        $dataTable = new Datatable('v_user_groups');
        $dataTable->addDtNumberHandler();
        $dataTable->addDtDb(1, 'group_name', true, true);
        $dataTable->addDtDb(2, 'id', false, false);
        parent::responeDataTable($dataTable);
    }
}
