<?php
$host = 'localhost'; 
$db = 'luxury_goods';    
$user = 'pasindu';        
$pass = '123pasindu';  


try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

