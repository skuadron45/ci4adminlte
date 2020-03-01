<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Libraries\Adminlte;

class AdminController extends BaseController
{

	/**
	 * @var Adminlte
	 */
	protected $adminlte = null;

	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		$this->helpers[] = 'admin';
		$this->helpers[] = 'form';
		parent::initController($request, $response, $logger);

		$this->adminlte = new Adminlte();
	}

	protected function render()
	{
		$this->adminlte->setVars($this->vars);
		$this->adminlte->renderContentView();
	}
}
