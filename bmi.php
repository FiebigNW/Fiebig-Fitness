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

    <div id = "bmiHome">
            <h3 style = "font-style: italic; text-align: center;">Body Mass Index Calculator</h3>
                
            <br>

            <label for="heightInput"><b>Enter Your Height:</b></label>
            <input type='number' id='heightInput' placeholder="Inches"><br>
                    
            <br>
                    
            <label for="weightInput"><b>Enter Your Weight:</b></label>
            <input type='number' id='weightInput' placeholder="Pounds"><br>
                
            <br>
            <div id = "bmiAnswer">     
                <button id = "functionButton" class = "loginButton" onclick = processEntries()>Calculate</button> 
                    <div style = "flex-grow: 1;"></div>
                <p id="bmiOutput"></p>  
            </div>
            <script>
                function processEntries() {	
                    let height = document.getElementById("heightInput");
                    let weight = document.getElementById("weightInput");
                    let output = document.getElementById("bmiOutput");
                    
                    if(height.value < 0 && weight.value < 0 || height.value == "" && weight.value == "" || height.value < 0 && weight.value == "" || height.value == "" && weight.value < 0){
                    } else if (weight.value < 0 || weight.value == ""){
                        output.textContent = "Invalid Weight";
                        output.style.textAlign = "center"; 
                        output.style.border = "solid";  
                        output.style.width = "auto"; 
                        output.style.height = "auto"; 
                        output.style.borderRadius = "15px";
                        output.style.padding = "5px";
                    } else if (height.value < 0 || height.value == ""){        
                        output.textContent = "Invalid Height";
                        output.style.textAlign = "center"; 
                        output.style.border = "solid";  
                        output.style.width = "auto"; 
                        output.style.height = "auto"; 
                        output.style.borderRadius = "15px";
                        output.style.padding = "5px";
                    } else{
                        let bmi = (703 * weight.value) / Math.pow(height.value, 2);
                        bmi = Math.round(bmi * 10) / 10
                        output.textContent = "Total: " + bmi;
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
</html>