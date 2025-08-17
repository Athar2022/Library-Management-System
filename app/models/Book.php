<?php
namespace App\Models;

class Book {
    
    private $pdo;
    public function updateBook($id, $bookname, $title, $author, $available_copies) {
        try {
            $stmt = $this->pdo->prepare("UPDATE books SET bookname = :bookname, title = :title, author = :author, available_copies = :available_copies WHERE id = :id");
            $stmt->execute(['id' => $id, 'bookname' => $bookname, 'title' => $title, 'author' => $author, 'available_copies' => $available_copies]);
            $this->logAction("Book updated: ID $id");
        } catch (\PDOException $e) {
            $this->logAction("Error updating book: " . $e->getMessage());
        }
    }

    public function searchByTitleOrAuthor($value) {
        $titleResults = $this->searchByField($this->pdo, 'books', 'title', $value);
        $authorResults = $this->searchByField($this->pdo, 'books', 'author', $value);
        return array_merge($titleResults, $authorResults);
    }

    public function deleteBook($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM books WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $this->logAction("Book deleted: ID $id");
        } catch (\PDOException $e) {
            $this->logAction("Error deleting book: " . $e->getMessage());
        }
    }

    public function getAllBooks() {
        $stmt = $this->pdo->query("SELECT * FROM books");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getBookById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM books WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}