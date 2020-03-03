<?php

namespace App\Controllers;

use App\Controllers\Admin\AdminController;
use Config\Services;

class Home extends AdminController
{
	public function index()
	{
		$autoload = Services::autoloader();
		d($autoload->getNamespace());

		$validator = Services::validation();
        var_dump($validator->listErrors());
	}
}
