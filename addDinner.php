<?php
session_start();
if (!isset($_SESSION['AccountID'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $foodAdded = $_POST["dinnerInput"];
    $calories = $_POST['dinnerCalorieInput'];
    $carbs = $_POST['dinnerCarbsInput'];
    $fats = $_POST['dinnerFatsInput'];
    $protein = $_POST['dinnerProteinInput'];
    $sodium = $_POST['dinnerSodiumInput'];
    $sugar = $_POST['dinnerSugarInput'];
    $accountID = $_SESSION['AccountID'];
    $date = date('Y-m-d'); 
    $meal_type = "Dinner";

    if (empty($foodAdded) || empty($calories) || empty($carbs) || empty($fats) || empty($protein) || empty($sodium) || empty($sugar)) {
        $_SESSION['errorMessage'] = "Invalid input. Please make sure all fields are filled correctly.";
        header("Location: EnterDinnerInfo.php");  
        die();
    }

    try {
        require_once "dbConnection.php";

        $query = "INSERT INTO Nutrition (AccountID, Food_Name, Calories, Carbs, Fats, Protein, Sodium, Sugar, Food_Added_Date, Meal_Type) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$accountID, $foodAdded, $calories, $carbs, $fats, $protein, $sodium, $sugar, $date, $meal_type]);

       
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
