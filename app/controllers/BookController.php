<?php
class BookController {
    private $model;
    
    public function __construct() {
        require 'models/BookModel.php';
        $this->model = new BookModel();
    }
    
    public function list() {
        $books = $this->model->getAll();
        include 'views/books.php';
    }
    
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->model->add($_POST);
            header("Location: ?action=books");
        } else {
            include 'views/add_book.php';
        }
    }
}
?>