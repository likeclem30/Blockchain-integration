


<?php include "../../library/config.php"; 
include ('number_format_short.php');?>
<?php $titlepage="Dashboard"; ?>
<?php
require_once("../model/dbconn.php");
require_once("../model/pos.php");
include "../layout/top-header.php"; 
include "../../library/check_login.php";

include "../layout/header.php"; 
?>


<section style="margin-bottom:10px;" class="content-header">
	<h1>
		Dashboard
		<!-- end of box-header 
		<small>Page</small> -->
	</h1>
</section>
<section class="content-main">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-solid box-danger">
				<?php
				$pos = new pos();
				$toko = $pos->getrefsytem();
				$nameshop = $toko[1]['name_shop'];
				$address_shop = $toko[1]['address_shop'];
				$phoneshop = $toko[1]['phone_shop'];
				?>
				<?php
				$pos = new pos();
				$block = $pos->getblockadd($_SESSION['pos_username']);
				$walletno = $block[1]['wphone'];
				$wallet_address = $block[1]['b_address'];



				function formatCur($value)
				{
					$formatted =  number_format(sprintf('%0.5f', preg_replace("/[^0-9.]/", "", $value)), 2);
					return $value < 0 ? "({$formatted})" : "{$formatted}";
				}

				$curl = curl_init();

				curl_setopt_array($curl, array(
				  CURLOPT_PORT => "8547",
				  CURLOPT_URL => "http://41.73.252.237:8547/gorder/vw/{%22op%22:%22getgordernum%22}",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "GET",
				  CURLOPT_HTTPHEADER => array(
					"Cache-Control: no-cache",
					"Postman-Token: fb82e988-6838-4948-a076-986f6577d4c0"
				  ),
				));
				
				$responsegordernum = curl_exec($curl);
				$err = curl_error($curl);
				
				curl_close($curl);
				
				if ($err) {
				  $echo = "cURL Error #:" . $err;
				} else {
					$gordernum = number_format(str_replace('"',"",$responsegordernum));
				}



				$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_PORT => "8547",
  CURLOPT_URL => "http://41.73.252.237:8547/grantor/vw/{%22op%22:%22getgrantornum%22}",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Cache-Control: no-cache"
  ),
));

$responsegrantornum = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  $echo = "cURL Error #:" . $err;
} else {
	$grantornum = number_format(str_replace('"',"",$responsegrantornum));
}


				$curl = curl_init();

				curl_setopt_array($curl, array(
				  CURLOPT_PORT => "8547",
				  CURLOPT_URL => "http://41.73.252.237:8547/loaner/vw/{%22op%22:%22getloanernum%22}",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "GET",
				  CURLOPT_HTTPHEADER => array(
					"Cache-Control: no-cache",
					"Postman-Token: 91aa1a51-c429-49d8-b4fa-79deebfa996f"
				  ),
				));
				
				$responseloanernum = curl_exec($curl);
				$err = curl_error($curl);
				
				curl_close($curl);
				
				if ($err) {
				  $echo = "cURL Error #:" . $err;
				} else {
					$loanernum = number_format(str_replace('"',"",$responseloanernum));
                }



				$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_PORT => "8547",
  CURLOPT_URL => "http://41.73.252.237:8547/dealer/vw/{%22op%22:%22getdealernum%22}",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Cache-Control: no-cache"
  ),
));

$responsedealersnum = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  $echo = "cURL Error #:" . $err;
} else {
	$dealersnum = number_format(str_replace('"',"",$responsedealersnum));
}





				$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_PORT => "8547",
  CURLOPT_URL => "http://41.73.252.237:8547/certifier/vw/{%22op%22:%22getcertifiernum%22}",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Cache-Control: no-cache"
  ),
));

$responsecertifiersnum = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  $echo = "cURL Error #:" . $err;
} else {
	$certifiersnum = number_format(str_replace('"',"",$responsecertifiersnum));
}




				$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_PORT => "8547",
  CURLOPT_URL => "http://41.73.252.237:8547/offtaker/vw/{%22op%22:%22getofftakernum%22}",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Cache-Control: no-cache",
    "Postman-Token: 8199566c-daa0-40a1-9d42-e6d63bb45525"
  ),
));

$responseofftakernum = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  $echo = "cURL Error #:" . $err;
} else {
	$offtakernum = number_format(str_replace('"',"",$responseofftakernum));
}

				
                 
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_PORT => "8547",
  CURLOPT_URL => "http://41.73.252.237:8547/buyer/vw/{%22op%22:%22getbuyernum%22}",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Cache-Control: no-cache"
  ),
));

$responsebuyernum = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  $echo = "cURL Error #:" . $err;
} else {
	$buyernum = number_format(str_replace('"',"",$responsebuyernum));
}




				$curl = curl_init();

				curl_setopt_array($curl, array(
				  CURLOPT_PORT => "8547",
				  CURLOPT_URL => "http://41.73.252.237:8547/farmer/vw/{%22op%22:%22getfarmernum%22}",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "GET",
				  CURLOPT_HTTPHEADER => array(
					"Cache-Control: no-cache"
				  ),
				));
				
				$responsefarnum = curl_exec($curl);
				$err = curl_error($curl);
				
				curl_close($curl);
				
				if ($err) {
				  $echo = "cURL Error #:" . $err;
				} else {
					$farnum = number_format(str_replace('"',"",$responsefarnum));
				}



				$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.agrikore.net/commodity/vw/{%22op%22:%22getcommnum%22}",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Cache-Control: no-cache"
  ),
));

$responsecomnum = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  $echo = "cURL Error #:" . $err;
} else {
  $commnum = number_format(str_replace('"',"",$responsecomnum));
}




				$curl = curl_init();

				curl_setopt_array($curl, array(
				  CURLOPT_URL => "https://www.agrikore.net/",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "GET",
				  CURLOPT_HTTPHEADER => array(
					"Cache-Control: no-cache",
					"Postman-Token: 5722e904-ac52-4d23-804a-64eb85385a6c"
				  ),
				));
				
				$responsenblocks = curl_exec($curl);
				$err = curl_error($curl);
				
				curl_close($curl);
				
				if ($err) {
					$connectbk = "Error";
				  $echo = "cURL Error #:" . $err;
				} else {
					$connectbk = null;
					$resultblock = json_decode($responsenblocks, true);
					$latestBlockNumber = number_format(($resultblock['latestBlockNumber']));
				}


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.agrikore.net/addresses/$wallet_address",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Cache-Control: no-cache",
    "Postman-Token: b1c15b8c-2dfe-4539-816f-7d1bfe1c5ec0"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  $echo = "cURL Error #:" . $err;
  $connect = "Error";
} else {
	$connect = null;
  //echo $response;
 $result3 = json_decode($response, true);
  // -----------Publickey,Privatekey,Address----------------
  $mulaBalance = formatCur((($result3['mulaBalance'])/1000000000000000000));
  $nairaBalance = formatCur((($result3['nairaBalance'])/1000000000000000000));
  $dollarBalance = formatCur((($result3['dollarBalance'])/1000000000000000000));
  $mulaLBalance = formatCur((($result3['mulaLBalance'])/1000000000000000000));
  $mulaCBalance = formatCur((($result3['mulaCBalance'])));
  $mulaSGBalance = formatCur((($result3['mulaSGBalance'])/1000000000000000000));
  $mulaCGBalance = formatCur((($result3['mulaCGBalance'])/1000000000000000000));
  $isFarmer = str_replace("","N",($result3['isFarmer']));
  $isBuyer = ($result3['isBuyer']);
  $isOfftaker = ($result3['isOfftaker']);
  $isCertifier = ($result3['isCertifier']);
  $isLoaner = ($result3['isLoaner']);
  $isDealer = ($result3['isDealer']);
  $isGrantor = ($result3['isGrantor']);
  $isGuaranteedOrder = ($result3['isGuaranteedOrder']);
  $isAgroLoan = ($result3['isAgroLoan']);
  
}
				?>
				<div class="box-header">
					<h1 class="box-title"><?php echo $nameshop.":".$wallet_address."--<font color=#01C0EF>Wallet Acct No :</font><b>".$walletno;?></h1>
				</div> <!-- end of box-header -->
				<div class="box-body">
					<center>
						<div>
				<button type="button" class="btn btn-primary">
				mulaBal: <span class="badge badge-light"><?php 
				if ($connect != null) {
                 echo "Connect-Error";
                } else {echo $mulaBalance;}?></span>
				</button>
				<button type="button" class="btn btn-primary">
				nairaBal: <span class="badge badge-secondary"><?php 
				if ($connect != null) {
                 echo "Connect-Error";
                } else {echo $nairaBalance;}?></span>
				</button>
				<button type="button" class="btn btn-primary">
				dollarBal: <span class="badge badge-secondary"><?php if ($connect != null) {
                 echo "Connect-Error";
                } else {echo $dollarBalance;}?></span>
				</button>
				<button type="button" class="btn btn-primary">
				mulaLBal: <span class="badge badge-secondary"><?php if ($connect != null) {
                 echo "Connect-Error";
                } else {echo $mulaLBalance;}?></span>
				</button>
				<button type="button" class="btn btn-primary">
				mulaCBal: <span class="badge badge-secondary"><?php if ($connect != null) {
                 echo "Connect-Error";
                } else {echo $mulaCBalance;}?></span>
				</button>
				<button type="button" class="btn btn-primary">
				mulaSGBal: <span class="badge badge-secondary"><?php if ($connect != null) {
                 echo "Connect-Error";
                } else {echo $mulaSGBalance;}?></span>
				</button>
				<button type="button" class="btn btn-primary">
				mulaCGBal: <span class="badge badge-secondary"><?php if ($connect != null) {
                 echo "Connect-Error";
                } else {echo $mulaCGBalance;}?></span>
				</button>
				
</div>
<br><br>
<div>
<button type="button" class="btn btn-primary">
				a-Farmer: <span class="badge badge-secondary"><?php if ($connect != null) {
                 echo "Connect-Error";
                } else {if ($isFarmer == null){echo "N";}else{echo "Y";}};?></span>
				</button>
				<button type="button" class="btn btn-primary">
				a-Buyer(CCB): <span class="badge badge-secondary"><?php if ($connect != null) {
                 echo "Connect-Error";
                } else {if ($isBuyer == null){echo "N";}else{echo "Y";}};?></span>
				</button>
				<button type="button" class="btn btn-primary">
				a-OffTaker: <span class="badge badge-secondary"><?php if ($connect != null) {
                 echo "Connect-Error";
                } else {if ($isOfftaker == null){echo "N";}else{echo "Y";}};?></span>
				</button>
				<button type="button" class="btn btn-primary">
				a-Certifier: <span class="badge badge-secondary"><?php if ($connect != null) {
                 echo "Connect-Error";
                } else {if ($isCertifier == null){echo "N";}else{echo "Y";}};?></span>
				</button>
				<button type="button" class="btn btn-primary">
				a-Loaner: <span class="badge badge-secondary"><?php if ($connect != null) {
                 echo "Connect-Error";
                } else {if ($isLoaner == null){echo "N";}else{echo "Y";}};?></span>
				</button>

                <button type="button" class="btn btn-primary">
				a-Dealer: <span class="badge badge-secondary"><?php if ($connect != null) {
                 echo "Connect-Error";
                } else {if ($isDealer == null){echo "N";}else{echo "Y";}};?></span>
				</button>
				<button type="button" class="btn btn-primary">
				a-Grantor: <span class="badge badge-secondary"><?php if ($connect != null) {
                 echo "Connect-Error";
                } else {if ($isGrantor == null){echo "N";}else{echo "Y";}};?></span>
				</button>
				<button type="button" class="btn btn-primary">
				GuaranteedOrder: <span class="badge badge-secondary"><?php if ($connect != null) {
                 echo "Connect-Error";
                } else {if ($isGuaranteedOrder == null){echo "N";}else{echo "Y";}};?></span>
				</button>
				<button type="button" class="btn btn-primary">
				AgroLoan: <span class="badge badge-secondary"><?php if ($connect != null) {
                 echo "Connect-Error";
                } else {if ($isAgroLoan == null){echo "N";}else{echo "Y";}};?></span>
				</button>
</div>
</center>
				
				
				</div> <!-- end of box-body -->
			</div><!-- end of box box-solid bg-light-blue-gradiaent -->
		</div>
	</div><!-- row -->
	

<div class="box-body">
			<div class="row">
				<div class="col-md-15">
					
					<button type="submit" class="btn btn-primary " id="btnaddrequest" name=""><i class="fa fa-plus"></i> Buy Mula/Dollar/Naira</button>
					<button type="submit" class="btn btn-primary " id="btnadd" name=""><i class="fa fa-plus"></i> Manage Currency</button>
					<button type="submit" class="btn btn-primary " id="btnadd" name=""><i class="fa fa-plus"></i> Locations</button>
				<button type="submit" class="btn btn-primary " id="btnadd" name=""><i class="fa fa-plus"></i> Agrodealers</button>
				<button type="submit" class="btn btn-primary " id="btnadd" name=""><i class="fa fa-plus"></i> Fund Account</button>
				<button type="submit" class="btn btn-primary " id="btnadd" name=""><i class="fa fa-plus"></i> Create Certifier</button>
				<button type="submit" class="btn btn-primary " id="btnadd" name=""><i class="fa fa-plus"></i> Pay Bills</button>
				<button type="submit" class="btn btn-primary " id="btnadd" name=""><i class="fa fa-plus"></i> Confirm Receipt</button>
				<button type="submit" class="btn btn-primary " id="btnadd" name=""><i class="fa fa-plus"></i> Produce Receipt</button>

					
					<br>
					<br>
					<br>
				</div>
			</div>
</div>




		<div class="col-md-2">
			<div class="small-box bg-green">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $latestBlockNumber; }?></h3>
					<p>Latest Block Number</p>
					
				</div>
				<div class="icon">
					<i class="ion ion-stats-bars"></i>
				</div>
				<a href="#" id="lapjuals" class="small-box-footer"> More Detail <i class="fa fa-arrow-circle-right"></i></a>
			</div><!-- end of small-box-green -->
			</div>

			

               <div class="col-md-2">
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $commnum; }?></h3>
					<p>Number of Commodity</p>
				</div>
				<div class="icon">
					<i class="ion icomoon-coin-dollar"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->
		</div><!-- end of row -->
			
		<div class="col-md-2">
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $farnum;} ?></h3>
					<p>Number of Farmers</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->

			
		</div><!-- end of row -->
			
		<div class="col-md-2">
			<div class="small-box bg-red">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $buyernum;} ?></h3>
					<p>Commodity Buyers</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->

			
		</div><!-- end of row -->

		<div class="col-md-2">
			<div class="small-box white bg-olive">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $offtakernum;} ?></h3> 
					<p>Commodity OffTaker</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->

			
		</div><!-- end of row -->

		<div class="col-md-2">
			<div class="small-box white bg-maroon">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $certifiersnum;} ?></h3> 
					<p>Commodity Certifiers</p> 
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->

			
		</div><!-- end of row -->
<br/>
              <div class="col-md-2">
			<div class="small-box white bg-teal">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $dealersnum;} ?></h3>
					<p>Commodity Dealers</p> 
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->

			
		</div><!-- end of row -->
		<div class="col-md-2">
			<div class="small-box white bg-lime">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $loanernum;} ?></h3>
					<p>Market Financier</p> 
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->

			
		</div><!-- end of row -->

			<div class="col-md-2">
			<div class="small-box white white bg-navy">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $grantornum;} ?></h3>
					<p>Grantor/Donor</p>  
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->

			
		</div><!-- end of row -->

		<div class="col-md-2">
			<div class="small-box white bg-lighten-4">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $gordernum;} ?></h3>
					<p>Guaranteed Order</p> 
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->

			
		</div><!-- end of row -->

		<div class="col-md-2">
			<div class="small-box white bg-fuchsia">
				<div class="inner">
					<h3>10</h3>
					<p>Out of stock items</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->

			
		</div><!-- end of row -->

<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.agrikore.net/location/vw/{%22op%22:%22getlocnum%22}",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Cache-Control: no-cache",
    "Postman-Token: 06e0bb09-eb89-4c8f-8e59-910c63e222bb"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  $echo = $response;
}
?>
		<div class="col-md-2">
			<div class="small-box bg-blue">
				<div class="inner">
					<h3><?php echo str_replace('"',"",$response) ?></h3>
					<p>Defined Locations</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->

			
		</div><!-- end of row -->

		<br/>
		
		<div class="col-md-2">
			<div class="small-box bg-silver">
				<div class="inner">
					<h3>30</h3>
					<p>Today Sales</p>
					
				</div>
				<div class="icon">
					<i class="ion ion-stats-bars"></i>
				</div>
				<a href="#" id="lapjuals" class="small-box-footer"> More Detail <i class="fa fa-arrow-circle-right"></i></a>
			</div><!-- end of small-box-green -->
			</div>

			

               <div class="col-md-2">
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3>10</h3>
					<p>Out of stock items</p>
				</div>
				<div class="icon">
					<i class="ion icomoon-coin-dollar"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->
		</div><!-- end of row -->
			
		<div class="col-md-2">
			<div class="small-box bg-lighten-1">
				<div class="inner">
					<h3>10</h3>
					<p>Out of stock items</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->

			
		</div><!-- end of row -->
			
		<div class="col-md-2">
			<div class="small-box bg-red">
				<div class="inner">
					<h3>10</h3>
					<p>Out of stock items</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->

			
		</div><!-- end of row -->

		<div class="col-md-2">
			<div class="small-box bg-orange">
				<div class="inner">
					<h3>10</h3>
					<p>Out of stock items</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->

			
		</div><!-- end of row -->

		<div class="col-md-2">
			<div class="small-box white bg-gray">
				<div class="inner">
					<h3>10</h3>
					<p>Out of stock items</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->

			
		</div><!-- end of row -->



	</section>
	<?php include "../layout/footer.php"; //footer template ?> 
	<?php include "../layout/bottom-footer.php"; //footer template ?> 
	<script src="../../dist/js/redirect.js"></script>
	<script>
		$(document).on("keyup keydown","#txtsearchitem",function(){
			var searchitem = $("#txtsearchitem").val();
			value={
				term : searchitem,
			}
			$.ajax(
			{   async: true,
				url : "../master/c_search_item.php",
				type: "POST",
				data : value,
				success: function(data, textStatus, jqXHR)
				{
					var data = jQuery.parseJSON(data);
					$("#table_search tbody").html(data.data)
				},
				error: function(jqXHR, textStatus, errorThrown)
				{
					
				}
			});
		});

	</script>
	
</body>
</html>
