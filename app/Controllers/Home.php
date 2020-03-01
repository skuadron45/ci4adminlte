<?php

namespace App\Controllers;

class Home extends BaseController
{
	protected $helpers = ['general'];

	public function index()
	{
		$this->response->redirect('admin/dashboard');
	}
}
