<?php

namespace App\Controllers;

use App\Request;
use App\Controller;
use App\Session;

final class LoginController extends Controller
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
    public function log()
    {
        if (
            isset($_POST['email']) && !empty($_POST['email'])
            && isset($_POST['passw']) && !empty($_POST['passw'])
        ) {

            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $pass = filter_input(INPUT_POST, 'passw', FILTER_SANITIZE_STRING);

            $user = $this->auth($email, $pass);

            if ($user) {
                $_SESSION['user'] = $user;
                //si l'usuari es valid
                if (isset($_POST['remember']) && ($_POST['remember'] == 'on' || $_POST['remember'] == '1')) {
                    $hour = time() + 3600 * 24 * 30;
                    //$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                    setcookie('passw', $email, $hour, '/');
                    setcookie('email', $pass, $hour, '/');
                    //setcookie('active', 1, $hour, $path);
                }
                header('Location:' . BASE . 'home');
            } else {
                header('Location:' . BASE . 'index');
            }
        }
    }
    //Función para autentificar los usuarios
    private function auth($email, $pass): bool
    {

        try {
            $stmt = $this->getDB()->prepare('SELECT * FROM users WHERE email=:email LIMIT 1');
            $stmt->execute([':email' => $email]);
            $count = $stmt->rowCount();
            $row = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if ($count == 1) {
                $user = $row[0];
                $res = password_verify($pass, $user['passw']);

                if ($res) {
                    $this->session->set('uname', $user);
                    $this->session->set('email', $email);
                    
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            return false;
        }
    }
}
