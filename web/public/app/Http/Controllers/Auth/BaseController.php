<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\Service;

class BaseController extends Controller
{
    public $service;

    function __construct(Service $service)
    {
        $this->service = $service;
    }
}
