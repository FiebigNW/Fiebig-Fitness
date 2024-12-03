<?php
session_start();
if (!isset($_SESSION['AccountID'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $foodAdded = $_POST["breakfastInput"];
    $calories = $_POST['breakfastCalorieInput'];
    $carbs = $_POST['breakfastCarbsInput'];
    $fats = $_POST['breakfastFatsInput'];
    $protein = $_POST['breakfastProteinInput'];
    $sodium = $_POST['breakfastSodiumInput'];
    $sugar = $_POST['breakfastSugarInput'];
    $accountID = $_SESSION['AccountID'];
    $date = date('Y-m-d');  
    $meal_type = "Breakfast";

    if (empty($foodAdded) || empty($calories) || empty($carbs) || empty($fats) || empty($protein) || empty($sodium) || empty($sugar)) {
        $_SESSION['errorMessage'] = "Invalid input. Please make sure all fields are filled correctly.";
        header("Location: EnterBreakfastInfo.php");  
        die();
    }

    try {
        require_once "dbConnection.php";

       
        $pdo = null;
        $stmt = null;
        header("Location: food.php");  
        die();
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
} else {
    header("Location: food.php"); 
}
?>
