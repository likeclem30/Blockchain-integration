<?Php
/////// Update your database login details here /////
$host_name = "localhost"; // Your host name 
$database = "blockchain";       // Your database name
$username = "root";            // Your login userid 
$password = "";            // Your password 
//////// End of database details of your server //////

//////// Do not Edit below /////////
$con = mysqli_connect($host_name, $username, $password, $database);

if (!$con) {
    echo "Error: Unable to connect to MySQL.<br>";
    echo "<br>Debugging errno: " . mysqli_connect_errno();
    echo "<br>Debugging error: " . mysqli_connect_error();
    exit;
}
?> 