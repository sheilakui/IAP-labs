<?php
include_once 'DBConnector.php';
include_once'user.php';


if(isset($_POST['btn-save'])){
	$first_name =$_POST['first_name'];
	$last_name= $_POST['last_name'];
	$city = $_POST['city_name'];


	$user =new User ($first_name, $last_name,$city);
	$res = $user->save();

	if($res){
		echo "Save Operation was Successful";
	}
	else{
		echo "An error occured";
	}

}



?>
<html>
<head>
	<title>Form</title>

	</head>
	<body>
		<form method= "post">
			<table align= "center">
				<tr>
					<td><input type="text" name="first_name" required placeholder ="First Name"/></td>
				</tr>
				<tr>
					<td><input type="text" name="last_name"  placeholder="Last Name"/></td>
				</tr>
				<tr>
					<td><input type="text" name="city_name" placeholder = "City"/></td>
				</tr>
				<tr>
					<td><button type="submit" name="btn-save"><strong>SAVE</strong></button></td>
				</tr>
				
				</table>
				
				
			</form>
			<table>
				<tr>
					<th>ID</th>
					<th>FIRST NAME</th>
					<th>LAST NAME</th>
					<th>CITY</th>
				</tr>
				<?php

                $conn = mysqli_connect("localhost", "root", "", "btc3205");
                // Check connection
                if ($conn->connect_error) 
                {
                    die("Connection failed: " . $conn->connect_error);
                }
                $sql = "SELECT id, first_name, last_name, user_city FROM m_user";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) 
                {
                    // output data of each row
                    while($row = $result->fetch_assoc()) 
                    {
                    echo "<tr><td>" . $row["id"]. "</td><td>" . $row["first_name"] . "</td><td>"
                    . $row["last_name"]. "</td><td>" . $row["user_city"] . "</td></tr>";
                    }
                    echo "</table>";
                } 
                else { echo "0 results"; }
                $conn->close();
				?>
			</table>
			
			
	</body>
</html>