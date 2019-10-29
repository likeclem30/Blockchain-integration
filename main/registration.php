<?php include "../../library/config.php" ?>
<?php $titlepage="Login Form System"; ?>
<?php include "../layout/top-header.php"; //header template ?> 


<?php 

require_once("../model/dbconn.php");
require_once("../model/pos.php");
 ?>

<link rel="stylesheet" href="../../dist/css/bootstrap-switch.min.css">
<link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><center><b>Agrikore-BlockChain</b></a>
    </div><!-- /.login-logo -->
    <div class="login-box-body"
      <p class="login-box-msg">Sign in to start your session</p>
      <form action="authorization.php" method="post">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" autofocus value="" name="fullname" id="fullname" placeholder="Fullname">
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>

<button type="submit" class="btn btn-primary " id="btnadd" name="btnadd"><i class="fa fa-plus"></i> Add User</button>



        <div class="form-group has-feedback">
          <input type="text" class="form-control" autofocus value="" name="username" id="username" placeholder="Username">
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>



         <div class="form-group has-feedback">
						<label for="Periode">Date of Birth : </label>
						<input readonly="" type="text" class="form-control txtperiode tgl" id="txtfirstperiod"  value="20-04-2017"  style="width:100px "> -
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

  <div id="modalmasteruser" class="modal fade ">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Master user Form</h4>
      </div>
      <!--modal header-->
      <div class="modal-body">
        <div class="form-horizontal">
          <div class="box-body">
            <div class="form-group">
              <label class="col-sm-2  control-label">Username</label>
              <div class="col-sm-6">
                <input type="text" class="form-control text-uppercase" id="txtusername" name="" value="" placeholder="">
                <input type="hidden" id="txtiduser" name="inputcrud" class="" value="0">
                <input type="hidden" id="inputcrud" name="inputcrud" class="" value="N">
                <input type="hidden" id="hmenu" name="" class="" value=""> </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2  control-label">Password</label>
                <div class="col-sm-6">
                  <input type="password" class="form-control " id="txtpass" name="" value="" placeholder=""> </div>
                </div>
              </div>
            </div>
            <!--form menuk-->
            <?php
            $pos = new pos();
            $mymenu = $pos->getMenu();
            $num=1;
            $menuku='';
            foreach ($mymenu[1] as $key) {
              if($num==1)
              {
                $menuku .= '<div class="row" >';
                $menuku .= '<div class="col-xs-6" style="padding-left:0px"><h4>'.$key['name_menu'].'</h4>';
                $submenuk = $pos->getSubMenu($key['id_menu']);
                $menuku .= '<ul class="list-group">'; 
                foreach ($submenuk[1] as $keys) {
                  $menuku .= '<li class="list-group-item">
                  <input type="checkbox"  id="check-'.$keys["id_sub_menu"].'" class="chkbox" value="'.$keys['id_sub_menu'].'" > <strong>'.$keys['name_sub_menu'].'</strong>
                  </li>'; 
                }
                $menuku .= '</ul>'; 
                $menuku .= '</div>';
              }else{
                $menuku .= '<div class="col-xs-6" style="padding-left:0px"><h4>'.$key['name_menu'].'</h4>';
                $submenuk = $pos->getSubMenu($key['id_menu']);
                $menuku .= '<ul class="list-group">'; 
                foreach ($submenuk[1] as $keys) {
                  $menuku .= '<li class="list-group-item"><input type="checkbox" id="check-'.$keys["id_sub_menu"].'" class="chkbox" value="'.$keys['id_sub_menu'].'" > <strong>'.$keys['name_sub_menu'].'</strong></li>'; 
                }
                $menuku .= '</ul>';
                $menuku .= '</div>';
                $menuku .= '</div>';
                $num=0;
              }
              $num++;
            }
            ?>
            <div class="form-horizontal menuk" >
              <div class="box-body">
                <div class="form-group">  
                  <label class="col-sm-2  control-label">Menu Access</label> 
                  <div class="col-xs-10">
                    <div>
                      <input type="checkbox" id="check-all" class="txtcheckbox2"> <b>Selected All</b>
                    </div>
                    <?php echo $menuku; ?>
                  </div> 
                </div>
              </div>
            </div> 
            <div class="form-horizontal">
              <div class="box-body">
                <div class="form-group">   
                  <label class="col-sm-2  control-label"></label>
                  <div class="col-sm-6">
                    <button type="submit" class="btn btn-primary " id="btnsaveuser" name="btnsaveuser"><i class="fa fa-save"></i> Save</button>
                  </div>  
                </div>
              </div>
            </div>
            <!--end form menuk-->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
          <!--modal footer-->
        </div>
        <!--modal-content-->
      </div>
      <!--modal-dialog modal-lg-->
    </div>
    <!--form-kantor-modal-->
  </div>

  <!-- modal dialog untuk password -->
  <div id="passwordmodal" class="modal fade ">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title">Reset Password</h4>
        </div><!--modal header--> 
        <div class="modal-body"><div class="form-horizontal"><div class="box-body"><div class="form-group">   <label class="col-sm-3  control-label">Reset Password</label>   <div class="col-sm-9"><input type="password" class="form-control " id="txtresetpass" name="txtresetpass" value="" placeholder=""><input type="hidden" id="txthiduser" name="" class="" value="">    </div>  </div><div class="form-group">   <label class="col-sm-3  control-label"><button type="submit" class="btn btn-primary " id="btnresetpassword" name="btnresetpassword"><i class="fa  fa-key"></i> Reset Password</button> <span id="infopassword"></span></label>   <div class="col-sm-9">    </div>  </div></div></div></div><div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div><!--modal footer-->
    </div><!--modal-content-->
  </div><!--modal-dialog modal-lg-->
</div>
<!-- end modal -->
  <center><p>Copyright &copy; <?php echo date("Y");?> Seegatesite.com., inc. All rights reserved</p></center>
  <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
  <script src="../../bootstrap/js/bootstrap.min.js"></script>
  <script src="../../plugins/bootstrap-notify/bootstrap-notify.min.js"></script>
  <script src="../../dist/js/myfunction.js" type="text/javascript"></script>
  <script src="../../dist/js/sweetalert.min.js" type="text/javascript"></script>

  <?php include "../layout/footer.php"; //footer template ?> 
<?php include "../layout/bottom-footer.php"; //footer template ?> 
<script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="j_mstuser.js"></script>
</body>
</html>
