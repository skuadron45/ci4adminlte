<?php

namespace App\Controllers;

use CodeIgniter\Encryption\Encryption;

use App\Controllers\Admin\AdminController;
use CodeIgniter\CodeIgniter;

class Login extends AdminController
{

    private function loginRedirect($url)
    {
        $this->response->redirect($url);
    }

    public function index()
    {
        if ($postData = $this->request->getPost()) {
            $status = "error";
            if ($this->validation($postData)) {
                $username = $postData['username'];
                $password = $postData['password'];
                $isLogin = $this->auth->login($username, $password);
                if ($isLogin) {
                    $status = "success";
                    $message = "Login berhasil !";
                    $this->setFlashMessage($status, $message);
                    return $this->loginRedirect(site_url('admin/dashboard'));
                } else {
                    $message = "Username dan password salah !";
                }
            } else {
                $message = 'Validasi gagal !';
            }

            $this->setFlashMessage($status, $message);
            return $this->loginRedirect(site_url('login'));
        }

        $this->vars['link_form'] = 'login';

        $this->adminlte->setVars($this->vars);
        $this->adminlte->showLoginPage();
    }

    private function validation($postData = [])
    {
        return !empty($postData['username']);
    }
}
