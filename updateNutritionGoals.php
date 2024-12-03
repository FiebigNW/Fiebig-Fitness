<?php
session_start();

if (!isset($_SESSION['AccountID'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accountID = $_SESSION['AccountID'];
    $newCalorieGoal = $_POST["updateCalorieInput"];

    if (isset($_POST["deficitButton"]) && empty($newCalorieGoal)) {
        $calorieAdjustment = -250; 
    } elseif (isset($_POST["surplusButton"]) && empty($newCalorieGoal)) {
        $calorieAdjustment = 250;  
    } else {
        $calorieAdjustment = 0;
    }

    if (empty($newCalorieGoal) && $calorieAdjustment == 0)  {
        $_SESSION['errorMessage'] = "Calorie Goal cannot be empty.";
        header("Location: goals.php");
        exit();
    }
    else if ($newCalorieGoal < 0 && $calorieAdjustment == 0) {
        $_SESSION['errorMessage'] = "Calorie Goal cannot be negative.";
        header("Location: goals.php");
        exit();
    }

    try {
        require_once "dbConnection.php";


        if ($calorieAdjustment != 0) {
            $query = "SELECT Nutrition_Goal FROM Account WHERE AccountID = :accountID";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':accountID', $accountID, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $currentGoal = $result['Nutrition_Goal'];

            $newCalorieGoal = $currentGoal + $calorieAdjustment;

            $query = "UPDATE Account SET Nutrition_Goal = :newCalorieGoal WHERE AccountID = :accountID";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':accountID', $accountID, PDO::PARAM_INT);
            $stmt->bindParam(':newCalorieGoal', $newCalorieGoal, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            $query = "UPDATE Account SET Nutrition_Goal = :newCalorieGoal WHERE AccountID = :accountID";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':accountID', $accountID, PDO::PARAM_INT);
            $stmt->bindParam(':newCalorieGoal', $newCalorieGoal, PDO::PARAM_INT);
            $stmt->execute();
        }

        $pdo = null;
        $stmt = null;

        header("Location: goals.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['errorMessage'] = "Database error: " . $e->getMessage();
        header("Location: goals.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
