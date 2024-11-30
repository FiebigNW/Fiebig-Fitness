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

$meals = ['Breakfast', 'Lunch', 'Dinner'];
$mealData = [];

foreach ($meals as $meal) {
    $query = "SELECT Food_Name, Calories, Carbs, Fats, Protein, Sodium, Sugar
            FROM Nutrition
            WHERE AccountID = :accountID AND Meal_Type = :mealType AND Food_Added_Date = :date";

    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':accountID' => $accountID,
        ':mealType' => $meal,
        ':date' => $dateView
    ]);
    
    $mealData[$meal] = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    
    <div id="foodHome">
        <h3 style="font-style: italic; text-align: center;">Food Diary For Date: <?php echo htmlspecialchars($formattedDate);?></h3>
        
        <br>

        <div id="macroNutrientsLayout"> 
            <div style="display: flex; flex-wrap: nowrap; gap: 10px; justify-content: start; align-items: center;">
                <div style="flex-grow: 5;"></div>
                <h4 style="border: solid; padding: 3px;">Calories</h4>
                <h4 style="border: solid; padding: 3px;">Carbs</h4>
                <h4 style="border: solid; padding: 3px;">Fats</h4>
                <h4 style="border: solid; padding: 3px;">Protein</h4>
                <h4 style="border: solid; padding: 3px;">Sodium</h4>
                <h4 style="border: solid; padding: 3px;">Sugar</h4>
            </div>
        </div>
        
        <?php
        foreach ($mealData as $meal => $foods) {
            echo "<h3>$meal</h3>";
            echo "<table style='width: 100%; text-align: center;'>";
            foreach ($foods as $food) {
                echo "<tr>
                        <td>{$food['Food_Name']}</td>
                        <td style = 'width: 170px;'></td>
                        <td>{$food['Calories']}</td>
                        <td>{$food['Carbs']}</td>
                        <td>{$food['Fats']}</td>
                        <td>{$food['Protein']}</td>
                        <td>{$food['Sodium']}</td>
                        <td>{$food['Sugar']}</td>
                        </tr>";
            }
            echo "</table>";
            echo "<a href='Enter{$meal}Info.php'><p>Add Food</p></a><br><br>";
        }
        ?>
        
        <div id="dateChangeButtons">    
            <div> 
                <a href="food.php?moveBackwards=true&date=<?php echo $dateView; ?>"><button class="loginButton">Previous</button></a>
            </div>
            <div style="flex-grow: 1;"></div>
            <div> 
                <a href="food.php?moveForwards=true&date=<?php echo $dateView; ?>"><button class="loginButton">Next</button></a>
            </div>
        </div>
    </div>
</html>
