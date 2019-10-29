<?php

$errorMSG = "";

// NAME
if (empty($_POST["semail"])) {
    $errorMSG = "Sign-up Email  is required ";
} else {
    $semail = $_POST["semail"];
}

// EMAIL
if (empty($_POST["spassword"])) {
    $errorMSG .= "Password is required ";
} else {
    $spassword = $_POST["spassword"];
}

// MESSAGE
if (empty($_POST["cpassword"])) {
    $errorMSG .= "Confirmation Password is required ";
} else {
    $cpassword = $_POST["cpassword"];
}




//if(isset($_POST["submit"])){
    $hostname='localhost';
    $username='root';
    $password='';
    
    try {
    $dbh = new PDO("mysql:host=$hostname;dbname=college",$username,$password);
    
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // <== add this line
    $sql = "INSERT INTO signup (semail, spassword, cpassword)
    VALUES ('".$_POST["semail"]."','".$_POST["spassword"]."','".$_POST["cpassword"]."')";
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