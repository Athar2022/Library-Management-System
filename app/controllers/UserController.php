<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\User;

class UserController {
    private $model;

    public function __construct() {
        $this->model = new User();
    }

    public function home() {
        View::render('home');
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->model->addUser($_POST['username'], $_POST['email'], $_POST['password']);
            header('Location: /users/list');
        } else {
            View::render('user_add');
        }
    }

    public function list() {
        $users = $this->model->getAllUsers();
        View::render('user_list', ['users' => $users]);
    }

    public function delete() {
        $id = $_GET['id'];
        $this->model->deleteUser($id);
        header('Location: /users/list');
    }
}