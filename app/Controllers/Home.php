<?php

namespace App\Controllers;

use App\Controllers\Admin\AdminController;
use Config\Services;

class Home extends AdminController
{
	public function index()
	{

		$successUrl = $this->auth->getSuccessUrl();

		return $this->response->redirect(site_url($successUrl));


		// $autoload = Services::autoloader();
		// d($autoload->getNamespace());

		// $validator = Services::validation();
		// var_dump($validator->listErrors());
	}
}
