<?php

namespace App\Controllers\Admin;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Session\Session;
use Psr\Log\LoggerInterface;

use App\Controllers\BaseController;

use App\Libraries\Adminlte;
use App\Libraries\Auth;

use Config\Services;

class AdminController extends BaseController
{

	/**
	 * @var Adminlte
	 */
	protected $adminlte = null;

	/**
	 * @var Auth
	 */
	protected $auth = null;

	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		$this->helpers[] = 'admin';
		$this->helpers[] = 'form';
		parent::initController($request, $response, $logger);

		$this->adminlte = new Adminlte();
		$this->auth = Services::auth();		

		$session = Services::session();
		$this->vars['status'] = $session->getFlashdata('status');
		$this->vars['message'] = $session->getFlashdata('message');
	}

	protected function render()
	{
		$this->adminlte->setVars($this->vars);
		$this->adminlte->renderContentView();
	}

	protected function setFlashMessage($status = 'info', $message)
	{
		$session = Services::session();

		$session->setFlashdata('status', json_encode($status));
		$session->setFlashdata('message', json_encode($message));
	}
}
