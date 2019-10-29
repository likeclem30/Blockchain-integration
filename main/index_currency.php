


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
    CURLOPT_URL => "http://41.73.252.237:8547/naira",
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
  $nairaTotalSupply = formatCur((($result3['nairaTotalSupply'])/1000000000000000000));
  $nairaTotalReserve = formatCur((($result3['nairaTotalReserve'])/1000000000000000000));
  $nairaTotalCirculation = formatCur((($result3['nairaTotalCirculation'])/1000000000000000000));
  $nairaPurchasePrice = formatCur((($result3['nairaPurchasePrice'])/1000000000000000000));
  $nairaSellbackPrice = formatCur((($result3['nairaSellbackPrice'])/1000000000000000000));
  $nairaTransactionFeeFixed = formatCur((($result3['nairaTransactionFeeFixed'])/1000000000000000000));
  $nairaTransactionFeePercentage = formatCur((($result3['nairaTransactionFeePercentage'])/1000000000000000000));
  $nairaMinimumAmountAllowed = formatCur((($result3['nairaMinimumAmountAllowed'])/1000000000000000000));
  $nairaMaximumAmountAllowed = formatCur((($result3['nairaMaximumAmountAllowed'])/1000000000000000000));
  $nairaOffchainReserve = formatCur((($result3['nairaOffchainReserve'])/1000000000000000000));
  $isMulaBuyOpenedForNaira = ($result3['isMulaBuyOpenedForNaira']);
  $isMulaSellOpenedForNaira = ($result3['isMulaSellOpenedForNaira']);
}
//--------------dollar-------------------------
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => "8547",
    CURLOPT_URL => "http://41.73.252.237:8547/dollar",
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

$responsedol = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  $echo = "cURL Error #:" . $err;
  $connect = "Error";
} else {
	$connect = null;
  //echo $response;
 $result3 = json_decode($responsedol, true);
  // -----------Publickey,Privatekey,Address----------------
  $dollarTotalSupply = formatCur((($result3['dollarTotalSupply'])/1000000000000000000));
  $dollarTotalReserve = formatCur((($result3['dollarTotalReserve'])/1000000000000000000));
  $dollarTotalCirculation = formatCur((($result3['dollarTotalCirculation'])/1000000000000000000));
  $dollarPurchasePrice = formatCur((($result3['dollarPurchasePrice'])/1000000000000000000));
  $dollarSellbackPrice = formatCur((($result3['dollarSellbackPrice'])/1000000000000000000));
  $dollarTransactionFeeFixed = formatCur((($result3['dollarTransactionFeeFixed'])/1000000000000000000));
  $dollarTransactionFeePercentage = formatCur((($result3['dollarTransactionFeePercentage'])/1000000000000000000));
  $dollarMinimumAmountAllowed = formatCur((($result3['dollarMinimumAmountAllowed'])/1000000000000000000));
  $dollarMaximumAmountAllowed = formatCur((($result3['dollarMaximumAmountAllowed'])/1000000000000000000));
  $dollarOffchainReserve = formatCur((($result3['dollarOffchainReserve'])/1000000000000000000));
}

//--------------------------mula--------------------
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => "8547",
    CURLOPT_URL => "http://41.73.252.237:8547/mula",
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

$responsemula = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  $echo = "cURL Error #:" . $err;
  $connect = "Error";
} else {
	$connect = null;
  //echo $response;
 $resultmula = json_decode($responsemula, true);
  // -----------Publickey,Privatekey,Address----------------
  $mulaTotalSupply = formatCur((($resultmula['mulaTotalSupply'])/1000000000000000000));
  $mulaTotalReserve = formatCur((($resultmula['mulaTotalReserve'])/1000000000000000000));
  $mulaTotalCirculation = formatCur((float)(($resultmula['mulaTotalCirculation'])/1000000000000000000));

  $mulaTransactionFeeFixed = formatCur((($resultmula['mulaTransactionFeeFixed'])/1000000000000000000));
  $mulaTransactionFeePercentage = formatCur((($resultmula['mulaTransactionFeePercentage'])/1000000000000000000));
  $mulaMinimumAmountAllowed = formatCur((($resultmula['mulaMinimumAmountAllowed'])/1000000000000000000));
  $mulaMaximumAmountAllowed = formatCur((($resultmula['mulaMaximumAmountAllowed'])/1000000000000000000));
  
}


$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => "8547",
    CURLOPT_URL => "http://41.73.252.237:8547/gorder",
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

$responseg = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  $echo = "cURL Error #:" . $err;
  $connect = "Error";
} else {
	$connect = null;
  //echo $response;
 $result3 = json_decode($responseg, true);
  
  $mulaBTotalSupply = formatCur((($result3['mulaBTotalSupply'])/1000000000000000000));
  $mulaBTotalReserve = formatCur((($result3['mulaBTotalReserve'])/1000000000000000000));
  $mulaBTotalCirculation = formatCur((($result3['mulaBTotalCirculation'])/1000000000000000000));
  $totalInOrders = formatCur((($result3['totalInOrders'])/1000000000000000000));
  $bminimumAmount = formatCur((($result3['minimumAmount'])/1000000000000000000));
  $bmaximumAmount = formatCur((($result3['maximumAmount'])/1000000000000000000));
  $totalNumberOfOrders = (($result3['totalNumberOfOrders']));
  $coveredInOrders = formatCur((($result3['coveredInOrders'])/1000000000000000000));
  $bondedInOrders = formatCur((($result3['bondedInOrders'])/1000000000000000000));
  $mulaBPurchasePrice = formatCur((($result3['mulaBPurchasePrice'])/1000000000000000000));
  $mulaBSellbackPrice = formatCur((($result3['mulaBSellbackPrice'])/1000000000000000000));

}

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => "8547",
    CURLOPT_URL => "http://41.73.252.237:8547/agloan",
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

$responseagl = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  $echo = "cURL Error #:" . $err;
  $connect = "Error";
} else {
	$connect = null;
  //echo $response;
 $result3 = json_decode($responseagl, true);
  // -----------Publickey,Privatekey,Address----------------
  $totalSupply = formatCur((($result3['totalSupply'])/1000000000000000000));
  $totalReserves = formatCur((($result3['totalReserves'])/1000000000000000000));
  $totalCirculation = formatCur((($result3['totalCirculation'])/1000000000000000000));
  $buyPrice = formatCur((($result3['buyPrice'])/1000000000000000000));
  $sellPrice = formatCur((($result3['sellPrice'])/1000000000000000000));
  $totalIssueds = formatCur((($result3['totalIssueds'])/1000000000000000000));
  $totalInLoans = formatCur((($result3['totalInLoans'])/1000000000000000000));
  $totalExpended = formatCur((($result3['totalExpended'])/1000000000000000000));
  $totalInterests = formatCur((($result3['totalInterests'])/1000000000000000000));
  $totalInterestsPaid = formatCur((($result3['totalInterestsPaid'])/1000000000000000000));
  $aminimumAmount = formatCur((($result3['minimumAmount'])/1000000000000000000));
  $amaximumAmount = formatCur((($result3['maximumAmount'])/1000000000000000000));
}

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => "8547",
    CURLOPT_URL => "http://41.73.252.237:8547/muloan",
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

$responsemuloan = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  $echo = "cURL Error #:" . $err;
  $connect = "Error";
} else {
	$connect = null;
  //echo $response;
 $resultmuloan = json_decode($responsemuloan, true);
  // -----------Publickey,Privatekey,Address----------------
  $lfeeFixed = formatCur((($resultmuloan['feeFixed'])/1000000000000000000));
  $lfeePercentage = formatCur((($resultmuloan['feePercentage'])/1000000000000000000));
  $lcommissionPercentage = formatCur((($resultmuloan['commissionPercentage'])/1000000000000000000));
  //$buyPrice = formatCur((($resultmuloan['buyPrice'])/1000000000000000000));
  //$sellPrice = formatCur((($resultmuloan['sellPrice'])/1000000000000000000));
  $ltotalIssueds = formatCur((($resultmuloan['totalIssueds'])/1000000000000000000));
  $ltotalInLoans = formatCur((($resultmuloan['totalInLoans'])/1000000000000000000));
  $ltotalCommissionPaid = formatCur((($resultmuloan['totalCommissionPaid'])/1000000000000000000));
  $ltotalInterests = formatCur((($resultmuloan['totalInterests'])/1000000000000000000));
  $ltotalInterestsPaid = formatCur((($resultmuloan['totalInterestsPaid'])/1000000000000000000));
  $lminimumAmount = formatCur((($resultmuloan['minimumAmount'])/1000000000000000000));
  $lmaximumAmount = formatCur((($resultmuloan['maximumAmount'])/1000000000000000000));
}



/**
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_PORT => "8547",
    CURLOPT_URL => "http://41.73.252.237:8547/mula",
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

$responseamula = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  $echo = "cURL Error #:" . $err;
  $connect = "Error";
} else {
	$connect = null;
  //echo $response;
 $resultmula = json_decode($responseamula, true);
  
  $mulaTotalSupply = number_format((($resultmula['mulaTotalSupply'])/1000000000000000000));
  $mulaTotalReserve = number_format((($resultmula['mulaTotalReserve'])/1000000000000000000));
  $mulaTotalCirculation = number_format((($resultmula['mulaTotalCirculation'])/1000000000000000000));
  $mulaTransactionFee = number_format((($resultmula['mulaTransactionFee'])/1000000000000000000));
  $mulaMinimumAmountAllowed = number_format((($resultmula['mulaMinimumAmountAllowed'])/1000000000000000000));
  $mulaMaximumAmountAllowed = number_format((($resultmula['mulaMaximumAmountAllowed'])/1000000000000000000));
 
}

 */

				?>
				<div class="box-header">
					<h1 class="box-title"><?php echo $nameshop.":--<font color=white>  Naira Currency Information</font><b>";?></h1>
				</div> <!-- end of box-header -->
				
			</div><!-- end of box box-solid bg-light-blue-gradiaent -->
		</div>
	</div><!-- row -->
	
                 

		<div class="col-md-3">
			<div class="small-box #ffebee red bg-red">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $nairaOffchainReserve; }?></h3>
					<p>Total NAIRA-Offchain(R)</p>
					
				</div>
				<div class="icon">
					<i class="ion ion-stats-bars"></i>
				</div>
				<a href="#" id="lapjuals" class="small-box-footer"> More Detail <i class="fa fa-arrow-circle-right"></i></a>
			</div><!-- end of small-box-green -->
			</div>

			

               <div class="col-md-3">
			<div class="small-box white bg-lighten-4">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $nairaTotalReserve; }?></h3>
					<p>Total NAIRA-Onchain(Reserve)</p>
				</div>
				<div class="icon">
					<i class="ion icomoon-coin-dollar"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->
		</div><!-- end of row -->
			
		<div class="col-md-3">
			<div class="small-box white bg-orange">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $nairaTotalCirculation;} ?></h3>
					<p>Total NAIRA-Circulation</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->

			
		</div><!-- end of row -->
			
        <div class="col-md-3">
			<div class="small-box black bg-gray">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $nairaMaximumAmountAllowed;} ?></h3> 
					<p>Max Naira-Transaction</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->

			
		</div><!-- end of row -->

		<div class="col-md-3">
			<div class="small-box red bg-gray">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $nairaMinimumAmountAllowed;} ?></h3>
					<p>Min-Naira Transaction</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->
	
		</div><!-- end of row -->

		<div class="col-md-3">
			<div class="small-box white bg-purple">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $nairaPurchasePrice;} ?></h3> 
					<p>Naira Buying Rate</p> 
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div>
            
		</div><!-- end of row -->
        <div class="col-md-3">
			<div class="small-box white bg-blue">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $nairaSellbackPrice;} ?></h3> 
					<p>Naira Selling Rate</p> 
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div>
            
		</div>
        <div class="col-md-3">
			<div class="small-box white bg-lighten-4">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $nairaTransactionFeeFixed;} ?></h3> 
					<p>Transaction Fees-Fixed(Naira)</p> 
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div>
            
		</div>
		<div class="col-md-3">
			<div class="small-box white bg-lighten-4">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $nairaTransactionFeePercentage;} ?></h3> 
					<p>Transaction Fees-Fixed(%)(Naira)</p> 
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div>
            
		</div>
<br/>

<div class="row">
		<div class="col-xs-12">
			<div class="box box-solid box-success">

				<div class="box-header">
					<h1 class="box-title"><?php echo $nameshop.":--<font color=white>  :Dollar Currency Information </font><b>";?></h1>
				</div> <!-- end of box-header -->
				
			</div><!-- end of box box-solid bg-light-blue-gradiaent -->
		</div>
	</div><!-- row -->

           <div class="col-md-3">
			<div class="small-box yellow bg-green">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $dollarOffchainReserve; }?></h3>
					<p>Total dollar-Offchain(R)</p>
					
				</div>
				<div class="icon">
					<i class="ion ion-stats-bars"></i>
				</div>
				<a href="#" id="lapjuals" class="small-box-footer"> More Detail <i class="fa fa-arrow-circle-right"></i></a>
			</div><!-- end of small-box-green -->
			</div>

			

               <div class="col-md-3">
			<div class="small-box white bg-orange">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $dollarTotalReserve; }?></h3>
					<p>Total dollar-Onchain(Reserve)</p>
				</div>
				<div class="icon">
					<i class="ion icomoon-coin-dollar"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->
		</div><!-- end of row -->
			
		<div class="col-md-3">
			<div class="small-box white bg-lime darken-4">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $dollarTotalCirculation;} ?></h3>
					<p>Total dollar-Circulation</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->

			
		</div><!-- end of row -->
			
        <div class="col-md-3">
			<div class="small-box white bg-purple">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $dollarMaximumAmountAllowed;} ?></h3> 
					<p>Max dollar-Transaction</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->

			
		</div><!-- end of row -->

		<div class="col-md-3">
			<div class="small-box white bg-orange">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $dollarMinimumAmountAllowed;} ?></h3>
					<p>Min-dollar Transaction</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->
	
		</div><!-- end of row -->

		<div class="col-md-3">
			<div class="small-box black bg-gray">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $dollarPurchasePrice;} ?></h3> 
					<p>dollar Buying Rate</p> 
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div>
            
		</div><!-- end of row -->
        <div class="col-md-3">
			<div class="small-box white bg-black">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $dollarSellbackPrice;} ?></h3> 
					<p>dollar Selling Rate</p> 
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div>
            
		</div>
        <div class="col-md-3">
			<div class="small-box white bg-blue">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $dollarTransactionFeeFixed;} ?></h3> 
					<p>Transaction Fees-Fixed(dollar)</p> 
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div>
            
		</div>

		<div class="col-md-3">
			<div class="small-box white bg-blue">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $dollarTransactionFeePercentage;} ?></h3> 
					<p>Transaction Fees-%(dollar)</p> 
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div>
            
		</div>
<br>


<div class="row">
		<div class="col-xs-12">
			<div class="box box-solid box-success">

				<div class="box-header">
					<h1 class="box-title"><?php echo $nameshop.":--<font color=white>  :Mula Currency Information </font><b>";?></h1>
				</div> <!-- end of box-header -->
				
			</div><!-- end of box box-solid bg-light-blue-gradiaent -->
		</div>
	</div><!-- row -->

           <div class="col-md-3">
			<div class="small-box yellow bg-orange">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $mulaTotalSupply; }?></h3>
					<p>Total Supply</p>
					
				</div>
				<div class="icon">
					<i class="ion ion-stats-bars"></i>
				</div>
				<a href="#" id="lapjuals" class="small-box-footer"> More Detail <i class="fa fa-arrow-circle-right"></i></a>
			</div><!-- end of small-box-green -->
			</div>

			

               <div class="col-md-3">
			<div class="small-box white bg-green">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $mulaTotalReserve; }?></h3>
					<p>Total Mula(Reserve)</p>
				</div>
				<div class="icon">
					<i class="ion icomoon-coin-dollar"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->
		</div><!-- end of row -->
			
		<div class="col-md-3">
			<div class="small-box white bg-lime darken-4">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $mulaTotalCirculation;} ?></h3>
					<p>Total mula-Circulation</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->

			
		</div><!-- end of row -->
			
        <div class="col-md-3">
			<div class="small-box white bg-dark">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $mulaTransactionFeeFixed;} ?></h3> 
					<p>Mula Transaction Fee-Fixed</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->

			
		</div><!-- end of row -->
		<div class="col-md-3">
			<div class="small-box white bg-dark">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $mulaTransactionFeePercentage;} ?></h3> 
					<p>Mula Transaction Fee-%</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->

			
		</div><!-- end of row -->
		<div class="col-md-3">
			<div class="small-box white bg-orange">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $mulaMinimumAmountAllowed;} ?></h3>
					<p>Min-Mula Transaction</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->
	
		</div><!-- end of row -->

		<div class="col-md-3">
			<div class="small-box black bg-gray">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $mulaMaximumAmountAllowed;} ?></h3> 
					<p>Maximum Mula Trans.</p> 
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div>
            
		</div><!-- end of row -->
       




<div class="row">
		<div class="col-xs-12">
			<div class="box box-solid box-info">

				<div class="box-header">
					<h1 class="box-title"><?php echo $nameshop.":--<font color=white>  Mula(C)-Produce Order SMART CONTRACT Informatin</font><b>";?></h1>
				</div> <!-- end of box-header -->
				
			</div><!-- end of box box-solid bg-light-blue-gradiaent -->
		</div>
	</div><!-- row -->
    <div class="col-md-3">
			<div class="small-box tan white bg-blue">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $mulaBTotalReserve; }?></h3>
					<p>Total mulaC in Reserve</p>
				</div>
				<div class="icon">
					<i class="ion icomoon-coin-dollar"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->
		</div><!-- end of row -->
			
		<div class="col-md-3">
			<div class="small-box white bg-red">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $mulaBTotalSupply;} ?></h3>
					<p>Total mulaC-Supply</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->

			
		</div><!-- end of row -->

        <div class="col-md-3">
			<div class="small-box black bg-tan">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $mulaBTotalCirculation;} ?></h3>
					<p>Total mulaC-Circulation</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->

			
		</div><!-- end of row -->

        
        <div class="col-md-3">
			<div class="small-box white bg-yellow">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $totalNumberOfOrders;} ?></h3> 
					<p>Smart Contracts</p> 
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div>
       </div>

        <div class="col-md-3">
			<div class="small-box blue bg-green">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $totalInOrders;} ?></h3> 
					<p>Total Value of S.C</p> 
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div>
       </div>

        <div class="col-md-3">
			<div class="small-box white bg-gray">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $coveredInOrders;} ?></h3> 
					<p>Total Cover of S.C</p> 
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div>
       </div>

        <div class="col-md-3">
			<div class="small-box white bg-purple">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $bondedInOrders;} ?></h3> 
					<p>Total Bond of S.C</p> 
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div>
       </div>
       
			
        <div class="col-md-3">
			<div class="small-box white bg-orange">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $bmaximumAmount;} ?></h3> 
					<p>Max mulaC-Transaction</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->

			
		</div><!-- end of row -->
        <div class="col-md-3">
			<div class="small-box white bg-blue">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $bminimumAmount;} ?></h3> 
					<p>Min mulaC-Transaction</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->
		</div><!-- end of row -->





		<div class="col-md-3">
			<div class="small-box white bg-lighten-4">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $mulaBPurchasePrice;} ?></h3>
					<p>MulaC Xchange Rate(Buying)</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->
	
		</div><!-- end of row -->

		        <div class="col-md-3">
			<div class="small-box white bg-yellow">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $mulaBSellbackPrice;} ?></h3> 
					<p>MulaC Xchange Rate(Selling)</p> 
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div>
       </div>

<div class="row">
		<div class="col-xs-12">
			<div class="box box-solid box-info">

				<div class="box-header">
					<h1 class="box-title"><?php echo $nameshop.":--<font color=white>  Mula(C)-Agric-Loan-SMART CONTRACT Informatin</font><b>";?></h1>
				</div> <!-- end of box-header -->
				
			</div><!-- end of box box-solid bg-light-blue-gradiaent -->
		</div>
	</div><!-- row -->
		
    <div class="col-md-3">
			<div class="small-box white bg-blue">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $totalSupply; }?></h3>
					<p>Total mulaC Supply</p>
				</div>
				<div class="icon">
					<i class="ion icomoon-coin-dollar"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->
		</div><!-- end of row -->
			
		<div class="col-md-3">
			<div class="small-box white bg-purple">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $totalReserves;} ?></h3>
					<p>Total mulaC in Reserve</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->

			
		</div><!-- end of row -->
			
        <div class="col-md-3">
			<div class="small-box white bg-lighten-4">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $totalCirculation;} ?></h3> 
					<p>mulaC-Circulation</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->
	
		</div><!-- end of row -->



		<div class="col-md-3">
			<div class="small-box white bg-black">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $aminimumAmount;} ?></h3>
					<p>Minimum-Loan(MulaC)</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->
	
		</div><!-- end of row -->

        <div class="col-md-3">
			<div class="small-box white bg-lighten-4">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $amaximumAmount;} ?></h3>
					<p>Maximum-Loan(MulaC)</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->
	
		</div><!-- end of row -->


         <div class="col-md-3">
			<div class="small-box white bg-red">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $totalInLoans;} ?></h3> 
					<p>Total Agric-loan Available</p> 
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div>
       </div>

       
       <div class="col-md-3">
			<div class="small-box white bg-orange">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $totalExpended;} ?></h3> 
					<p>Total Agric-loan Expended</p> 
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div>
       </div>
       
       <div class="col-md-3">
			<div class="small-box white bg-tan">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $totalInterests;} ?></h3> 
					<p>Total Agric-loan Interest</p> 
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div>
       </div>
       
       <div class="col-md-3">
			<div class="small-box white bg-green">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $totalInterestsPaid;} ?></h3> 
					<p>Total Interest Paid</p> 
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div>
       </div>

	   <div class="row">
		<div class="col-xs-12">
			<div class="box box-solid box-info">

				<div class="box-header">
					<h1 class="box-title"><?php echo $nameshop.":--<font color=white>  Mula(L)-General Purpose-Loan-SMART CONTRACT Informatin</font><b>";?></h1>
				</div> <!-- end of box-header -->
				
			</div><!-- end of box box-solid bg-light-blue-gradiaent -->
		</div>
	</div><!-- row -->
		
    <div class="col-md-3">
			<div class="small-box white bg-blue">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $ltotalInLoans; }?></h3>
					<p>Total mulaL Supply</p>
				</div>
				<div class="icon">
					<i class="ion icomoon-coin-dollar"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->
		</div><!-- end of row -->
			
		<div class="col-md-3">
			<div class="small-box white bg-purple">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $ltotalIssueds;} ?></h3>
					<p>Total mulaL Issued</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->

			
		</div><!-- end of row -->
			
        <div class="col-md-3">
			<div class="small-box white bg-lighten-4">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $ltotalCommissionPaid;} ?></h3> 
					<p>Total mulaL-Commission</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->
	
		</div><!-- end of row -->



		<div class="col-md-3">
			<div class="small-box white bg-black">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $lminimumAmount;} ?></h3>
					<p>Minimum-Loan(MulaL)</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->
	
		</div><!-- end of row -->

        <div class="col-md-3">
			<div class="small-box white bg-lighten-4">
				<div class="inner">
					<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $lmaximumAmount;} ?></h3>
					<p>Maximum-Loan(MulaL)</p>
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div><!-- end of col md 4 -->
	
		</div><!-- end of row -->


         <div class="col-md-3">
			<div class="small-box white bg-red">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $lfeeFixed;} ?></h3> 
					<p>Mula loan Fixed Fee</p> 
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div>
       </div>

       
       <div class="col-md-3">
			<div class="small-box white bg-orange">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $lfeePercentage;} ?></h3> 
					<p>Mula-loan %-fee</p> 
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div>
       </div>
       
       <div class="col-md-3">
			<div class="small-box white bg-tan">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo $ltotalInterests;} ?></h3> 
					<p>Total Mula-loan Interest</p> 
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div>
       </div>
       
       <div class="col-md-3">
			<div class="small-box white bg-green">
				<div class="inner">
				<h3><?php if ($connect != null) {
                 echo "C-Error";
                } else {echo  $ltotalInterestsPaid;} ?></h3> 
					<p>Total Interest Paid</p> 
				</div>
				<div class="icon">
					<i class="ion ion-bank"></i>
				</div>
				<a href="<?php echo $sitename;?>application/mutasi/l_barang_abis.php" target="_blank" class="small-box-footer">Info detail <i class="fa fa-arrow-circle-right"></i></a>

			</div>
       </div>

       

		
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
