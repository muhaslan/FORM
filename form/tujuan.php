<?php
$sqlconn = mysqli_connect("localhost", "root", "", "form");
parse_str($_POST['datakirim'], $hasil);
$action = $_POST['action'];

if ($action == 'insert') {
	$quersql = "INSERT INTO registrasi(FirstName, LastName, Username, Email, Address, Address1, Country, State, ZIP, Payment, Name_Card, Credit_Number, Expiration, CVV, Time_Insert) VALUES ('$hasil[firstName]','$hasil[lastName]','$hasil[Username]','$hasil[Email]','$hasil[Address]','$hasil[Address1]','$hasil[Country]','$hasil[State]','$hasil[Zip]','$hasil[paymentMethod]','$hasil[NameCard]','$hasil[CreditCardNumber]','$hasil[Expiration]','$hasil[CVV]',now())";
}
elseif ($action == 'update') {
	//parse_str($_POST['dataTambahan'], $tambahan);
	$quersql = "UPDATE registrasi SET FirstName='$hasil[firstName]',LastName='$hasil[lastName]',Username='$hasil[Username]',Email='$hasil[Email]',Address='$hasil[Address]',Address1='$hasil[Address1]',Country='$hasil[Country]',State='$hasil[State]',ZIP='$hasil[Zip]',Payment='$hasil[paymentMethod]',Name_Card='$hasil[NameCard]',Credit_Number='$hasil[CreditCardNumber]',Expiration='$hasil[Expiration]',CVV='$hasil[CVV]' WHERE Username='$hasil[Username]'";
}
elseif ($action == 'delete') {
	$quersql = "DELETE FROM registrasi WHERE Username='$hasil[Username]'";
}
elseif ($action == 'read') {
	$quersql = "SELECT FirstName, LastName, Username, Email, Address, Address1, Country, State, ZIP, Payment, Name_Card, Credit_Number, Expiration, CVV FROM registrasi WHERE Username='$hasil[Username]'";
}
else {
	echo "ERROR ACTION";
	exit();
}

if (mysqli_errno($sqlconn)) {
	echo "Gagal Terhubung ke Database".$sqlconn -> connect_error; 
	exit();
}else{
	//echo "Database Terhubung";	
}

if ($sqlconn -> query($quersql) === TRUE) {
	echo "$action Successfully";
}
elseif ($sqlconn->query($quersql) === FALSE){
	echo "Error:  $quersql" .$sqlconn -> error;
}
else {
	$result = $sqlconn->query($quersql); //bukan true false tapi data array asossiasi
	if($result->num_rows > 0){
		echo "<table id='tresult' class='table table-striped table-bordered text-white'>";
		echo "<thead><th>Firstname</th><th>Lastname</th><th>Username</th><th>Email</th><th>Address</th><th>Address1</th><th>Country</th><th>State</th><th>ZIP</th><th>Payment</th><th>Name on Card</th><th>Credit Card Number</th><th>Expiration</th><th>CVV</th></thead>";
		//echo "<tbody>";
		while($row = $result->fetch_assoc()) {
			echo "<tr><td>".$row['FirstName']."</td><td>". $row['LastName']."</td><td>".$row['Username']."</td><td>". $row['Email']."</td><td>".$row['Address']."</td><td>". $row['Address1']."</td><td>".$row['Country']."</td><td>". $row['State']."</td><td>".$row['ZIP']."</td><td>". $row['Payment']."</td><td>".$row['Name_Card']."</td><td>". $row['Credit_Number']."</td><td>".$row['Expiration']."</td><td>". $row['CVV']."</td></tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}
	else{
		echo "Data Not Available";
	}
}
$sqlconn->close();
?>