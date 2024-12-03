<?php
session_start();
if (!isset($_SESSION['AccountID'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accountID = $_SESSION['AccountID'];
    if (isset($_POST["generateRandomWorkout"])) {
        
        $workoutPlans = [
            "Split 1" => [
                "Chest/Tri/Shoulders" => ['Bench Press', 'Push-ups', 'Dumbbell Flyes', 'Overhead Press', 'Tricep Dips'],
                "Back/Bi/Core" => ['Deadlifts', 'Pull-ups', 'Barbell Rows', 'Bicep Curls', 'Planks'],
                "Legs" => ['Squats', 'Leg Press', 'Lunges', 'Leg Curls', 'Calf Raises']
            ],
            "Split 2" => [
                "Push" => ['Bench Press', 'Overhead Press', 'Tricep Dips', 'Incline Press', 'Chest Flyes'],
                "Pull" => ['Deadlifts', 'Pull-ups', 'Barbell Rows', 'Lat Pulldown', 'Face Pulls'],
                "Legs" => ['Squats', 'Leg Press', 'Lunges', 'Leg Curls', 'Calf Raises']
            ],
        ];
        
        $selectedPlan = array_rand($workoutPlans);
        $workoutName = $selectedPlan;

        $dayOnePlan = $dayTwoPlan = $dayThreePlan = $dayFourPlan = $dayFivePlan = $daySixPlan = $daySevenPlan = "";


        $randomWorkout = [];
        foreach ($workoutPlans[$selectedPlan] as $day => $exercises) {
            shuffle($exercises); 
            $randomWorkout[$day] = implode(", ", array_slice($exercises, 0, 3)); 
        }

        $dayOnePlan = $randomWorkout["Chest/Tri/Shoulders"] ?? $randomWorkout["Push"];
        $dayTwoPlan = $randomWorkout["Back/Bi/Core"] ?? $randomWorkout["Pull"];
        $dayThreePlan = $randomWorkout["Legs"];
        $dayFourPlan = $randomWorkout["Push"] ?? "Cardio";
        $dayFivePlan = $randomWorkout["Pull"] ?? "";
        $daySixPlan = $randomWorkout["Legs"]  ?? "";
        $daySevenPlan = $randomWorkout["Chest/Tri/Shoulders"] ?? $randomWorkout["Back/Bi/Core"] ?? "";

    } else {
            $workoutName = $_POST["workoutName"];
            $dayOnePlan = $_POST["workoutDayOne"];
            $dayTwoPlan = $_POST["workoutDayTwo"];
            $dayThreePlan = $_POST["workoutDayThree"];
            $dayFourPlan = $_POST["workoutDayFour"];
            $dayFivePlan = $_POST["workoutDayFive"];
            $daySixPlan = $_POST["workoutDaySix"];
            $daySevenPlan = $_POST["workoutDaySeven"];

            if(empty($workoutName)){
                $_SESSION['errorMessage'] = "Invalid input. Please enter a name.";
                header("Location: EnterWorkoutInfo.php");  
                die();
            }
        }

    try {
        require_once "dbConnection.php";

        $query = "SELECT * FROM Workout WHERE AccountID = :accountID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':accountID', $accountID);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $updateQuery = "UPDATE Workout 
                            SET Name = ?, DayOne = ?, DayTwo = ?, DayThree = ?, DayFour = ?, DayFive = ?, DaySix = ?, DaySeven = ? 
                            WHERE AccountID = ?";
            $stmt = $pdo->prepare($updateQuery);
            $stmt->execute([$workoutName, $dayOnePlan, $dayTwoPlan, $dayThreePlan, $dayFourPlan, $dayFivePlan, $daySixPlan, $daySevenPlan, $accountID]);
        } else {
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

        header("Location: workout.php");
        exit();
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    } 
} else {
    header("Location: index.php");
}

?>
