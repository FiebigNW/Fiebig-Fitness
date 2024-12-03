<?php
session_start();

if (!isset($_SESSION['AccountID'])) {
    header("Location: index.php"); 
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newPassword = $_POST["changePasswordInput"];
    $accountID = $_SESSION['AccountID'];

    if (empty($newPassword)) {
        $_SESSION['errorMessage'] = "Password cannot be empty!";
        header("Location: changePasswordScreen.php"); 
        exit();
    }

    if (strlen($newPassword) < 8) {
        $_SESSION['errorMessage'] = "Password must be at least 8 characters.";
        header("Location: changePasswordScreen.php");
        exit();
    }

    $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    try {
        require_once "dbConnection.php";

        $query = "UPDATE Account SET Password = :newPassword WHERE AccountID = :accountID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':accountID', $accountID);
        $stmt->bindParam(':newPassword', $hashedNewPassword);
        $stmt->execute();

        $pdo = null;
        $stmt = null;

        $_SESSION['successMessage'] = "Your password has been successfully updated!";
        header("Location: changePasswordScreen.php");
        exit();

    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
} else {
    header("Location: changePasswordScreen.php");
    exit();
}
?>
