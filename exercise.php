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

$exerciseTypes = ['Cardio', 'Strength'];
$exerciseData = [];

foreach ($exerciseTypes as $exerciseType) {
    $query = "SELECT ExerciseName, Calories_Burned
            FROM Exercises
            WHERE AccountID = :accountID AND Exercise_Type = :exerciseType AND Exercise_Date = :date";

    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':accountID' => $accountID,
        ':exerciseType' => $exerciseType,
        ':date' => $dateView
    ]);
    
    $exerciseData[$exerciseType] = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
 

    <div id="exerciseHome">
        <h3 style="font-style: italic; text-align: center;">Exercise Diary For Date: <?php echo htmlspecialchars($formattedDate);?></h3>

        <br>

        <div id="exerciseLayout">

        <div id="exerciseHeadersLayout"> 
            <div style="display: flex; flex-wrap: nowrap; gap: 10px; justify-content: start; align-items: center;">
                <div style="flex-grow: 1;"></div>
                <h4 style="border: solid; padding: 3px;">Name</h4>
                <h4 style="border: solid; padding: 3px;">Calories Burned</h4>
            </div>
        </div>

        <?php
            foreach ($exerciseData as $exercise => $works) {
                echo "<h3>$exercise</h3>";
                echo "<table style='width: 100%; text-align: center;'>";
                foreach ($works as $work) {
                    echo "<tr>
                        <td>
                        <td style = 'width: 100px;'></td>
                        <td>{$work['ExerciseName']}</td>
                        <td>{$work['Calories_Burned']}</td>
                        </tr>";
                }
                echo "</table>";
                echo "<a href='Enter{$exercise}Info.php'><p>Add Exercise</p></a><br><br>";
            }
        ?>

            <div id="dateChangeButtons">    
                <div> 
                    <a href="exercise.php?moveBackwards=true&date=<?php echo $dateView; ?>"><button class="loginButton">Previous</button></a>
                </div>
                    <div style="flex-grow: 1;"></div>
                <div> 
                    <a href="exercise.php?moveForwards=true&date=<?php echo $dateView; ?>"><button class="loginButton">Next</button></a>
                </div>
            </div>
        </div>
    </div>
</html>
