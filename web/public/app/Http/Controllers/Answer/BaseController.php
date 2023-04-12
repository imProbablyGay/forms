<?php

namespace App\Http\Controllers\Answer;

use App\Http\Controllers\Controller;
use App\Services\Answer\Service;

class BaseController extends Controller
{
    public $service;

    function __construct(Service $service)
    {
        $this->service = $service;
    }
}
