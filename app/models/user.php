<?php
namespace App\Models;

use App\Core\App;

class User
{
    public function getAllUsers(): array
    {
        $stm = App::db()->query("SELECT * FROM users");
        return $stm->fetchAll();
    }

    public function addUser(string $name, string $email, string $password): bool
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stm = App::db()->prepare("INSERT INTO users (name, email, password) 
                                   VALUES (:name, :email, :password)");
        return $stm->execute([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword
        ]);
    }

    public function deleteUser(int $id): bool
    {
        $stm = App::db()->prepare("DELETE FROM users WHERE id=:id");
        return $stm->execute(['id' => $id]);
    }

    public function findByEmail(string $email): ?array
    {
        $stm = App::db()->prepare("SELECT * FROM users WHERE email = :email");
        $stm->execute(['email' => $email]);
        $user = $stm->fetch();

        return $user ?: null;
    }
}
