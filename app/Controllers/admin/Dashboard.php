<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\AdminController;

class Dashboard extends AdminController
{

	protected $selectedModule = 4;

	public function index()
	{
		parent::render();
	}
}
