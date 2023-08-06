<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;

//use App\Http\SiteHelper;

class AdminBaseController extends Controller
{

    public function __construct()
    {

        $this->middleware(function ($request, $next) {

            return $next($request);

        });
    }

}
