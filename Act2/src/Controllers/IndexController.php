<?php

namespace App\Controllers;

use App\Request;
use App\Controller;
use App\Session;

final class IndexController extends Controller
{

    public function __construct(Request $request, Session $session)
    {
        parent::__construct($request, $session);
    }
    public function index()
    {
        $dataview = ['title' => 'Todo'];
        $this->render($dataview);
    }

}
