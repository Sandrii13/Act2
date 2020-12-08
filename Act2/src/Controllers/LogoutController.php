<?php

namespace App\Controllers;

use App\Request;
use App\Controller;
use App\Session;

final class LogoutController extends Controller
{

    public function __construct(Request $request, Session $session)
    {
        parent::__construct($request, $session);
    }
    public function index()
    {
        $db = $this->getDB();
        $dataview = ['title' => 'Todo'];
        $this->render($dataview);
    }

    public function out()
    {
        //Eliminar session
        session_destroy();
        //ELiminar cookies
        if (isset($_COOKIE['email']) && isset($_COOKIE['passw'])) {
            setcookie("email", null, time() - 3600, '/');
            setcookie("passw", null, time() - 3600, '/');
        }
        header('Location:' . BASE . 'index');
    }
}
