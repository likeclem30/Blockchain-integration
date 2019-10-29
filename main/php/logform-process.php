<?php

$errorMSG = "";

// NAME
if (empty($_POST["username"])) {
    $errorMSG = "Sign-up Email  is required ";
} else {
    $username = $_POST["username"];
}

// EMAIL
if (empty($_POST["password"])) {
    $errorMSG .= "Password is required ";
} else {
    $password = $_POST["password"];
}

// MESSAGE
//if (empty($_POST["cpassword"])) {
 //   $errorMSG .= "Confirmation Password is required ";
//} else {
 //   $cpassword = $_POST["cpassword"];
//}




//if(isset($_POST["submit"])){
    $hostname='localhost';
    $username='root';
    $password='';
    
    try {
    $dbh = new PDO("mysql:host=$hostname;dbname=college",$username,$password);
    
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // <== add this line
    $sql = "INSERT INTO signup (semail, spassword)
    VALUES ('".$_POST["username"]."','".$_POST["password"]."')";
    if ($dbh->query($sql)) {
    echo "New Record Inserted Successfully";
    }
    else{
    echo "Data not successfully Inserted.";
    }
    
    $dbh = null;
    }
    catch(PDOException $e)
    {
    echo $e->getMessage();
    }
    
  //  }

?>