<?php
    session_start();
    if (!isset($_SESSION['AccountID'])) {
        header("Location: index.php");
        exit();
    }
    
    $accountID = $_SESSION['AccountID'];

    try {
        require_once "dbConnection.php";  
        
        $dateView = date('d M Y');

       

    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
    
?>

<html>
    <link rel="stylesheet" href="FiebigsFitness.css">
    <div id = homeTitle>
        <div> 
            <h2 style = "color: rgb(33, 184, 184)">Fiebig</h2>
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

    <br><br>
    
    <div id = "enterFoodLayout">
        <h3 style = "font-style: italic; text-align: center;">Enter Lunch: <?php echo htmlspecialchars($dateView);?></h3>
        
        <br>
        
        <div id = "enterFood">
            <h4>Lunch</h4>
            <form action = "addLunch.php" method = "POST">
                <label for = "lunchInput">Name</label>
                <input type = "text" name = "lunchInput" placeholder="Type Lunch Name" style = "width: 150px;" autocomplete="off"></input>

                <br>

                <label for = "lunchCalorieInput">Calories</label>
                <input type = "text" name = "lunchCalorieInput" placeholder="Amount Of Calories" style = "width: 150px;" autocomplete="off"></input>

                <br>

                <label for = "lunchCarbsInput">Carbs</label>
                <input type = "text" name = "lunchCarbsInput" placeholder="Enter Carbs" style = "width: 150px;" autocomplete="off"></input>

                <br>

                <label for = "lunchFatsInput">Fats</label>
                <input type = "text" name = "lunchFatsInput" placeholder="Enter Fats" style = "width: 150px;" autocomplete="off"></input>

                <br>

                <label for = "lunchProteinInput">Protein</label>
                <input type = "text" name = "lunchProteinInput" placeholder="Enter Protein" style = "width: 150px;" autocomplete="off"></input>

                <br>

                <label for = "lunchSodiumInput">Sodium</label>
                <input type = "text" name = "lunchSodiumInput" placeholder="Enter Sodium" style = "width: 150px;" autocomplete="off"></input>
               
                <br>

                <label for="lunchSugarInput">Sugar</label>
                <input type="text" name="lunchSugarInput" placeholder="Enter Sugar" style="width: 150px;" autocomplete="off"></input>
                
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