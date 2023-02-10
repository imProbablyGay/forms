<?php

namespace App\Http\Controllers\Form;

use App\Http\Controllers\Controller;
use App\Services\Form\Service;

class BaseController extends Controller
{
    public $service;

    function __construct(Service $service)
    {
        $this->service = $service;
    }
}
