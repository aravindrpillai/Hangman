<title>Entertainment Portal</title>

<?php 

$wordset = array("INTEGRATION","MILITANT","UNCONSTITUTIONAL","DISMISSAL","RECRUITMENT","COMPREHENSIVE","RESTRAINT","CANCELLATION","FERTILIZER","MANUFACTURING","DEFUNCT","AEROPLANE","CURRICULAM","DESTINATION","EXCEPTION","ADMINISTRATION","NEIGHBOURHOOD","APPLICATION","COALITION","STRINGENT","PERSECUTED","CALCULATOR","EXTRAVAGANZA","INITIALIZATION","ENCAPSULATE","MESSAGING","INFORMATION","GENERATION","INTERCHANGE","LIMITATION","ACKNODWLEDGEMENT","TRANSPORTATION","APPROPRIATE","IMMEDIATELY","SYNCHRONOUS","RESTRICTION","IMPLEMENTATION","RETRIEVED","VALIDATION","CONCURRENT","CORRUPTION","CAREFULLY","INVOCATION","INTELLIGENCE","COMMUNICATION","PORTRAYAL","RECOMMENDATION","UNDERSTANDING","THERMISTOR","ORIENTATION","THERMOMETER","RESISTOR","CONVERSATION","CAPGEMINI","TELEPATHY","ANACONDA","MARVELOUS","FANTASTIC","HOMEOPATHY","VENTILATION","HELICOPTER","PROCRASTINATION","TEMPORARY","CONGRADULATIONS","HAPPINESS","ENGINEERING","GUARDIAN","IMPECCABLE","VOCABULARY","PREDEFINED","AUSTRALIA","INDONESIA","WEDDING","MANIPULATE","SUNSET","KERCHIEF","KEYBOARD","GENERATION","TRANSACTION","SUCCESFULLY","PATRIOTISM","TIMELINE","FRIENDSHIP","CHILDHOOD","MIXTURE","DELINQUENCY","PROCESSING","ADDITION","SUBSTRACTION","CONFIGURATION","MULTIPLICATION","DIVISION","KIDNAPPING"); 
//echo "word count : ".count($wordset);

$randomNumber = mt_rand(0, (count($wordset)-1));

$selectedWord = $wordset[$randomNumber];

$selectedWordLength = strlen($selectedWord);

$content = array();
$wordCheckArray = array();
for($i=0; $i<3;){
	$no = (mt_rand(1, strlen($selectedWord)))-1;		/*getting a random number*/
	$repStatus = checkRepetitions($no,$selectedWord);	/*checking for character repetitions : return FALSE if no rep else return rep count*/
	
	if($repStatus == false){							/*if repetition does not exists*/
		$content[$no] = "<input type='text' disabled id='id_".$no."' value='".$selectedWord[$no]."'>";
		$wordCheckArray[$no] = "#";
		$i+=1;
	}
	else{
		$repCount = $repStatus;
		for($j=0; $j<$repCount; $j++){
			for($k=0; $k<$selectedWordLength; $k++){
				if($selectedWord[$k] == $selectedWord[$no]){
					$content[$k] = "<input type='text' disabled id='id_".$k."' value='".$selectedWord[$k]."'>";
					$wordCheckArray[$k] = "#";
					$i+=1;
				}
			}
		}
	}
}

$wordCheck = "";
$contentData = "<table><tr>";
for($x=0; $x<$selectedWordLength; $x++){
	if(@$content[$x] == null) {
		$content[$x] = "<input disabled type='text' id='id_".$x."' >";
		$wordCheckArray[$x] = $selectedWord[$x];
	}
	
	$wordCheck .= $wordCheckArray[$x];
	$contentData .= "<td>".$content[$x]."</td>";
	
}

$contentData .= "</tr></table>";


function checkRepetitions($number,$word){
	$count=0;
	for($i=0; $i<(strlen($word)-1);$i++){
		if($word[$number] == $word[$i])
			$count+=1;
	}
	
	return ($count > 1)? $count : false;
}

?>

<body>
<header>
<h1>Entertainment Portal <font size=2>(Best viewed in Google Chrome)</font></h1>
</header>
	
	<div class="center-panel">
	<center>
	<table class="keyboard">
			<tr>
				<td><button onClick='buttonClick("A")' class="alphabet">A</button></td>
				<td><button onClick='buttonClick("B")' class="alphabet">B</button></td>
				<td><button onClick='buttonClick("C")' class="alphabet">C</button></td>
				<td><button onClick='buttonClick("D")' class="alphabet">D</button></td>
				<td><button onClick='buttonClick("E")' class="alphabet">E</button></td>
				<td><button onClick='buttonClick("F")' class="alphabet">F</button></td>
				<td><button onClick='buttonClick("G")' class="alphabet">G</button></td>
			</tr>
			<tr>
				<td><button onClick='buttonClick("H")' class="alphabet">H</button></td>
				<td><button onClick='buttonClick("I")' class="alphabet">I</button></td>
				<td><button onClick='buttonClick("J")' class="alphabet">J</button></td>
				<td><button onClick='buttonClick("K")' class="alphabet">K</button></td>
				<td><button onClick='buttonClick("L")' class="alphabet">L</button></td>
				<td><button onClick='buttonClick("M")' class="alphabet">M</button></td>
				<td><button onClick='buttonClick("N")' class="alphabet">N</button></td>
			</tr>
			<tr>
				<td><button onClick='buttonClick("O")' class="alphabet">O</button></td>
				<td><button onClick='buttonClick("P")' class="alphabet">P</button></td>
				<td><button onClick='buttonClick("Q")' class="alphabet">Q</button></td>
				<td><button onClick='buttonClick("R")' class="alphabet">R</button></td>
				<td><button onClick='buttonClick("S")' class="alphabet">S</button></td>
				<td><button onClick='buttonClick("T")' class="alphabet">T</button></td>
				<td><button onClick='buttonClick("U")' class="alphabet">U</button></td>
			</tr>
			<tr>
				<td><button onClick='buttonClick("V")' class="alphabet">V</button></td>
				<td><button onClick='buttonClick("W")' class="alphabet">W</button></td>
				<td><button onClick='buttonClick("X")' class="alphabet">X</button></td>
				<td><button onClick='buttonClick("Y")' class="alphabet">Y</button></td>
				<td><button onClick='buttonClick("Z")' class="alphabet">Z</button></td>
			</tr>
		</table>	
			
			<br><br><br><br><br><br>


			<?php echo $contentData ?>
			</center>
			
			
	</div>
	
	<div class="right-panel">
	<b STYLE="color:red">&nbsp;&nbsp;Chances Left : <i id="chances">10</i></b><br>
	<center>
	<canvas class="chart" id="myCanvas" width="300" height="300" style="border:1px solid #d3d3d3;">
	</canvas>
	<br><br>
	<font class="hanged" color="red" size="5"><b>Hanged !</b></font>
	<font class="winner" color="green" size="5"><b>Congo! You Saved The Man</b></font>
	<br>	
	<br>
	<form action="hangman.php" method="POST">
		<input class="button" type="submit" value="Restart Game">
	</form>
	</center>
	</div>
	
	<br><br>
	<footer>
		<font color="blue"> Credits : Aravind R Pillai </font>
	</footer>
	
</body>



<script src="jquery.min.js"></script>
<script>
var wordCheck = "<?php echo $wordCheck ?>";

var gameStatus = 1; /*1 means on ; 0 means stopped*/

var wrongCount = 0;
var rightCount = 1;

$(".hanged").hide();
$(".winner").hide();


function buttonClick(alphabet){
	
	var word = "<?php echo $selectedWord ?>";
	
	var id = "";
	var alphabetFirstOccurence = word.indexOf(alphabet);
	if(alphabetFirstOccurence > -1){
		id = "id_"+alphabetFirstOccurence;
		$("#"+id).val(alphabet);
		
		wordCheck = wordCheck.substring(0, alphabetFirstOccurence) + "#" + wordCheck.substring(alphabetFirstOccurence + 1);
		
		for(var i=(alphabetFirstOccurence+1); i<word.length; i++){
			if(word[i] == alphabet){
				id = "id_"+i;
				$("#"+id).val(alphabet);
		
				wordCheck = wordCheck.substring(0, i) + "#" + wordCheck.substring(i + 1);
			}
		}
	}
	else{
		wrongCount+=1;
		hangman(wrongCount);
	}
	
	
	
	if(wrongCount >= 10){
		gameStatus = 0;
		$(".hanged").show(200);
		for(var r=0; r<word.length; r++){
			$("#id_"+r).val(word[r]);
		}
	}
	else{
		var gameEndCount = 0;
		for(var r=0; r<wordCheck.length; r++){
			if(wordCheck[r] != "#"){
				gameEndCount = 1;
				break;
			}
		}
	
		if(gameEndCount == 0){
			gameStatus == 0;
			$(".winner").show(200);
		}
	}
	
	if(gameStatus == 0){
		$(".keyboard").hide(200);
	}
}


function hangman(count){

$("#chances").html(10-count);	
	
var ctx = document.getElementById("myCanvas").getContext("2d");
ctx.beginPath();

if(count == 1){
ctx.moveTo(250, 250);
ctx.lineTo(50, 250);
}

if(count == 2){
ctx.moveTo(70, 250);
ctx.lineTo(70, 50);
}


if(count == 3){
ctx.moveTo(70, 50);
ctx.lineTo(220, 50);
}


if(count == 4){
ctx.moveTo(240, 100); /*circle center*/
ctx.arc(220, 100, 20, 0, 2 * Math.PI);
}

if(count == 5){
ctx.moveTo(220, 120);
ctx.lineTo(220, 160);
}

if(count == 6){
ctx.moveTo(220, 160); /*leg starting point*/
ctx.lineTo(200, 190);
}

if(count == 7){
ctx.moveTo(220, 160); /*leg starting point*/
ctx.lineTo(240, 190);
}

if(count == 8){
ctx.moveTo(220, 130); /*hand starting point*/
ctx.lineTo(200, 160);
}

if(count == 9){
ctx.moveTo(220, 130); /*hand starting point*/
ctx.lineTo(240, 160);
}


if(count == 10){
ctx.moveTo(220, 50);
ctx.lineTo(220, 80);
}

ctx.stroke();

}
</script>


<style>

tr, td {
	font-size: 20px;
	width:50px;
	height:50px;
    border: 0px solid black;
    overflow: hidden;
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
    height:500px;
    width:15%;
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
    height:500px;
    width:320px;
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



.alphabet {
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


	
input[type=text] {
	font-size:20px; 
	padding:10px;
	width: 45px;
	height:45px;
    border: none;
    border-bottom: 3px solid red;
	margin : 5px;
}	
	


}

</style>