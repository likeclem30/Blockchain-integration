<?php
//include "config.php"; // Database connection using PDO
require_once("../model/dbconn.php");
//include "../model/dbconn.php";
//$sql="SELECT name,id FROM student"; 








$hostname='localhost';
    $username='root';
    $password='';
    

    try {
        $conn = new PDO("mysql:host=$hostname;dbname=blockchain", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
       

        $sql="SELECT item_name,id_item FROM m_item order by item_name"; 

/* You can add order by clause to the sql statement if the names are to be displayed in alphabetical order */

echo "<select name=student value=''>Student Name</option>"; // list box select command

foreach ($dbo->query($sql) as $row){//Array or records stored in $row

echo "<option value=$row[id_item]>$row[item_name]</option>"; 

/* Option values are added by looping through the array */ 

}

 echo "</select>";// Closing of list box
    
        // echo a message to say the UPDATE succeeded
        echo $stmt->rowCount() . " records UPDATED successfully";
        }
    catch(PDOException $e)
        {
        echo $sql2 . "<br>" . $e->getMessage();
        }
    
    $conn = null;





   



 ?>
