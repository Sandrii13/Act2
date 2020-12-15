<?php

namespace App\Controllers;

use App\Request;
use App\Controller;
use App\Session;

final class RegisterController extends Controller
{

    public function __construct(Request $request, Session $session)
    {
        parent::__construct($request, $session);
    }
    public function index()
    {
        $dataview = ['title' => 'Register'];
        $this->render($dataview);
    }
    public function reg()
    {
        if (
            isset($_POST['email']) && !empty($_POST['email'])
            && isset($_POST['passw']) && !empty($_POST['passw'])
            && isset($_POST['user']) && !empty($_POST['user'])
        ) {

            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $passw = filter_input(INPUT_POST, 'passw', FILTER_SANITIZE_STRING);
            $pass = password_hash($passw, PASSWORD_BCRYPT, ["cost" => 4]);
            $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
            $table = 'users';
            $data = ['email' => $email, 'uname' => $user, 'passw' => $pass];

            $ins = $this->getDB()->insert($table, $data);

            if ($ins) {
                $_SESSION['user'] = $ins;

                header('Location:' . BASE . 'home');
            } else {
                header('Location:' . BASE . 'register');
            }
        } else {
            header('Location:' . BASE . 'register');
        }
    }
}
