<?php
    session_start();
    if (!isset($_SESSION['AccountID'])) {
        // Redirect to login page if not logged in
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
        <h3 style = "font-style: italic; text-align: center;">Enter Dinner: <?php echo htmlspecialchars($dateView);?></h3>
        
        <br>
        
        <div id = "enterFood">
            <h4>Dinner</h4>
            <form action = "addDinner.php" method = "POST">
                <label for = "dinnerInput">Name</label>
                <input type = "text" name = "dinnerInput" placeholder="Type Lunch Name" style = "width: 150px;"></input>

                <br>

                <label for = "dinnerCalorieInput">Calories</label>
                <input type = "text" name = "dinnerCalorieInput" placeholder="Amount Of Calories" style = "width: 150px;"></input>

                <br>

                <label for = "dinnerCarbsInput">Carbs</label>
                <input type = "text" name = "dinnerCarbsInput" placeholder="Enter Carbs" style = "width: 150px;"></input>

                <br>

                <label for = "dinnerFatsInput">Fats</label>
                <input type = "text" name = "dinnerFatsInput" placeholder="Enter Fats" style = "width: 150px;"></input>

                <br>

                <label for = "dinnerProteinInput">Protein</label>
                <input type = "text" name = "dinnerProteinInput" placeholder="Enter Protein" style = "width: 150px;"></input>

                <br>

                <label for = "dinnerSodiumInput">Sodium</label>
                <input type = "text" name = "dinnerSodiumInput" placeholder="Enter Sodium" style = "width: 150px;"></input>
 
                <br>

                <label for="dinnerSugarInput">Sugar</label>
                <input type="text" name="dinnerSugarInput" placeholder="Enter Sugar" style="width: 150px;"></input>

                <br><br>               
                
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