<?php

namespace App\Controllers\Admin\User;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Controllers\Admin\AdminController;

use App\Libraries\Datatable;
use App\Models\MHelper;

class User extends AdminController
{

    protected $selectedModule = 2;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->adminlte->setPageTitle('Pengguna');
        $this->adminlte->setContentTitle('Daftar Pengguna');
    }

    public function index()
    {

        $mHelper = new MHelper();
        $userGroups = $mHelper->resultArray('tbl_user_groups');
        $userGroupsDs = populateDsDropdown($userGroups, 'id', 'group_name');
        $this->vars['userGroupsDs'] = json_encode($userGroupsDs);
        $this->adminlte->setContentView('user/user/main');

        parent::render();
    }

    public function getdata()
    {
        $dataTable = new Datatable('v_administrators');
        $dataTable->addDtNumberHandler();
        $dataTable->addDtDb(1, 'username', true, true);
        $dataTable->addDtDb(2, 'fullname', true, true);
        $dataTable->addDtDb(3, 'email', true, true);
        $dataTable->addDtDb(4, 'id', false, false);
        parent::responeDataTable($dataTable);
    }
}
