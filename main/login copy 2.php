<?php include "../../library/config.php" ?>
<?php $titlepage="Login Form System"; ?>
<?php include "../layout/top-header.php"; //header template ?> 


<?php  
//index.php
$connect = mysqli_connect("localhost", "root", "", "testing");
$query = "SELECT * FROM employee ORDER BY id DESC";
$result = mysqli_query($connect, $query);
 ?> 


<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><center><b>SEEGATESITE.COM</b></a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Sign in to start your session</p>
      <form action="authorization.php" method="post">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" autofocus value="" name="username" id="username" placeholder="Username">
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" value="" name="password" id="password" placeholder="Password">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-8">

          </div><!-- /.col -->
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
          </div><!-- /.col -->


<!-- -------------------------------------*/ -->
  <br />  
  <div class="container" style="width:300px;">  
     <br />  
   <div class="table-responsive">
    <div align="center">
     <button type="button" name="age" id="age" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-warning">New Wallet Account</button>
    </div>
    <br />
    
   </div>  
  </div>

<!--  ----------------------------------------------------- -->

          <a href="#"><center><small>Register User</small></center></a>
        </div>
      </form>
      <br>
      <div class="information-box round">
        <div class="callout callout-danger">
          <?php
          if (!empty($_GET['error'])) 
          {
            if ($_GET['error'] == 1) 
            {
              echo 'Please fill out username or password';
            } 
            else if ($_GET['error'] == 2)
            {
              echo 'Please fill out username';
            } 
            else if ($_GET['error'] == 3)
            {
              echo 'Please fill out password';
            }
            else if ($_GET['error'] == 4)
            {
              echo 'Invalid email or password';
            } else if ($_GET['error'] == 'session_die')
            {
              echo 'Your login session is over!!, please sign in again';
            }
          }else
          {
            echo 'Please fill out your username and password to sign in';
          }
          ?>
        </div>
      </div>
    </div><!-- /.login-box-body -->
  </div><!-- /.login-box -->
  <center><p>Copyright &copy; <?php echo date("Y");?> Seegatesite.com., inc. All rights reserved</p></center>
  <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
  <script src="../../bootstrap/js/bootstrap.min.js"></script>
  <script src="../../plugins/bootstrap-notify/bootstrap-notify.min.js"></script>
  <script src="../../dist/js/myfunction.js" type="text/javascript"></script>
  <script src="../../dist/js/sweetalert.min.js" type="text/javascript"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  

</body>
</html>


<div id="add_data_Modal" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">PHP Ajax Insert Data in MySQL By Using Bootstrap Modal</h4>
   </div>
   <div class="modal-body">
    <form method="post" id="insert_form">
     <label>Enter Employee Name</label>
     <input type="text" name="name" id="name" class="form-control" />
     <br />
     <label>Enter Employee Address</label>
     <textarea name="address" id="address" class="form-control"></textarea>
     <br />
     <label>Select Gender</label>
     <select name="gender" id="gender" class="form-control">
      <option value="Male">Male</option>  
      <option value="Female">Female</option>
     </select>
     <br />  
     <label>Enter Designation</label>
     <input type="text" name="designation" id="designation" class="form-control" />
     <br />  
     <label>Enter Age</label>
     <input type="text" name="age" id="age" class="form-control" />
     <br />
     <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" />

    </form>
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
   </div>
  </div>
 </div>
</div>

<div id="dataModal" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Employee Details</h4>
   </div>
   <div class="modal-body" id="employee_detail">
    
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
   </div>
  </div>
 </div>
</div>

<script>  
$(document).ready(function(){
 $('#insert_form').on("submit", function(event){  
  event.preventDefault();  
  if($('#name').val() == "")  
  {  
   alert("Name is required");  
  }  
  else if($('#address').val() == '')  
  {  
   alert("Address is required");  
  }  
  else if($('#designation').val() == '')
  {  
   alert("Designation is required");  
  }
   
  else  
  {  
   $.ajax({  
    url:"insert.php",  
    method:"POST",  
    data:$('#insert_form').serialize(),  
    beforeSend:function(){  
     $('#insert').val("Inserting");  
    },  
    success:function(data){  
     $('#insert_form')[0].reset();  
     $('#add_data_Modal').modal('hide');  
     $('#employee_table').html(data);  
    }  
   });  
  }  
 });




 $(document).on('click', '.view_data', function(){
  //$('#dataModal').modal();
  var employee_id = $(this).attr("id");
  $.ajax({
   url:"select.php",
   method:"POST",
   data:{employee_id:employee_id},
   success:function(data){
    $('#employee_detail').html(data);
    $('#dataModal').modal('show');
   }
  });
 });
});  
 </script>












