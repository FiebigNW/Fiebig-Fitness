<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["usernameInput"];
    $password = $_POST["passwordInput"];

    if (empty($username) || empty($password)) {
        $_SESSION['errorMessage'] = "Username or password cannot be empty.";
        header("Location: index.php"); 
        exit();
    }

    try {
        require_once "dbConnection.php";

        $query = "SELECT * FROM Account WHERE Username = :username";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $account = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($account == null) {
            $_SESSION['errorMessage'] = "Account does not exist.";
            header("Location: index.php"); 
            exit();
        } else {
            if (password_verify($password, $account['Password'])) {
                $_SESSION['AccountID'] = $account['AccountID'];
                $_SESSION['Username'] = $account['Username'];

                unset($_SESSION['errorMessage']);

                header("Location: home.php");
                exit();
            } else {
                $_SESSION['errorMessage'] = "Invalid username or password.";
                header("Location: index.php");  
                exit();
            }
        }
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
} else {
    header("Location: index.php");
    exit();
}
?>
