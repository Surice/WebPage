<html>
    <?php
        session_start();
    ?>
    <header>
        <title>ACC Assistant</title>
        <meta name="viewport" content="width=device-width, initial-scale = 1">
        <meta charset="utf-8">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </header>
    <body>
        <ul class="navbar-me">
            <li>
                <a href="../index.php"><button class="exit btn btn-outline-danger">Back</button></a>
            </li>
        </ul>
        <div class="content">
            <div class="header">
                <h1 class="headline">ACC Assistant</h1>
            </div>
            <div class= "TimeLapsTable">
                <div class="TimeLapsTableHead">
                    <u><h1>Required Information:</h1></u>
                </div>
                <div class="TimeLapsTableDiv">
                    <div>
                        <lable class="headInput"><b>Racedistance:</b></lable>
                        <br>            
                        <input type="number" id= "inputTime" onchange="detectTime()">
                        <select id="time" onchange="detectTime()">
                            <option value="1">Hours</option>
                            <option value="2">Minutes</option>
                            <option value="0">Laps</option>
                        </select>
                        <br>
                        <br>
                        <table>
                            <tr>
                                <td>Minutes:</td>
                                <td style="width: 32%"></td>
                                <td><output id="resultMinutes"></output></td>
                            </tr>
                            <tr>
                                <td>Secondes:</td>
                                <td></td>
                                <td><output id="resultSecondes"></output></td>
                            </tr>
                            <tr>
                                <td style="text-align: center;"><input type="checkbox" id= "checkbox"></td>
                                <td></td>
                                <td>+ Formationlap and inlap</td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <lable class="headInput"><b>Laptimes:</b></lable>
                        <br>
                        <input type="number" id="laptimeMIN" class="inputLaptime">   
                        <select class="selectLaptime" >
                            <option>Minutes</option>
                        </select>
                        <input type="number" id="laptimeSEC" class="inputLaptime">
                        <select class="selectLaptime">
                            <option>Secondes</option>
                        </select>
                    </div>
                    <div>
                        <lable class="headInput"><b>Fuel Consumption:</b></lable>
                        <br>
                        <input type="number" id="FuelConsumption">
                        <select>
                            <option>Liters</option>
                        </select>
                    </div>
                    <div>
                        <lable class="headInput"><b>Fueltank:</b></lable>
                        <br>
                        <input type="number" id= "Fueltank">
                        <select>
                            <option>Liters</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="divBTNCalculate">
                <button class="BTNCalculate" onclick="detectTime(); fuelCalculate()">Calculate</button></th>
            </div>

            <div class="results">
                <div>
                    <h1><u>Results:</u>
                </div> 
                <div class="line">  
                    <lable>Driving Laps are:  </lable>
                    <div id="drivingLaps" class="outputLine"></div>
                    <label>Laps</label>
                </div> 
                <br>
                <div class="line">
                    <lable>The Fuel Consumption is: </lable>
                    <br>
                    <div><p id= 'ResultFuelCon' class="outputLine"></p></div>
                    <label> Liters</label>
                </div>
                <br>
                <div class="line">
                    <label>Required Boxenstops are: </label>
                    <br>
                    <div><p id= 'ResultBoxenstops' class="outputLine"></p></div>     
                </div>  
            </div>
            <div class= "footer">
                <div class="vers">
                    <p style="margin-right: 10px;">Version 1.0</p>
                </div>
            </div>
        </div>
        <script>
            console.log("Code written by Timon");

            function detectTime(){
                var detHours = document.getElementById('time').value,
                    inputTime = document.getElementById('inputTime').value;

                if(detHours == 0){
                    document.getElementById('resultMinutes').innerHTML = `----`;
                    document.getElementById('resultSecondes').innerHTML = `----`;
                } 
                else if(detHours == 1){
                    var outputHours = Math.round((inputTime*60)*100)/100,
                        outputMinutes = Math.round((inputTime*60*60)*100)/100;

                    document.getElementById('resultMinutes').innerHTML = outputHours;
                    document.getElementById('resultSecondes').innerHTML = outputMinutes;
                }
                else if(detHours == 2){
                    var outputHours = Math.round(inputTime),
                        outputMinutes = Math.round((inputTime*60)*100)/100;

                    document.getElementById('resultMinutes').innerHTML = outputHours;
                    document.getElementById('resultSecondes').innerHTML = outputMinutes;
                }
            }

            async function fuelCalculate(){
                var detTime = document.getElementById('time').value,
                    detSeconds = document.getElementById('resultSecondes').value,
                    detLaptimeSEC = await checkLaptime(document.getElementById('laptimeSEC').value),
                    detLaptimeMIN = document.getElementById('laptimeMIN').value,
                    detFuelCon = document.getElementById('FuelConsumption').value,
                    detTank = document.getElementById('Fueltank').value,
                    detCheckbox = document.getElementById('checkbox');

                var outputLaptimeSEC = detLaptimeMIN*60+parseInt(detLaptimeSEC);

                if(detTime == 0){                
                    var drivingLaps = document.getElementById('inputTime').value;
                }
                else if(detTime == 1 || detTime == 2){
                    var drivingLaps = Math.round((detSeconds/outputLaptimeSEC)*100)/100;
                }

                if(detCheckbox.checked == true){
                    var drivingLaps = Math.round((drivingLaps)*100)/100+2;
                }

                

                var outputFuelCon = Math.round((drivingLaps*detFuelCon)*100)/100,
                    outputBoxenstops = Math.floor(outputFuelCon/detTank);

                document.getElementById('drivingLaps').innerHTML = `<b>${drivingLaps}</b>`;
                document.getElementById('ResultFuelCon').innerHTML = `<b>${outputFuelCon}</b>`;
                document.getElementById('ResultBoxenstops').innerHTML = `<b>${outputBoxenstops}</b>`;
            }

            function keyInput(){
                if (event.keyInput == 32){
                   detectTime()
                   fuelCalculate()
                }
            }

            function checkLaptime(item){
                var res = item;
                if(item == ""){
                    res = 0;
                } 
                
                return res;
            }

        </script>
    </body>

    <style>
        .navbar-me{
            display: flex;
            flex-flow: row wrap;
            justify-content: flex-end;
            list-style: none;
        }
        .exit{
            margin: 5px;
            text-decoration: none;
        }

        .header{
            position: fixed;
            top: 20px;
            width: 100%;
            z-index: -1;
        }
        .headline{
            display: flex;
            flex-flow: row;
            justify-content: center;
            color: whitesmoke;
            font-size: 60px;
            font-family: "Times New Roman", Georgia, serif;
            text-shadow: black;
        }
        body{
            background-color: rgba(85, 75, 104, 0.26);
            background-image: url('../img/car-racing.jpg');
            background-size: 100%;
        }
        .content{
            height: 90%;
            width: 100%;

            display: flex;
            flex-flow: row;
            justify-content: space-evenly;
            align-items: center;
        }

        .TimeLapsTable{
            border: 1px;
            border-style: solid;
            width: 40%;
            height: 70%;
            background-color: rgba(248 ,248 , 248 ,0.4)   
            
        }   
        .TimeLapsTableDiv{
            height: 70%;
            margin-left: 14%;
            display: flex;
            flex-flow: column; 
            justify-content: space-evenly;
        }
        .TimeLapsTableHead{
            display: flex;
            flex-flow: row;
            justify-content: center;
        }
        .headInput{
            font-size: 20px;
        }
        .inputLaptime{
            width: 6vw;
        }
        .selectLaptime{
            margin-right: 0px;
        }
        .results{
            border: 1px;
            border-style: solid;
            width: 40%;
            height: 70%;
            background-color: rgba(248 ,248 , 248 ,0.4);   
            display: flex;
            flex-flow: column;
            justify-content: space-evenly;
            align-items: center;
        } 
        .line{
            display: flex;
            flex-flow: row;
            align-items: center;
        }
        .outputLine{
            width: 50px;
            display: flex;
            flex-flow: row;
            justify-content: center;
        }
        .BTNCalculate{
            background-color: whitesmoke;
        }
        .divBTNCalculate{
            text-align: center;
        }
        .footer{
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: rgba(73, 73, 73, 0.45);
        }
        .vers{
            display: flex;
            flex-flow: row;
            justify-content: flex-end;
        }
    </style>
</html>
