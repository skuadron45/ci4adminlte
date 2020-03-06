<?php

namespace App\Controllers\Admin\User;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Controllers\Admin\AdminController;

use App\Libraries\Datatable;

use App\Models\MHelper;
use App\Models\MModule;
use App\Models\MPrivilege;

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
        return parent::responeDataTable($dataTable);
    }

    public function create()
    {

        $mModule = new MModule();
        $moduleList = $mModule->getConfigurableModuleList();
        $this->vars['modules'] = $moduleList;

        $this->adminlte->setContentTitle('Tambah Grup Pengguna');

        $this->adminlte->crudForm('user/usergroup/store', 'user/usergroup');
        $this->adminlte->setContentView('user/usergroup/form');
        parent::render();
    }

    public function edit($userGroupId = 0)
    {
        $mHelper = new MHelper();
        $userGroup = $mHelper->rowArray('v_user_groups', ['*'], ['id' => $userGroupId]);
        if ($userGroup) {
            $mModule = new MModule();
            $mPrivilege = new MPrivilege();

            $userPrivileges = $mPrivilege->getPrivileges($userGroupId);
            $this->vars['userGroup'] = $userGroup;
            $this->vars['userPrivileges'] = $userPrivileges;

            $moduleList = $mModule->getConfigurableModuleList();
            $this->vars['modules'] = $moduleList;

            $this->adminlte->setContentTitle('Edit Grup Pengguna');

            $this->adminlte->crudForm('user/usergroup/update/' . $userGroupId, 'user/usergroup');
            $this->adminlte->setContentView('user/usergroup/form');
            parent::render();
        } else {
            parent::setFlashMessage('warning', 'Data tidak ditemukan!');
            redirect_admin('user/usergroup');
        }
    }

    public function store()
    {
        $hasAddOrEditPrivileges = $this->auth->hasAddOrEditPrivileges(3);
        if ($hasAddOrEditPrivileges) {

            $mPrivilege = new MPrivilege();

            $status = 'error';
            $message = 'Data gagal tersimpan!';
            if ($postData = $this->request->getPost(null)) {
                if ($this->validation()) {
                    $this->vars['data'] = $postData;

                    try {
                        $mPrivilege->store($postData);
                        $status = 'success';
                        $message = "Data berhasil tersimpan !";
                    } catch (\Throwable $th) {
                        throw new \CodeIgniter\Database\Exceptions\DatabaseException();
                    }
                } else {
                    $message = $this->validator->listErrors('alert');
                }
            }
            return parent::outputJson($status, $message);
        } else {
            $status = 'error';
            $message = 'Tidak memiliki hak untuk tambah atau ubah data!';
            return $this->failUnauthorized($message);
        }
    }

    public function update($userGroupId = 0)
    {
        $hasAddOrEditPrivileges = $this->auth->hasAddOrEditPrivileges(3);
        if ($hasAddOrEditPrivileges) {
            $mHelper = new MHelper();
            $mPrivilege = new MPrivilege();
            $status = 'error';
            $message = 'Data gagal diubah!';
            $userGroup = $mHelper->rowArray('v_user_groups', ['*'], ['id' => $userGroupId]);
            if ($userGroup) {
                if ($postData = $this->request->getPost(null)) {
                    if ($this->validation()) {
                        $this->vars['data'] = $postData;
                        try {
                            $mPrivilege->update($postData, $userGroupId);
                            $status = 'success';
                            $message = "Data berhasil diubah !";
                        } catch (\Throwable $th) {
                            $message = $th->getMessage();
                        }
                    } else {
                        $message = $this->validator->listErrors('alert');
                    }
                }
            }
            return parent::outputJson($status, $message);
        } else {
            $status = 'error';
            $message = 'Tidak memiliki hak untuk tambah atau ubah data!';
            return $this->failUnauthorized($message);
        }
    }

    public function delete()
    {
        $hasDeletePrivilege = $this->auth->hasDeletePrivilege(3);
        if ($hasDeletePrivilege) {
            return $this->deleteData('v_user_groups');
        } else {
            $message = 'Tidak memiliki hak untuk menghapus!';
            return $this->failUnauthorized($message);
        }
    }

    protected function deleteData($table, $sourceTable = null, $delete = false)
    {
        $status = 'error';
        $message = 'Data gagal dihapus!';
        if ($this->request->getGet(null)) {
            $paramId = $this->request->getGet('id');
            $userId = $this->auth->getUserData('id');
            $mHelper = new MHelper();
            $mPrivilege = new MPrivilege();
            $userGroup = $mHelper->rowArray($table, ['*'], ['id' => $paramId]);
            if ($userGroup) {

                try {
                    $mPrivilege->delete($paramId, $userId);
                    $status = 'success';
                    $message = "Data berhasil dihapus!";
                } catch (\Throwable $th) {
                    $message = $th->getMessage();
                }
            } else {
                $status = 'warning';
                $message = "Data tidak ditemukan!";
            }
        }
        return parent::outputJson($status, $message);
    }

    private function validation()
    {
        $rules = [
            'group' => [
                'label'  => 'Nama Group',
                'rules'  => 'required'
            ],
            'privileges.*' => [
                'label'  => 'Privileges',
                'rules'  => 'required'
            ],
        ];
        return $this->validate($rules);
    }
}
