<?php



$host = 'localhost';       
$user = 'root';            
$password = '';            
$dbname = 'product_catalog'; 


$conn = new mysqli($host, $user, $password, $dbname);


if ($conn->connect_error) {
    die("Konekcija neuspešna: " . $conn->connect_error);
} else {
   // echo "Uspešno povezivanje sa bazom podataka!";
}
?>