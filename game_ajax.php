
<?php

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "icare";
	
	$conn = new mysqli($servername, $username, $password,$dbname);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	else{
		
			$query = "SELECT score FROM users WHERE id = ".$_POST['id'];
			$result = $conn->query($query);
			$previous_score = 0;
			if ($result->num_rows > 0) 
				while($row = $result->fetch_assoc())
					$previous_score = $row["score"];
			
		
		$id  = $_POST['id'];
		$previous_score = $previous_score == 0 ? 40000 : $previous_score;
		$score = (int)$_POST['score'] < $previous_score ? (int)$_POST['score'] : $previous_score;
		
		$query = "UPDATE users SET score = \"".$score."\" WHERE id = ".$id;
		$result = $conn->query($query);
	}
echo 1;






?>