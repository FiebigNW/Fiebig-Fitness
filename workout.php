
<?php
    session_start();
    if (!isset($_SESSION['AccountID'])) {
        header("Location: index.php");
        exit();
    }
    
    $accountID = $_SESSION['AccountID'];

    try {
        require_once "dbConnection.php";  

        // Query all workout plan data in one go
        $query = "SELECT Name, DayOne, DayTwo, DayThree, DayFour, DayFive, DaySix, DaySeven FROM Workout WHERE AccountID = :accountID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':accountID', $accountID);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $name = $result['Name'] ?? 'Not set';
        $dayOnePlan = $result['DayOne'] ?? 'Not set';
        $dayTwoPlan = $result['DayTwo'] ?? 'Not set';
        $dayThreePlan = $result['DayThree'] ?? 'Not set';
        $dayFourPlan = $result['DayFour'] ?? 'Not set';
        $dayFivePlan = $result['DayFive'] ?? 'Not set';
        $daySixPlan = $result['DaySix'] ?? 'Not set';
        $daySevenPlan = $result['DaySeven'] ?? 'Not set';

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
    
    <div id="workoutHome">
        <h3 style="font-style: italic; text-align: center;">Current Workout Plan</h3>

        <br>

        <div id="workoutLayout">
            <h4>Current Workout Plan:  </h4>
            
            <?php
                echo isset($name) && $name != 'Not set' ? '<p>Workout Name: ' . htmlspecialchars($name) . '</p>' : '<p>No workout plan set.</p>';
                
                $daysOfWeek = [
                    'Day 1' => $dayOnePlan,
                    'Day 2' => $dayTwoPlan,
                    'Day 3' => $dayThreePlan,
                    'Day 4' => $dayFourPlan,
                    'Day 5' => $dayFivePlan,
                    'Day 6' => $daySixPlan,
                    'Day 7' => $daySevenPlan,
                ];

                foreach ($daysOfWeek as $day => $plan) {
                    if (!empty($plan)) {
                        echo '<p>' . htmlspecialchars($day) . ': ' . htmlspecialchars($plan) . '</p>';
                    }
                }
            ?>
        </div>
    </div>

    <div id="dateChangeButtons">
        <div style="flex-grow: 0.4;"></div>    
        <div> 
            <a href="EnterWorkoutInfo.php"><button class="loginButton" id="createOwnWorkout">Create Workout Plan</button></a>
        </div>
        <div style="flex-grow: 0.2;"></div>  
        <div> 
            <button class="loginButton" id="generateRandomWorkout">Generate Random Workout</button>
        </div>
        <div style="flex-grow: 0.4;"></div>  
    </div>
</html>
