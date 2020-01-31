<?php
$servername = "localhost";
$username = "bubble";
$password = "bubble";
$dbname = "bubbleDB";
$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$arr = parse_url($url);
$parameters = $arr["query"];
parse_str($parameters, $data);
$hub=$data["hub"];
$user=$_SESSION['user_id'];
function valid_hub($id){
	if (strlen($id) == 11){
		$pattern = "/([a-z]|[A-Z]|[0-9]){11}/";
		if(preg_match($pattern, $id)){return true;}
		else{return false;}
	}
	return false;
}
// Create connection
if (valid_hub($hub)){
        echo "User logged in session";echo "<br>";echo "<br>";
        echo $servername;echo "<br>";
        echo $username;echo "<br>";
        echo $password;echo "<br>";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {die("Connection failed: " . $conn->connect_error);}
        echo "Connected successfully";
	echo "<br>";echo "<br>";
	$sql = "INSERT INTO hub_users (user_id, hub_id)
	VALUES ($user, $hub)";

	if ($conn->query($sql) === TRUE) {
	    echo "New record created successfully";
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}
}
else {
        echo "User logged out session";
}

?>
