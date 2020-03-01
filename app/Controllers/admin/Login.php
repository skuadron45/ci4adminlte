<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminController;

class Login extends AdminController
{

    protected function redirectIf()
    {
    }

    protected function restrict()
    {
    }

    public function index()
    {
        if ($postData = $this->request->getPost()) {
            var_dump($postData);
        }

        $this->vars['link_form'] = get_admin_base('login');
        $this->adminlte->setVars($this->vars);
        $this->adminlte->showLoginPage();
    }
}
