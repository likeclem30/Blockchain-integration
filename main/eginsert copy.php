<?php

$errorMSG = "";

// Wallet number
if (empty($_POST["wphone"])) {
    $errorMSG = "Sign-up Wallet number  is required ";
} else {
    $wphone = $_POST["wphone"];
}

// Wallet number
if (empty($_POST["fullname"])) {
    $errorMSG = "Sign-up full name  is required ";
} else {
    $fullname = $_POST["fullname"];
}

// NAME
if (empty($_POST["username"])) {
    $errorMSG = "Sign-up Email  is required ";
} else {
    $username = $_POST["username"];
}

// EMAIL
if (empty($_POST["spassword"])) {
    $errorMSG .= "Password is required ";
} else {
    $spassword = $_POST["spassword"];
}


//if(isset($_POST["submit"])){
    $hostname='localhost';
    $username='root';
    $password='';
    
    try {
    $dbh = new PDO("mysql:host=$hostname;dbname=blockchain",$username,$password);
    
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // <== add this line
    $sql = "INSERT INTO m_user(wphone,fullname,username, pass_user, h_menu)
    VALUES ('".$_POST["wphone"]."','".$_POST["fullname"]."','".$_POST["username"]."',MD5('".$_POST["spassword"]."'),'1,2')";
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
