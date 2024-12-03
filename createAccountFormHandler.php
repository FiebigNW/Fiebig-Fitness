<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["createUsernameInput"];
    $password = $_POST["createPasswordInput"];

    if (empty($username) || empty($password)) {
        $_SESSION['errorMessage'] = "Username or password cannot be empty.";
        header("Location: createAccount.php"); 
        exit();
    }

    try {
        require_once "dbConnection.php";

        $query = "SELECT Username FROM Account WHERE Username = :username";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result == null) {
            $accountID = substr(uniqid(rand(), true), 0, 15);
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT); 
            
            echo $password;
            echo $hashedPassword;

            $query = "INSERT INTO Account (AccountID, Username, Password) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$accountID, $username, $hashedPassword]);

            $pdo = null;
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['errorMessage'] = "Username Taken: Please choose a different username.";
            header("Location: createAccount.php"); 
            exit();
        }
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
}
?>
