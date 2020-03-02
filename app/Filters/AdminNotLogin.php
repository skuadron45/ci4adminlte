<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

class AdminNotLogin implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        $auth = Services::auth();
        $hasLogin = $auth->hasLogin();
        if (!$hasLogin) {
            return redirect()->to(site_url('login'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response)
    {
    }
}
