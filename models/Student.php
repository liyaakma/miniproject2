<?php

class Student {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Find student by username - used during login
    public function getByUsername($username) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM students WHERE username = :username"
        );
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Find student by ID - used for profile
    public function getById($id) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM students WHERE id = :id"
        );
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update password
    public function updatePassword($id, $hashedPassword) {
        $stmt = $this->conn->prepare(
            "UPDATE students 
             SET password = :password 
             WHERE id = :id"
        );

        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Check if username already exists
    public function usernameExists($username) {
        $stmt = $this->conn->prepare(
            "SELECT id FROM students WHERE username = :username"
        );

        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    // Register new student
    public function register($name, $nric, $program, $username, $hashedPassword) {
        $stmt = $this->conn->prepare(
            "INSERT INTO students 
            (name, nric, program, username, password)
            VALUES 
            (:name, :nric, :program, :username, :password)"
        );

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':nric', $nric);
        $stmt->bindParam(':program', $program);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);

        return $stmt->execute();
    }

    // Update student information
    public function updateStudent($id, $name, $program) {
        $stmt = $this->conn->prepare(
            "UPDATE students 
             SET name = :name, program = :program 
             WHERE id = :id"
        );

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':program', $program);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Delete student account
    public function deleteStudent($id) {
        $stmt = $this->conn->prepare(
            "DELETE FROM students WHERE id = :id"
        );

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Update profile picture
    public function updateProfilePicture($id, $filename) {
        $stmt = $this->conn->prepare(
            "UPDATE students 
             SET profile_picture = :profile_picture 
             WHERE id = :id"
        );

        $stmt->bindParam(':profile_picture', $filename);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}

?>