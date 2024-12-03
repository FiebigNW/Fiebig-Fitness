<?php
    session_start();
    if (!isset($_SESSION['AccountID'])) {
        header("Location: index.php");
        exit();
    }

    $accountID = $_SESSION['AccountID'];

    $calorieAdjustment = 250;

    try {
        require_once "dbConnection.php";  

        $query = "SELECT Nutrition_Goal FROM Account WHERE AccountID = :accountID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':accountID', $accountID);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $nutritionGoal = $result['Nutrition_Goal'] ?? 'Not set'; 

        $query = "SELECT Exercise_Goal FROM Account WHERE AccountID = :accountID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':accountID', $accountID);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $exerciseGoal = $result['Exercise_Goal'] ?? 'Not set'; 

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['deficitButton'])) {
                $newGoal = $nutritionGoal - $calorieAdjustment;
                $query = "UPDATE Account SET Nutrition_Goal = :newGoal WHERE AccountID = :accountID";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':newGoal', $newGoal);
                $stmt->bindParam(':accountID', $accountID);
                $stmt->execute();
                $nutritionGoal = $newGoal;  
            } elseif (isset($_POST['surplusButton'])) {

                $newGoal = $nutritionGoal + $calorieAdjustment;
                $query = "UPDATE Account SET Nutrition_Goal = :newGoal WHERE AccountID = :accountID";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':newGoal', $newGoal);
                $stmt->bindParam(':accountID', $accountID);
                $stmt->execute();
                $nutritionGoal = $newGoal;  
            }
        }

    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
?>

<html>
    <style>
        .error-message {
            color: red;
            margin-bottom: 10px;
            padding: 5px;
            text-align: center;
        }
    </style>

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
    
    <div id="goalsHome">
        <h3 style="font-style: italic; text-align: center;">Current Goals</h3>
        <br>

        <div id="goalLayout">
            <h4>Current Calorie Goal: <?php echo htmlspecialchars($nutritionGoal); ?></h4>

            <form action="updateNutritionGoals.php" method="POST">
                <input type="number" name="updateCalorieInput" placeholder="Update Calorie Goal" autocomplete="off">
                <button type="submit" class="loginButton" id="updateNutrition">Update</button>
            </form>

            <div id="dateChangeButtons">    
                <div> 
                    <form action="updateNutritionGoals.php" method="POST">
                        <button type="submit" name="deficitButton" class="loginButton">Deficit</button>
                    </form>
                </div>

                <div style="flex-grow: 1;"></div>

                <div>
                    <form action="updateNutritionGoals.php" method="POST">
                        <button type="submit" name="surplusButton" class="loginButton">Surplus</button>
                    </form>
                </div>
            </div>

            <h4>Current Exercise Goal: <?php echo htmlspecialchars($exerciseGoal); ?></h4>
            <form action="updateExerciseGoals.php" method="POST">            
                <input type="number" name="updateExerciseInput" placeholder="Update Exercise Goal" autocomplete="off">
                <button type="submit" class="loginButton" id="updateExercise">Update</button>
            </form>

            <?php
                if (isset($_SESSION['errorMessage'])) {
                    echo '<p class="error-message">' . htmlspecialchars($_SESSION['errorMessage']) . '</p>';
                    unset($_SESSION['errorMessage']);
                }
            ?>
        </div>
    </div>
</html>
