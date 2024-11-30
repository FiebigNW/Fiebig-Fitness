<?php
session_start();
    if (!isset($_SESSION['AccountID'])) {
        // Redirect to login page if not logged in
        header("Location: index.php");
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $newExerciseGoal = $_POST["updateExerciseInput"];
        $accountID = $_SESSION['AccountID'];

        if(empty($newExerciseGoal)){
            $_SESSION['errorMessage'] = "Exercise Goal cannot be empty.";
            header("Location: goals.php"); 
            exit();
        } else if($newExerciseGoal < 0){
            $_SESSION['errorMessage'] = "Exercise Goal cannot be negative.";
            header("Location: goals.php"); 
            exit();
        }
        

        try{
            require_once "dbConnection.php";

            $query = "UPDATE Account SET Exercise_Goal = :newExerciseGoal WHERE AccountID = :accountID";           
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':accountID', $accountID);
            $stmt->bindParam(':newExerciseGoal', $newExerciseGoal);
            $stmt->execute();
            $pdo = null;
            $stmt = null;
            header("Location: goals.php");
            die();
        } catch(PDOException $e){
            die("Query Failed: " . $e -> getMessage());
        }

    } else{
        header("Location: index.php");
    }