<?php
    session_start();
    if (!isset($_SESSION['AccountID'])) {
        header("Location: index.php");
        exit();
    }
    
    $accountID = $_SESSION['AccountID'];
    $dateView = date('Y-m-d');

    try {
        require_once "dbConnection.php";  
        
        $query = "SELECT Exercise_Goal FROM Account WHERE AccountID = :accountID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':accountID', $accountID);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $exerciseGoal = $result['Exercise_Goal'] ?? 'Not set'; 

        $query = "SELECT Nutrition_Goal FROM Account WHERE AccountID = :accountID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':accountID', $accountID);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $nutritionGoal = $result['Nutrition_Goal'] ?? 'Not set';
        
        $query = "SELECT Username FROM Account WHERE AccountID = :accountID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':accountID', $accountID);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $accountUsername = $result['Username'];

        $query = "SELECT SUM(Calories) AS totalCalories FROM Nutrition WHERE AccountID = :accountID AND Food_Added_Date = :dateAdded";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':accountID', $accountID);
        $stmt->bindParam(':dateAdded', $dateView);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $caloriesHasToday = $result['totalCalories'] ?? 0;

    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
?>

<html>
    <link rel="stylesheet" href="FiebigsFitness.css">
    <div id="homeTitle">
        <div> 
            <h2 style="color: rgb(33, 184, 184)">Fiebig</h2>
            <h2 style="color: lightblue;">Fitness</h2>
        </div>
        <div style="flex-grow: 1;"></div>
        <div>
            <a href="settings.php"><button id="titleButton">Settings</button></a>
            <a href="logout.php"><button id="titleButton">Logout</button></a>
        </div>
    </div>  
    
    <div id="homeButtonsContainer">
        <a href="home.php"><button id="homeButtons">Home</button></a>
        <a href="food.php"><button id="homeButtons">Food</button></a>
        <a href="exercise.php"><button id="homeButtons">Exercise</button></a>
        <a href="goals.php"><button id="homeButtons">Goals</button></a>
        <a href="bmi.php"><button id="homeButtons">BMI</button></a>
        <a href="calorieCalc.php"><button id="homeButtons">Calorie Calculator</button></a>
        <a href="workout.php"><button id="homeButtons">Workouts</button></a>
    </div>

    <br><br>
    
    <div id="homeProfile">
        <h3 style="font-style: italic; text-align: center;">Welcome <?php echo htmlspecialchars($accountUsername)?></h3>
        <div id="caloriesLayout">
            <div>
                <!-- Display the remaining calories with visual progress -->
                <h4 style="text-align: center;">
                    <?php 
                        $remainingCalories = $nutritionGoal - $caloriesHasToday;
                        if ($remainingCalories >= 0) {
                            echo "You have " . htmlspecialchars($remainingCalories) . " Calories left.";
                            $progress = ($caloriesHasToday / $nutritionGoal) * 100;
                            $color = "green"; 
                        } else {
                            echo "You are " . htmlspecialchars(abs($remainingCalories)) . " Calories over.";
                            $progress = 100; 
                            $color = "red"; 
                        }
                    ?>
                </h4>
                <!-- Progress Bar -->
                <div style="width: 100%; background-color: #e0e0e0; border-radius: 10px; height: 30px; margin-top: 10px;">
                    <div style="width: <?php echo $progress; ?>%; background-color: <?php echo $color; ?>; height: 100%; border-radius: 10px;"></div>
                </div>
            </div>
            <div style="flex-grow: 1;"></div>
            <div>
                <h4>Goal: <?php echo htmlspecialchars($nutritionGoal); ?> Calories</h4>
                <h4>Exercise Goal: <?php echo htmlspecialchars($exerciseGoal); ?> Workouts</h4>
            </div>
        </div>
    </div>
</html>
