<?php
require_once "Database.php";

class Student {
    public ?int $id;
    public string $name;
    public string $email;

    public function __construct(string $name, string $email, ?int $id = null) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

   
    public function save(): bool {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("INSERT INTO students (name, email) VALUES (?, ?)");
        return $stmt->execute([$this->name, $this->email]);
    }


    public static function find(int $id): ?Student {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        if (!$row) return null;

        return new Student($row->name, $row->email, $row->id);
    }


    public function delete(): bool {
        if ($this->id === null) return false;

        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
        return $stmt->execute([$this->id]);
    }
}
