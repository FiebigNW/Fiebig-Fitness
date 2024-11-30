<?php
session_start();
if (!isset($_SESSION['AccountID'])) {
    // Redirect to login page if not logged in
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collecting user inputs
    $foodAdded = $_POST["breakfastInput"];
    $calories = $_POST['breakfastCalorieInput'];
    $carbs = $_POST['breakfastCarbsInput'];
    $fats = $_POST['breakfastFatsInput'];
    $protein = $_POST['breakfastProteinInput'];
    $sodium = $_POST['breakfastSodiumInput'];
    $sugar = $_POST['breakfastSugarInput'];
    $accountID = $_SESSION['AccountID'];
    $date = date('Y-m-d');  // Ensure this format matches your database
    $meal_type = "Breakfast";

    // Validate inputs (basic checks to avoid empty fields and non-numeric values for nutrients)
    if (empty($foodAdded) || empty($calories) || empty($carbs) || empty($fats) || empty($protein) || empty($sodium) || empty($sugar)) {
        die("Invalid input. Please make sure all fields are filled correctly.");
    }

    try {
        require_once "dbConnection.php";

        // Insert data into the Nutrition table
        $query = "INSERT INTO Nutrition (AccountID, Food_Name, Calories, Carbs, Fats, Protein, Sodium, Sugar, Food_Added_Date, Meal_Type) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$accountID, $foodAdded, $calories, $carbs, $fats, $protein, $sodium, $sugar, $date, $meal_type]);

        // Close the connection and redirect
        $pdo = null;
        $stmt = null;
        header("Location: food.php");  // Redirect after submission
        die();
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
} else {
    header("Location: food.php");  // Redirect if not POST
}
?>
