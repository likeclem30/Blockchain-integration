<?php
//insert.php  
$connect = mysqli_connect("localhost", "root", "", "blockchain");
if(!empty($_POST))
{
    $output = '';
    $wphone = mysqli_real_escape_string($connect, $_POST["wphone"]);  
    $fullname = mysqli_real_escape_string($connect, $_POST["fullname"]);
    $username = mysqli_real_escape_string($connect, $_POST["username"]);
    $wpass = mysqli_real_escape_string($connect, $_POST["wpass"]);  
    $query = "
    INSERT INTO m_user(username, pass_user    ,h_menu,wphone   ,fullname)  
               VALUES('$username', MD5($wpass),'1,3' ,'$wphone',$fullname)
    ";
    if(mysqli_query($connect, $query))
    {
     $output .= '<label class="text-success">Data Inserted</label>';
     $select_query = "SELECT * FROM m_user ORDER BY id DESC";
     $result = mysqli_query($connect, $select_query);
     $output .= '
      <table class="table table-bordered">  
                    <tr>  
                         <th width="70%">User Name</th>  
                         <th width="30%">View</th>  
                    </tr>

     ';
     while($row = mysqli_fetch_array($result))
     {
      $output .= '
       <tr>  
                         <td>' . $row["name"] . '</td>  
                         <td><input type="button" name="view" value="view" id="' . $row["id"] . '" class="btn btn-info btn-xs view_data" /></td>  
                    </tr>
      ';
     }
     $output .= '</table>';
    }
    echo $output;
}
?>
