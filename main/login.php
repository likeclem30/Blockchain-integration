<?php include "../../library/config.php" ?>
<?php $titlepage="Login Form System"; ?>
<?php include "../layout/top-header.php"; //header template ?> 

<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">


<body class="hold-transition login-page">
<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="" target="_blank">Agrikore-BlockChain</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="" target="_blank">Home</a></li>
            <li><a href="" target="_blank">About</a></li>
            <li><a href="" target="_blank">Contact</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            
          <li><a href="#" data-toggle="modal" data-target="#modal">Login/Signup</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    
    <!-- Bootstrap Modal -->

<!--SignUp Form-->
<div class="modal fade" id="modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="text-primary">Signup - Login Form</h3>
        </div>
		<div class="modal-body">
			<ul class="nav nav-tabs">
			  <li class="active"><a data-toggle="tab" href="#home">Signup</a></li>
			  <li><a data-toggle="tab" href="#login">Login</a></li>
			</ul>
			<div class="tab-content">
			  <div id="home" class="tab-pane fade in active">
				<form  method="post" action="eginsertx.php" role="form" class="form-horizontal">	
				<div class="form-group">
				<label class="control-label col-md-3">Mobile number *:</label>
				<div class="col-md-9">
				<input type="text" class="form-control" name="wphone" value="" placeholder="Please Enter Your Mobile Number" required>
				</div>	
				</div>
				<div class="form-group">
				<label class="control-label col-md-3">Your Name *:</label>
				<div class="col-md-9">
				<input type="text" class="form-control" name="fullname" value="" placeholder="Please Enter Your Name" required>
				</div>
				</div>
				
				<div class="form-group">
				<label class="control-label col-md-3">Email address *:</label>
				<div class="col-md-9">
				<input type="email" class="form-control" name="username" value="" placeholder="Please Enter Your Email" required>
				</div>
				</div>
				<div class="form-group">
				<label class="control-label col-md-3">Password *:</label>
				<div class="col-md-9">
				<input type="password" class="form-control" name="spassword" value="" placeholder="Please Enter Your password" required>
				</div>
				</div>	
				<div class="form-group">
				<label class="control-label col-md-3">Retype Password *:</label>
				<div class="col-md-9">
				<input type="password" class="form-control" name="spassword" value="" placeholder="Please Enter Retype Your password" required>
				</div>
				</div>	

				
				<div class="form-group">
				<div class="col-md-3"></div>
				<div class="col-md-9">
				<input type="submit" name="SignupNow" value="Signup Now" class="btn btn-info"> <input type="reset" name="Reset" value="Reset" class="btn btn-default"> 
				</div>	
				</div>	
				</form>	
			</div>
				
			  <div id="login" class="tab-pane fade">
				<form  method="post" action="authorization.php" role="form" class="form-horizontal">		
				<div class="form-group">
				<label class="control-label col-md-3">Email address *:</label>
				<div class="col-md-9">
				<input type="email" class="form-control" name="username" value="" placeholder="Please Enter Your Email" required>
				</div>
				</div>	
				<div class="form-group">
				<label class="control-label col-md-3">Password *:</label>
				<div class="col-md-9">
				<input type="password" class="form-control" name="password" value="" placeholder="Please Enter Your password" required>
				</div>
				</div>	
				<div class="form-group">
				<div class="col-md-3"></div>
				<div class="col-md-9">
				<input type="submit" name="Login Now" value="Login Now" class="btn btn-info"> <input type="reset" name="Reset" value="Reset" class="btn btn-default"> 
				</div>	
				</div>	
				</form>		  
			  </div>
			</div>
		</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>      
    </div>
  </div>
</div>

	<!-- Bootstrap Modal -->

  <p>Copyright &copy; <?php echo date("Y");?> cellulant.com.ng, inc. All rights reserved</p>
  <!--<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>-->
  <script src="../../bootstrap/js/bootstrap.min.js"></script>
  <script src="../../plugins/bootstrap-notify/bootstrap-notify.min.js"></script>
  <script src="../../dist/js/myfunction.js" type="text/javascript"></script>
  <script src="../../dist/js/sweetalert.min.js" type="text/javascript"></script>

	 <script type="text/javascript" src="../../dist/js/jquery-3.2.1.min"></script>



</body>
</html>
