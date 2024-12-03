<?php
session_start();
if (!isset($_SESSION['AccountID'])) {
    header("Location: index.php");
    exit();
}

$accountID = $_SESSION['AccountID'];

if (isset($_GET['date'])) {
    $dateView = $_GET['date'];
} else {
    $dateView = date('Y-m-d');
}

if (isset($_GET['moveBackwards'])) {
    $dateView = date('Y-m-d', strtotime($dateView . ' -1 day'));
} elseif (isset($_GET['moveForwards'])) {
    $dateView = date('Y-m-d', strtotime($dateView . ' +1 day'));
}

$formattedDate = date('d M Y', strtotime($dateView));

try {
    require_once "dbConnection.php";  
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<html>
    <link rel="stylesheet" href="FiebigsFitness.css">
    <div id = homeTitle>
        <div> 
            <h2 style = "color: rgb(33, 184, 1s4)">Fiebig</h2>
            <h2 style = "color: lightblue;">Fitness</h2>
        </div>
        <div style = "flex-grow: 1;">
        </div>
        <div>
            <a href = "settings.php"><button id = "titleButton">Settings</button></a>
            <a href = "logout.php"><button id = "titleButton">Logout</button></a>
        </div>
        <style>
            .error-message {
                color: red;
                margin-bottom: 10px;
                padding: 5px;
                text-align: center;
            }
        </style>
    </div>  
    
    <div id = 'homeButtonsContainer'>
        <a href = "home.php"><button id = "homeButtons">Home</button></a>
        <a href = "food.php"><button id = "homeButtons">Food</button></a>
        <a href = "exercise.php"><button id = "homeButtons" >Exercise</button></a>
        <a href = "goals.php"><button id = "homeButtons" >Goals</button></a>
        <a href = "bmi.php"><button id = "homeButtons" >BMI</button></a>
        <a href = "calorieCalc.php"><button id = "homeButtons" >Calorie Calulator</button></a>
        <a href = "workout.php"><button id = "homeButtons" >Workouts</button></a>
    </div>


    <div id="enterFoodLayout">
        <h3 style="font-style: italic; text-align: center;">Enter Breakfast: <?php echo htmlspecialchars($formattedDate);?></h3>
        
        <br>
        
        <div id="enterFood">
            <h4>Breakfast</h4>
            <form action="addBreakfast.php" method="POST">
                <label for="breakfastInput">Name</label>
                <input type="text" name="breakfastInput" placeholder="Type Breakfast Name" style="width: 150px;" autocomplete="off"></input>

                <br>

                <label for="breakfastCalorieInput">Calories</label>
                <input type="text" name="breakfastCalorieInput" placeholder="Amount Of Calories" style="width: 150px;" autocomplete="off"></input>

                <br>

                <label for="breakfasCarbsInput">Carbs</label>
                <input type="text" name="breakfastCarbsInput" placeholder="Enter Carbs" style="width: 150px;" autocomplete="off"></input>

                <br>

                <label for="breakfastFatsInput">Fats</label>
                <input type="text" name="breakfastFatsInput" placeholder="Enter Fats" style="width: 150px;" autocomplete="off"></input>

                <br>

                <label for="breakfastProteinInput">Protein</label>
                <input type="text" name="breakfastProteinInput" placeholder="Enter Protein" style="width: 150px;" autocomplete="off"></input>

                <br>

                <label for="breakfastSodiumInput">Sodium</label>
                <input type="text" name="breakfastSodiumInput" placeholder="Enter Sodium" style="width: 150px;" autocomplete="off"></input>

                <br>

                <label for="breakfastSugarInput">Sugar</label>
                <input type="text" name="breakfastSugarInput" placeholder="Enter Sugar" style="width: 150px;" autocomplete="off"></input>
                
                <br><br>
                
                <?php
                    if (isset($_SESSION['errorMessage'])) {
                        echo '<p class="error-message">' . htmlspecialchars($_SESSION['errorMessage']) . '</p>';
                        unset($_SESSION['errorMessage']);
                    }
                ?>

                
                <div id = dateChangeButtons>    
                    <div> 
                        <a href="food.php"><button type="button" class="loginButton" name="backButton">Back</button></a>
                    </div>
                        <div style = "flex-grow: 1;"></div>
                    <div> 
                        <button type = "submit" class="loginButton">Submit</button>
                    </div>
                <div>
            </form>
        </div>  
    </div>
</html>
