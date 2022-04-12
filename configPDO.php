<?php
  $host = 'localhost';
  $dbname = 'projetphp';
  $username = 'root';
  $password = '';
    
  $dsn = "mysql:host=$host;dbname=$dbname"; 

  $sql = "SELECT * FROM users";
  $sql2 = "SELECT * FROM school";
  $sql3 = "SELECT * FROM user_school_connector";
   
  try{
    $pdo = new PDO($dsn, $username, $password);
    $stmt = $pdo->query($sql);
    $restmt = $pdo->query($sql);
    $restmt1 = $pdo->query($sql);
    $stmt2 = $pdo->query($sql2);
    $stmt3 = $pdo->query($sql3);


   
    if($stmt === false){
      die("Erreur");
    }  
    if($stmt2 === false){
      die("Erreur");
    }
    if($stmt3 === false){
      die("Erreur");
    }
  }catch (PDOException $e){
    echo $e->getMessage();
  }
?>