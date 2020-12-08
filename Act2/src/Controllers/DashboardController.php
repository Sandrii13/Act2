<?php

namespace App\Controllers;

use App\Request;
use App\Controller;
use App\Session;

final class DashboardController extends Controller{

    public function __construct(Request $request, Session $session)
    {
        parent::__construct($request, $session);
    }
    public function index()
    {
        $dataview = ['title' => 'Todo'];
        $this->render($dataview);
    }

    public function selectd()
    {
        $user = $this->session->get('uname');
        $condition = ['user', $user['id']];
        $data = $this->getDB()->selectWhere('task', ['id', 'description', 'due_date'], $condition);
        $this->render(['title' => 'Todo', 'user' => $user, 'data' => $data], 'dashboard');
    }
    public function removed()
    {
        $idTask = filter_input(INPUT_POST, 'idTask', FILTER_SANITIZE_STRING);

        $user = $this->session->get('uname');
        $data = $this->getDB()->remove('task', $idTask);

        $this->render(['title' => 'Todo', 'user' => $user, 'data' => $data], 'dashboard');
    }
    public function insertd()
    {
        $desc = filter_input(INPUT_POST, 'desc', FILTER_SANITIZE_STRING);
        $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);

        $user = $this->session->get('uname');
        $data = ['description' => $desc, 'user' => $user['id'], 'due_date' => $date];

        $result = $this->getDB()->insert('task', $data);
        $this->render(['title' => 'Todo', 'user' => $user, 'data' => $result], 'dashboard');
    }
    public function editd()
    {
        $ndesc = filter_input(INPUT_POST, 'newdesc', FILTER_SANITIZE_STRING);
        $ndate = filter_input(INPUT_POST, 'newdate', FILTER_SANITIZE_STRING);
        $nidTask = filter_input(INPUT_POST, 'nidTask', FILTER_SANITIZE_STRING);

        $user = $this->session->get('uname');
        $data = ['description' => $ndesc, 'due_date' => $ndate];
        $conditions = ['id', $nidTask];
        $result = $this->getDB()->update('task', $data, $conditions);
        $this->render(['title' => 'Todo', 'user' => $user, 'data' => $result], 'dashboard');
    }
}
