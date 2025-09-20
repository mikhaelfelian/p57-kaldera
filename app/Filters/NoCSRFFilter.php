<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class NoCSRFFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Disable CSRF protection for this request
        $config = config('App');
        $config->CSRFProtection = false;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing to do after
    }
}