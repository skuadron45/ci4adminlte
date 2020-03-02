<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\AdminController;

class Logout extends AdminController
{

    public function index()
    {
        $this->auth->logout();

        $this->setFlashMessage("success", "Logout berhasil !");
        return redirect()->to(site_url('login'));
    }

}
