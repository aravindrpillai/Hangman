<title>Entertainment Portal</title>

<?php 
session_start();

if(@$_REQUEST['logout'] == "yes"){
	unset($_SESSION['id']);
}


if(!isset($_SESSION['id'])) header('Location: index.php');

$rows = 10;
$cols = 10;

$quantity = $rows * $cols;

 $num = range(1, $quantity);
 shuffle($num);
 $numbers = array_slice($num, 0, $quantity);


$content = "<table>";

$count = 0;
for($i=0; $i<$rows; $i++){
	$content.="<tr>";
	for($j=0; $j<$cols; $j++){
		$id = "boxid".$numbers[$count];
		$content.= "<td><center class='blue-box' id=".$id." onClick='makeChange(\"".$numbers[$count]."\")'>".$numbers[$count]."</center></td>";
		$count += 1;
	}
	$content .= "</tr>";
}


$content .= "</table>";
?>

<body>
<header>
<h1>Entertainment Portal <font size=2>(Best viewed in Google Chrome)</font></h1>
</header>
	<div class="left-panel">
		
		<br>
		<div style="float:left">
			<div class="timer">0</div> <font color="red">Seconds</font>
		</div>
		<div class="lastpressedouterdiv" style="float:right">
			<div class="last-pressed-value">99</div><font color="green">Last Pressed</font>
		</div>
		
		<br><br>
		
		<div class="pause-button">
		<button style="width:'100%'; height:'110px' " onClick="pauseGame()" >Pause Game</button>
		</div>
		
		<div class="rules">
		<b><u>RULES</u></b>
			<br>* Click From 1 to 100 (in order)<br>&nbsp;&nbsp;&nbsp; as fast as you can .
			<br>* Click 1 to start the game
			<br>* You can pause/restart the game anytime.
			
		</div>
		
		<br>
		
		<form action="game.php" method="POST" onsubmit="return confirm('Are you sure');">
		<input class="button" type="submit" value="Restart Game">
		</form>
		
		
		
		
		<!----SCORE BOARD------->
		<?php 
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "icare";
	
			$conn = new mysqli($servername, $username, $password,$dbname);

			if ($conn->connect_error){
				die("Connection failed: " . $conn->connect_error);
			
			}
			else{
				echo "<br><b><u>My Top Score</u></b><br>";
				$result = $conn->query("SELECT * FROM users WHERE id = \"".$_SESSION['id']."\"");
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
							echo "* ".$row['name']." - ". (($row['score'] == "0") ? "No Completed Games Found " : $row['score']." sec");
					}
				}
			}
		?>
		<br>
		
		<form action="game.php" method="POST">
		<input type="hidden" value="yes" name="logout">
		<input class="button" type="submit" value="Logout User">
		</form>
		
	</div>
	

	<div class="center-panel">
			<center><?php echo $content; ?></center>
	</div>
	
	<div class="right-panel">
	<b><u>Score Board</u></b><br>
	<div class="score-board-panel">
	<?php
	$i = 1;
	$result = $conn->query("SELECT * FROM users WHERE score != \"0\" order by score asc");
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
				if($i == 1) echo "<b><font color=#4CAF50>";
				echo " * $i. ".$row['name']." - ".$row['score']." sec<br>";
				if($i == 1) echo "</font></b>";
				$i+=1;
		}
	}
	
	
	$result = $conn->query("SELECT * FROM users WHERE score = \"0\" order by name asc");
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
				echo " * $i. ".$row['name']." - ".$row['score']." sec<br>";
				$i+=1;
		}
	}
	
	?>
	<br>
	<font color="red">'0 Sec' means yet to finish the game</font>
	
	</div>
	</div>
	
	<br><br>
	<footer>
		<font color="blue"> Credits : Aravind R Pillai </font>
	</footer>
	
</body>



<script src="jquery.min.js"></script>
<script>

$(".blue-box").hide();
$("#boxid1").show();
$(".pause-button").hide();
$(".lastpressedouterdiv").hide();

/*timer*/
var sec = 0;
var timer;
var timerObj;



function timerFunction(){
	sec++;
	$(".timer").html(sec);
}


/*Pausing game*/
var gameStatus = 1;
var pauseAtTime = 0;
function pauseGame(){
	if(gameStatus == 1){
		pauseAtTime = sec;
		window.clearInterval(timerObj);
		gameStatus = 0;
		$(".blue-box").hide();
		$("button").html("Resume Game");
	}
	else{
		sec = pauseAtTime;
		timerObj = window.setInterval(timerFunction,1000);
		gameStatus = 1;
		$(".blue-box").show();
		$("button").html("Pause Game");
	}
		
	
	
}



var lastValue = 0;
function makeChange(bId){
	
	var boxId = parseInt(bId);
	
	if(boxId == 1){
		$(".rules").hide();
		$(".pause-button").show();
		$(".blue-box").show(200);
		timerObj = window.setInterval(timerFunction,1000);
		$(".lastpressedouterdiv").show();
	}
	
	if((lastValue == 99) && (boxId == 100)){
		pauseAtTime = sec;
		window.clearInterval(timerObj);
		
		
		
		$.ajax({
			url:"ajax.php",
			type:"POST",
			data:({"id":<?php echo $_SESSION['id']?>,"score": pauseAtTime }),
			success:function(data){location.reload();},
			error:function(data){alert("error: Could not update score");}
		});
		
		
	} 
		
	if((lastValue+1) == boxId){  
		lastValue = boxId; 
		$("#boxid"+boxId).removeClass("blue-box").addClass("white-box"); 
		$(".last-pressed-value").html(boxId);
	}
}



</script>


<style>

tr, td {
	font-size: 20px;
	width:50px;
	height:50px;
    border: 1px solid black;
    overflow: hidden;
}
.div-for-pause{
	font-size: 53px;
	font-color: red;
}

.timer{
	font-size: 53px;
	color: red;
}

.last-pressed-value{
	font-size: 53px;
	color: green;
}

header {
    background-color:#bdbdbd;
    color:white;
    text-align:center;
    padding:4px;
}

.left-panel {
    line-height:30px;
    background-color:#eeeeee;
    height:520px;
    width:22%;
    margin:0px;
	float:left;
    padding:5px;
}
.center-panel {
	height:520px;
    width:50%;
	margin:0px;
    float:left;
    padding:10px;
}
.right-panel {
	line-height:30px;
    background-color:#eeeeee;
    height:520px;
    width:22%;
    margin:0px;
	float:right;
    padding:5px;
}

footer {
    background-color:#bdbdbd;
    color:white;
    clear:both;
    text-align:center;
    padding:5px;
}

.blue-box{
	width:100%;
	height:100%;
	background-color : #339FFF;	
}

.white-box{
	width:100%;
	height:100%;
	background-color : #C3F8FD;	
}

button {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
}


.button {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
}



.score-board-panel{
	width: 100%;
    height: 97%;
    overflow: scroll;
	
}

</style>