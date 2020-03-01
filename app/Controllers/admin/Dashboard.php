<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminController;

class Dashboard extends AdminController
{
	public function index()
	{
		$vars['title'] = 'test';
		echo view('admin/default', $vars);
	}
}
