<?php

namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;

class BaseController extends Controller
{

	protected $vars = [];

	protected $helpers = ['general', 'url'];

	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);
	}

	protected function outputError($httpCode = 403, $message = 'Request forbidden!')
	{
		$status = 'error';
		$this->vars['status'] = $status;
		$this->vars['message'] = $message;
		return $this->response
			->setStatusCode($httpCode)
			->setJSON($this->vars);
	}
}
