<?php

namespace App\Controllers;

use Config\Services;
use App\Controllers\Admin\AdminController;

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
                    $successUrl = $this->auth->getSuccessUrl();
                    return $this->loginRedirect($successUrl);
                } else {
                    $message = "Username dan password salah !";
                }
            } else {
                $message = $this->validator->listErrors('alert');
            }

            $this->setFlashMessage($status, $message);
            return $this->loginRedirect('login');
        }

        $this->vars['link_form'] = 'login';

        $this->adminlte->setVars($this->vars);
        $this->adminlte->showLoginPage();
    }

    private function validation($postData = [])
    {
        $rules = [
            'username' => [
                'label'  => 'Username',
                'rules'  => 'required|alpha_dash'
            ],
            'password' => [
                'label'  => 'Password',
                'rules'  => 'required'
            ],
        ];
        return $this->validate($rules);
    }
}
