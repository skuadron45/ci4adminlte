<?php

namespace App\Controllers\Admin\User;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Controllers\Admin\AdminController;

class Profile extends AdminController
{

	protected $selectedModule = 5;

	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);
		$this->adminlte->setPageTitle('Profil');
		$this->adminlte->setContentTitle('Profil Pengguna');
	}

	public function index()
	{
		parent::render();
	}
}
