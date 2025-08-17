<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\Borrowing;
use App\Models\EmailNotification; // Default; can switch to SMS

class BorrowingController {
    private $model;

    public function __construct() {
        $this->model = new Borrowing();
    }

    public function borrow() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $notifier = new EmailNotification(); // Polymorphism
            $success = $this->model->borrowBook($_POST['user_id'], $_POST['book_id'], $notifier);
            View::render('borrowing_borrow', ['success' => $success]);
        } else {
            View::render('borrowing_borrow');
        }
    }

    public function returnBook() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fee = $this->model->returnBook($_POST['borrowing_id']);
            View::render('borrowing_return', ['fee' => $fee]);
        } else {
            View::render('borrowing_return');
        }
    }
}