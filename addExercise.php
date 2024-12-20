<?php
session_start();

if (!isset($_SESSION['AccountID'])) {
    header("Location: index.php");
    exit();
}

$accountID = $_SESSION['AccountID'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exerciseName = $_POST['exerciseName'];
    $exerciseDate = $_POST['exerciseDate'];  
    $exerciseType = 'Strength';
    
    try {
        require_once "dbConnection.php";
       
        $query = "INSERT INTO Exercises(AccountID, ExerciseName, Exercise_Date, Exercise_Type) VALUES (?, ?, ?, ?);";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$accountID, $exerciseName, $exerciseDate, $exerciseType]);

        $pdo = null;
        $stmt = null;
        header("Location: exercise.php");  
        die();
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
} else {
    header("Location: exercise.php"); 
}
?>
