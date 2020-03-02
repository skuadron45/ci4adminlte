<?php

namespace App\Controllers;

class Home extends BaseController
{
	protected $helpers = ['general'];

	public function index()
	{

		var_dump('Home');
		//return redirect()->to('/admin/dashboard');
	}
}
