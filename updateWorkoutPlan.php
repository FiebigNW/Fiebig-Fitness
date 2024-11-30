<?php
session_start();
if (!isset($_SESSION['AccountID'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $workoutName = $_POST["workoutName"];
    $dayOnePlan = $_POST["workoutDayOne"];
    $dayTwoPlan = $_POST["workoutDayTwo"];
    $dayThreePlan = $_POST["workoutDayThree"];
    $dayFourPlan = $_POST["workoutDayFour"];
    $dayFivePlan = $_POST["workoutDayFive"];
    $daySixPlan = $_POST["workoutDaySix"];
    $daySevenPlan = $_POST["workoutDaySeven"];

    $accountID = $_SESSION['AccountID'];

    // Validation: Check if input is empty
    if (empty($workoutName)) {
        $_SESSION['errorMessage'] = "Workout Name cannot be empty.";
        header("Location: workout.php");
        exit();
    }

    try {
        require_once "dbConnection.php";

        // Check if workout plan exists
        $query = "SELECT * FROM Workout WHERE AccountID = :accountID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':accountID', $accountID);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Update existing workout plan
            $updateQuery = "UPDATE Workout 
                            SET Name = ?, DayOne = ?, DayTwo = ?, DayThree = ?, DayFour = ?, DayFive = ?, DaySix = ?, DaySeven = ? 
                            WHERE AccountID = ?";
            $stmt = $pdo->prepare($updateQuery);
            $stmt->execute([$workoutName, $dayOnePlan, $dayTwoPlan, $dayThreePlan, $dayFourPlan, $dayFivePlan, $daySixPlan, $daySevenPlan, $accountID]);
        } else {
            // Insert new workout plan
            $insertQuery = "INSERT INTO Workout (AccountID, Name, DayOne, DayTwo, DayThree, DayFour, DayFive, DaySix, DaySeven) 
                            VALUES (:accountID, :workoutName, :dayOnePlan, :dayTwoPlan, :dayThreePlan, :dayFourPlan, :dayFivePlan, :daySixPlan, :daySevenPlan)";
            $stmt = $pdo->prepare($insertQuery);
            $stmt->bindParam(':accountID', $accountID);
            $stmt->bindParam(':workoutName', $workoutName);
            $stmt->bindParam(':dayOnePlan', $dayOnePlan);
            $stmt->bindParam(':dayTwoPlan', $dayTwoPlan);
            $stmt->bindParam(':dayThreePlan', $dayThreePlan);
            $stmt->bindParam(':dayFourPlan', $dayFourPlan);
            $stmt->bindParam(':dayFivePlan', $dayFivePlan);
            $stmt->bindParam(':daySixPlan', $daySixPlan);
            $stmt->bindParam(':daySevenPlan', $daySevenPlan);
            $stmt->execute();
        }

        header("Location: EnterWorkoutInfo.php");
        exit();
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }

} else {
    header("Location: index.php");
}
?>
