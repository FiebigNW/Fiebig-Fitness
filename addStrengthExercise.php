<?php
session_start();

if (!isset($_SESSION['AccountID'])) {
    header("Location: index.php");
    exit();
}

$accountID = $_SESSION['AccountID'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exerciseName = $_POST['exerciseNameInput'];
    $exerciseDate = $_POST['exerciseDate']; 
    $caloriesBurned =  $_POST['caloriesBurnedInput']; 
    $exerciseType = 'Strength';
    
    if (empty($exerciseName) || empty($caloriesBurned)) {
        $_SESSION['errorMessage'] = "Invalid input. Please make sure all fields are filled correctly.";
        header("Location: EnterStrengthInfo.php");  
        die();
    }else{
        try {
            require_once "dbConnection.php";
           
            $query = "INSERT INTO Exercises(AccountID, ExerciseName, Exercise_Date, Exercise_Type, Calories_Burned) VALUES (?, ?, ?, ?, ?);";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$accountID, $exerciseName, $exerciseDate, $exerciseType, $caloriesBurned]);
    
            $pdo = null;
            $stmt = null;
            header("Location: exercise.php");  
            die();
        } catch (PDOException $e) {
            die("Query Failed: " . $e->getMessage());
        }
    }

   
} else {
    header("Location: exercise.php"); 
}
?>
