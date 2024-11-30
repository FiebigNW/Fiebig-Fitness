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

    <div id = "calorieCalcHome">
        <h3 style = "font-style: italic; text-align: center;">Calculate Calories</h3>

        <br><br>

        <div id = "calorieCalcLayout">
                <label for = "ageInput"><b>Age: </b></label>
                <input type = "number" id = "ageInput" placeholder="Years"></input>
                
                <br><br>

                <label for = "maleInput"><b>Gender: </b></label>
                <br><br>
                    <label for = "maleInput" ><b>Male</b></label>
                    <input type = "checkbox" id = "maleInput" style = "width: 20px; height: 15px;"></input>

                    <label for = "femaleInput"><b>Female</b></label>
                    <input type = "checkbox" id = "femaleInput" style = "width: 20px; height: 15px;"></input>

                <br><br>

                <label><b>Height: </b></label>
                <input type = "number" id = "heightFeet" placeholder="Feet" style = "width: 100px;"></input>
                <input type = "number" id = "heightInches" placeholder="Inches" style = "width: 100px;"></input>

                <br><br>

                <label for = "weightInput"><b>Weight: </b></label>
                <input type = "number" id = "weightInput" placeholder = "Pounds"></input>
                
                <br><br>

                <label for = "activtiyInput"><b>Activity Level: </b></label>
                <select id="activityInput" style = "width: 250px; height: 30px;">
                    <option value="sedentary">Sedentary (little or no exercise)</option>
                    <option value="lightly_active">Lightly active (light exercise/sports 1-3 days a week)</option>
                    <option value="moderately_active">Moderately active (moderate exercise/sports 3-5 days a week)</option>
                    <option value="very_active">Very active (hard exercise/sports 6-7 days a week)</option>
                    <option value="super_active">Super active (very hard exercise, physical job, or twice-a-day training)</option>
                </select>


                <br><br>
                
                <div id = "calculateCaloriesAnswer">     
                    <button class="loginButton"  id="calculateCaloriesButton" onclick = processEntries()>Calculate</button>                        
                    <div style = "flex-grow: 1;"></div>
                    <p id="caloriesOutput"></p>  
                </div>

        
                <script>
                    function processEntries() {	
                        let age = document.getElementById("ageInput");
                        let heightFeet = document.getElementById("heightFeet");
                        let heightInches = document.getElementById("heightInches");
                        let weight = document.getElementById("weightInput");
                        let male = document.getElementById("maleInput");
                        let female = document.getElementById("femaleInput");
                        let activityInput = document.getElementById("activityInput")
                        let output = document.getElementById("caloriesOutput");
                        let activity;
                        
                        switch(activityInput.value){
                            case("sedentary"):
                                activity = 1.2;
                                break;
                            case("lightly_active"):
                                activity = 1.375;
                                break;
                            case("moderately_active"):
                                activity = 1.55;
                                break;
                            case("very_active"):
                                activity = 1.725;
                                break;
                            case("super_active"):
                                activity = 1.9;
                                break;
        
                        }

                        if((male.checked && female.checked) || age.value == "" || heightFeet.value == "" || heightInches.value == "" || weight.value == "" || (!male.checked && !female.checked)){
                            output.textContent = "Incorrect Format"
                            output.style.textAlign = "center"; 
                            output.style.border = "solid";  
                            output.style.width = "auto"; 
                            output.style.height = "auto"; 
                            output.style.borderRadius = "15px";
                            output.style.padding = "5px";
                        } else{
                            let weightInKg = weight.value / 2.205; // Convert pounds to kg
                            let heightInCm = (parseFloat(heightFeet.value) * 12 + parseFloat(heightInches.value)) * 2.54; // Convert height to cm
                            let bmr;

                            if (male.checked) {
                                bmr = (10 * weightInKg) + (6.25 * heightInCm) - (5 * age.value) + 5;
                            } else {
                                bmr = (10 * weightInKg) + (6.25 * heightInCm) - (5 * age.value) - 161;
                            }

                            let recommendedCalories = bmr * activity;
                            recommendedCalories = Math.round(recommendedCalories);

                            output.textContent = "Total: " + recommendedCalories + " calories per day";
                            output.style.textAlign = "center"; 
                            output.style.border = "solid";  
                            output.style.width = "auto"; 
                            output.style.height = "auto"; 
                            output.style.borderRadius = "15px";
                            output.style.padding = "5px";
                        }   
                    }
            </script>
        </div>
    </div>
</html>