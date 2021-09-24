
<body>
<header>
<h1>Welcome To Entertainment Portal <font size=2> (Best viewed in Google Chrome)</font></h1>
</header>
	
	<div class="right-panel">
		<center>
			<form action="index.php" method="POST">
				<br><br><br><br>
				
				<table>
				<tr>
				<td> <font size="5">Kin ID: </font> </td>
				<td> <input value="<?php echo @$_REQUEST['kinid'] ?>" required style="width:200px; height:45px; font-size:20px; padding:10px;" type="text" name="kinid"> </td>
				</tr>
				
				<?php if(@$_REQUEST["user"] == "no") : ?>
				<tr><td></td><td>New User</td></tr>
				<tr>
				<td> <font size="5">Name: </font> </td>
				<td> <input style="width:200px; height:45px; font-size:20px; padding:10px;" type="text" name="name"> </td>
				</tr>
				<?php endif; ?>
				
				</table>
				
				<br>
				
				<input class="button" name="submitbutton" value="Login" type="submit">
			</form>
		</center>
	</div>
	
	<br><br>
	<footer>
		Credits : Aravind R Pillai
	</footer>
	
</body>



<style>

header {
    background-color:#bdbdbd;
    color:white;
    text-align:center;
    padding:5px;
}
.right-panel {
	height:80%;
    width:100%;
	margin:0px;
    float:right;
    padding:10px;
}

footer {
    background-color:#bdbdbd;
    color:white;
    clear:both;
    text-align:center;
    padding:5px;
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

</style>





<?php

if(@$_REQUEST['submitbutton'] == "Login"){
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "icare";
	
	$conn = new mysqli($servername, $username, $password,$dbname);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	else{
			$query = "SELECT * FROM users WHERE kinid = \"".$_REQUEST['kinid']."\"";
			$result = $conn->query($query);

			if ($result->num_rows > 0) {
				session_start(); 
				while($row = $result->fetch_assoc()) {
					$_SESSION["id"] = $row["id"];
				}
				header('Location: game.php');
			}
			else{
				
				if(@$_REQUEST['name'] != ""){
					$query = "INSERT INTO users (name,kinid,score) VALUES (\"".$_REQUEST['name']."\",\"".$_REQUEST['kinid']."\",0)";
					$result = $conn->query($query);
					
					/*reading data*/
					$query = "SELECT * FROM users WHERE kinid = \"".$_REQUEST['kinid']."\"";
					$result = $conn->query($query);

					if ($result->num_rows > 0) {
						session_start(); 
						while($row = $result->fetch_assoc()) {
							$_SESSION["id"] = $row["id"];
						}
						header('Location: game.php');
					}
					
				}
				else{	
					header('Location: index.php?user=no&kinid='.$_REQUEST["kinid"]);
				}
			}
	}

	$conn->close();
}
?>

