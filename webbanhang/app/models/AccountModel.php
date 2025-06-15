<?php
class AccountModel
{
    private $conn;
    private $table_name = "account";
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function getAccountByUsername($username)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username
LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    public function save($username, $fullName, $password, $role = 'user')
    {
        if ($this->getAccountByUsername($username)) {
            return false;
        }
        $query = "INSERT INTO " . $this->table_name . " SET username=:username,
fullname=:fullname, password=:password, role=:role";
        $stmt = $this->conn->prepare($query);
        $username = htmlspecialchars(strip_tags($username));
        $fullName = htmlspecialchars(strip_tags($fullName));
        $password = password_hash($password, PASSWORD_BCRYPT);
        $role = htmlspecialchars(strip_tags($role));
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":fullname", $fullName);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":role", $role);
        return $stmt->execute();
    }
    public function getStaffAccounts()
    {
        $query = "SELECT * FROM account WHERE role != 'user'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function updateRole($id, $role)
    {
        $query = "UPDATE account SET role = :role WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function getAccountById($id)
{
    $stmt = $this->conn->prepare("SELECT * FROM account WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
}

public function deleteAccount($id)
{
    $stmt = $this->conn->prepare("DELETE FROM account WHERE id = :id");
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}
public function updateAccountInfo($id, $fullname, $role)
{
    $query = "UPDATE account SET fullname = :fullname, role = :role WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':fullname', $fullname);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}

}
