<?php 

$titlepage="Master Item";
$idsmenu=1; 

include "../../library/config.php";
include "../model/db.php";
require_once("../model/dbconn.php");
require_once("../model/pos.php");
include "../layout/top-header.php";
include "../../library/check_login.php";
include "../../library/check_access.php";
include "../layout/header.php";






 ?>

            <?php
				$pos = new pos();
				$block = $pos->getblockadd($_SESSION['pos_username']);
				$walletno = $block[1]['wphone'];
				$wallet_address = $block[1]['b_address'];
				
	
	
	$select_location = "SELECT id_loc,loc_name from m_location";
	$select_currency = "SELECT id_currency,currency from m_currency";

	$result_location = mysqli_query($con,$select_location);
	$result_currency = mysqli_query($con,$select_currency);


	$Main_menu="hide"; 
	$set_comm ="hide";
	$set_comm

  // $subjectId  = $_POST['id'];

//if($subjectId == "naira"){
  //  $fn = "show";
//}
	
?>

<?php 
//$var=$_SESSION['id'];
$divid = "";
$divid = $_GET['id'];
$Main_menu="mainmenu"; 
$set_comm ="setcomm";
$reserve_operation = "reserve_operation";
$add_role = "add_role";
$add_offtakerrole = "add_offtakerrole";
$add_order = "add_order";
$test = "";


$Transaction_type = "";
$currency_name = "";
$nairaTransactionFee = "";
$dollarTransactionFee = "";
$mulaTransactionFee = "";

if($divid == "cellulantcontract"){

	$GLOBALS['$Transaction_type'] = "setcomm_redemp";
	$GLOBALS['$Trans_tittle'] = "Set Commission Address,Commission and Receipt Percentage ";	 
	$currency_name = "agloan";
	$currency_symbol= "MC";
	$redem_comm_address = "redem_comm_addressshow";
	}

if($divid == "naira"){

$GLOBALS['$Transaction_type'] = "importtoken";
$GLOBALS['$Trans_tittle'] = "Fund Reserve:N ";	 
$currency_name = "naira";
$currency_symbol= "N";
$res_address_query = "select concat(username,'-',wphone) as wphone2, wphone as wphone1_id2 from `m_user` where username = 'naira@cellulant.com'";
$reserve_cap ="Reserve Transactions.";
$reserve_op_cur = "reserve_op_curshow";
$reserve_op_cur_amount = "reserve_op_cur_amountshow";
$reserve_operation = "reserve_operationshow";
}

if($divid == "dollar"){
	$GLOBALS['$Transaction_type'] = "importtoken";
	$GLOBALS['$Trans_tittle'] = "Fund Reserve:$ ";
	$currency_name = "dollar";
	$currency_symbol= "$";
	$res_address_query = "select concat(username,'-',wphone) as wphone2, wphone as wphone1_id2 from `m_user` where username = 'dollar@cellulant.com'";
	$reserve_cap ="Reserve Transactions.";
	$reserve_op_cur = "reserve_op_curshow";
	$reserve_op_cur_amount = "reserve_op_cur_amountshow";
	$reserve_operation = "reserve_operationshow";
	}

	if($divid == "cashoutnaira"){

		$GLOBALS['$Transaction_type'] = "exporttoken";
		$GLOBALS['$Trans_tittle'] = "Withdraw from Reserve: N ";	 
		$currency_name = "naira";
		$currency_symbol= "N";
		$res_address_query = "select concat(username,'-',wphone) as wphone2, wphone as wphone1_id2 from `m_user` where wphone is not null";
		$reserve_cap ="Reserve Transactions.";
		$reserve_op_cur = "reserve_op_curshow";
		$reserve_op_cur_amount = "reserve_op_cur_amountshow";
		$reserve_operation = "reserve_operationshow";
		}
		
		if($divid == "cashoutdollar"){
			$GLOBALS['$Transaction_type'] = "exporttoken";
			$GLOBALS['$Trans_tittle'] = "Withdraw from Reserve: $ ";
			$currency_name = "dollar";
			$currency_symbol= "$";
			$res_address_query = "select concat(username,'-',wphone) as wphone2, wphone as wphone1_id2 from `m_user` where wphone is not null";
			$reserve_cap ="Report on Agrikore Eco-System Withdrawers.";
			$reserve_op_cur = "reserve_op_curshow";
			$reserve_op_cur_amount = "reserve_op_cur_amountshow";
			$reserve_operation = "reserve_operationshow";
			}

			if($divid == "manualmulaaccount"){
				$GLOBALS['$Transaction_type'] = "addmulaaccount";
				$GLOBALS['$Trans_tittle'] = "Manually add an address as MULA account";
				$currency_name = "";
				$currency_symbol= "M";
				$res_address_query = "select concat(username,'-',wphone) as wphone2, wphone as wphone1_id2 from `m_user` where wphone is not null";
				$reserve_cap ="Report on Account Added as MULA account";
				$reserve_op_cur = "reserve_op_cur";
				$reserve_op_cur_amount = "reserve_op_cur_amount";
				$reserve_operation = "reserve_operationshow";

				}

				if($divid == "manualremovemulaaccount"){
					$GLOBALS['$Transaction_type'] = "removemulaaccount";
					$GLOBALS['$Trans_tittle'] = "Manually remove an address as MULA account";
					$currency_name = "";
					$currency_symbol= "M";
					$res_address_query = "select concat(username,'-',wphone) as wphone2, wphone as wphone1_id2 from `m_user` where wphone is not null";
					$reserve_cap ="Report on Account not removed as MULA account";
					$reserve_op_cur = "reserve_op_cur";
					$reserve_op_cur_amount = "reserve_op_cur_amount";
					$reserve_operation = "reserve_operationshow";
			
					}





					if($divid == "r2pmula"){
						$GLOBALS['$Transaction_type'] = "transferfromreserve";
						$GLOBALS['$Trans_tittle'] = "Transfer Mula from Reserve to (P) account";
						$currency_name = "mula";
						$currency_namex = "mula";
						$currency_symbol= "M";
						$res_address_query = "select concat(username,'-',wphone) as wphone2, wphone as wphone1_id2 from `m_user` where wphone is not null";
						$reserve_cap ="Report on Reserve Transfer to account";
						$reserve_op_cur = "reserve_op_curshow";
						$reserve_op_cur_amount = "reserve_op_cur_amountshow";
						$reserve_operation = "reserve_operationshow";
				       }

						if($divid == "p2rmula"){
							$GLOBALS['$Transaction_type'] = "transfertoreserve";
							$GLOBALS['$Trans_tittle'] = "Transfer Mula from (P) to Reserve account(P2R)";
							$currency_name = "mula";
							$currency_namex = "mula";
							$currency_symbol= "M";
							$res_address_query = "select concat(username,'-',wphone) as wphone2, wphone as wphone1_id2 from `m_user` where wphone is not null";
							$reserve_cap ="Report on Reserve Transfer to account";
							   $reserve_op_cur = "reserve_op_curshow";
								$reserve_op_cur_amount = "reserve_op_cur_amountshow";
								$reserve_operation = "reserve_operationshow";
							}

							if($divid == "commaddrmula"){
								$GLOBALS['$Transaction_type'] = "setcommissionaddress";
								$GLOBALS['$Trans_tittle'] = "Set Account to Receive Commission(Mula)";
								$currency_name = "mula";
								$currency_namex = "mula";
								$currency_symbol= "M";
								$res_address_query = "select concat(username,'-',wphone) as wphone2, wphone as wphone1_id2 from `m_user` where wphone is not null";
								$reserve_cap ="Report on Reserve Transfer to account";
								$reserve_op_cur = "reserve_op_curshow";
								$reserve_op_cur_amount = "reserve_op_cur_amount";
								$reserve_operation = "reserve_operationshow";
								}

								if($divid == "commaddrnaira"){
									$GLOBALS['$Transaction_type'] = "setcommissionaddress";
									$GLOBALS['$Trans_tittle'] = "Set Account to Receive Commission(Naira)";
									$currency_name = "naira";
									$currency_namex = "naira";
									$currency_symbol= "N";
									$res_address_query = "select concat(username,'-',wphone) as wphone2, wphone as wphone1_id2 from `m_user` where wphone is not null";
									$reserve_cap ="Report on Reserve Transfer to account";
									$reserve_op_cur = "reserve_op_curshow";
									$reserve_op_cur_amount = "reserve_op_cur_amount";
									$reserve_operation = "reserve_operationshow";
									}

									if($divid == "commaddrdollar"){
										$GLOBALS['$Transaction_type'] = "setcommissionaddress";
										$GLOBALS['$Trans_tittle'] = "Set Account to Receive Commission(Dollar)";
										$currency_name = "dollar";
										$currency_namex = "dollar";
										$currency_symbol= "$";
										$reserve_cap ="Report on Reserve Transfer to account";
										$reserve_op_cur = "reserve_op_curshow";
										$reserve_op_cur_amount = "reserve_op_cur_amount";
										$reserve_operation = "reserve_operationshow";
										}

										if($divid == "commaddragloan"){
											$GLOBALS['$Transaction_type'] = "setcommissionaddress";
											$GLOBALS['$Trans_tittle'] = "Set Account to Receive Commission(Mula(C)";
											$currency_name = "agloan";
											$currency_namex = "agloan";
											$currency_symbol= "Mula(C)";
											$reserve_cap ="Report on Reserve Transfer to account";
											$reserve_op_cur = "reserve_op_curshow";
											$reserve_op_cur_amount = "reserve_op_cur_amount";
											$reserve_operation = "reserve_operationshow";
											}
		//--------------------Commission Percentage--------------------------------------------

							if($divid == "setcommpermula"){
								$GLOBALS['$Transaction_type'] = "setcommissionpercentage";
								$GLOBALS['$Trans_tittle'] = "Set Commission Percentage(Mula)";
								$currency_name = "mula";
								$currency_namex = "mula";
								$currency_symbol= "M";
								$currency_operation = "currency_operationshow";
								}

								if($divid == "setcommpernaira"){
									$GLOBALS['$Transaction_type'] = "setcommissionpercentage";
									$GLOBALS['$Trans_tittle'] = "Set Commission Percentage(Naira)";
									$currency_name = "naira";
									$currency_namex = "naira";
									$currency_symbol= "N";
									$currency_operation = "currency_operationshow";
									}

									if($divid == "setcommperdollar"){
										$GLOBALS['$Transaction_type'] = "setcommissionpercentage";
										$GLOBALS['$Trans_tittle'] = "Set Commission Percentage(Dollar)";
										$currency_name = "dollar";
										$currency_namex = "dollar";
										$currency_symbol= "$";
										$currency_operation = "currency_operationshow";
										}

										if($divid == "setcommperagloan"){
											$GLOBALS['$Transaction_type'] = "setcommissionpercentage";
											$GLOBALS['$Trans_tittle'] = "Set Commission Percentage(Mula(C)";
											$currency_name = "agloan";
											$currency_namex = "agloan";
											$currency_symbol= "Mula(C)";
											$reserve_cap ="Report on Set Commission Percentage(Mula(C))";
											$reserve_op_cur = "reserve_op_cur";
											$reserve_op_cur_amount = "reserve_op_cur_amountshow";
											$reserve_operation = "reserve_operationshow";
											}

		//-------------------Commission Percentage-------------------------------------------
	
		


	if($divid == "setbuymulanaira"){
		$GLOBALS['$Transaction_type'] = "setbuyprice";
		$GLOBALS['$Trans_tittle'] = "Set Mula Minting Rate(Naira)";
		$currency_name = "naira";
		$currency_symbol= "N";
		$currency_operation = "currency_operationshow";
		}

		if($divid == "mingordertransfer"){
			$GLOBALS['$Transaction_type'] = "setminimumamount";
			$GLOBALS['$Trans_tittle'] = "Set Maximum Contract Value(Guaranteed Order and Receipt)";
			$currency_name = "gorder";
			$currency_symbol= "M(B)";
			$currency_operation = "currency_operationshow";
			}

			if($divid == "maxgordertransfer"){
				$GLOBALS['$Transaction_type'] = "setmaximumamount";
				$GLOBALS['$Trans_tittle'] = "Set Maximum Contract Value(Guaranteed Order and Receipt)";
				$currency_name = "gorder";
				$currency_symbol= "M(B)";
				$currency_operation = "currency_operationshow";
				}

				if($divid == "setbuymulab"){
					$GLOBALS['$Transaction_type'] = "setbuyprice";
					$GLOBALS['$Trans_tittle'] = "Set Mula(B) Minting Rate";
					$currency_name = "gorder";
					$currency_symbol= "M(B)";
					$currency_operation = "currency_operationshow";
					}

					if($divid == "setsellmulab"){
						$GLOBALS['$Transaction_type'] = "setsellprice";
						$GLOBALS['$Trans_tittle'] = "Set Mula(B) Liquidate Rate";
						$currency_name = "gorder";
						$currency_symbol= "M(B)";
						$currency_operation = "currency_operationshow";
						}

//----------------------------------------Muloan---------------------
if($divid == "minmuloantransfer"){
	$GLOBALS['$Transaction_type'] = "setminamount";
	$GLOBALS['$Trans_tittle'] = "Set Minimum Muloan Transfer)";
	$currency_name = "muloan";
	$currency_symbol= "Muloan(M)";
	$currency_operation = "currency_operationshow";
	}

	if($divid == "maxmuloantransfer"){
		$GLOBALS['$Transaction_type'] = "setmaxamount";
		$GLOBALS['$Trans_tittle'] = "Set Maximum Muloan(M)";
		$currency_name = "muloan";
		$currency_symbol= "Muloan(M)";
		$currency_operation = "currency_operationshow";
		}

		if($divid == "setbuymulac"){
			$GLOBALS['$Transaction_type'] = "setbuyprice";
			$GLOBALS['$Trans_tittle'] = "Set Mula(C) Minting Rate";
			$currency_name = "agloan";
			$currency_symbol= "M(C)";
			$currency_operation = "currency_operationshow";
			}

			if($divid == "setsellmulac"){
				$GLOBALS['$Transaction_type'] = "setsellprice";
				$GLOBALS['$Trans_tittle'] = "Set Mula(C) Liquidate Rate";
				$currency_name = "agloan";
				$currency_symbol= "M(C)";
				$currency_operation = "currency_operationshow";
				}


//---------------------------------------Muloan -------------------



						//----------------------------------------Mula C agloan---------------------
						if($divid == "minagloantransfer"){
							$GLOBALS['$Transaction_type'] = "setminamount";
							$GLOBALS['$Trans_tittle'] = "Set Minimum Mula(C) Transfer)";
							$currency_name = "agloan";
							$currency_symbol= "M(C)";
							$currency_operation = "currency_operationshow";
							}
				
							if($divid == "maxagloantransfer"){
								$GLOBALS['$Transaction_type'] = "setmaxamount";
								$GLOBALS['$Trans_tittle'] = "Set Maximum Mula(C)";
								$currency_name = "agloan";
								$currency_symbol= "M(C)";
								$currency_operation = "currency_operationshow";
								}
				
								if($divid == "setbuymulac"){
									$GLOBALS['$Transaction_type'] = "setbuyprice";
									$GLOBALS['$Trans_tittle'] = "Set Mula(C) Minting Rate";
									$currency_name = "agloan";
									$currency_symbol= "M(C)";
									$currency_operation = "currency_operationshow";
									}
				
									if($divid == "setsellmulac"){
										$GLOBALS['$Transaction_type'] = "setsellprice";
										$GLOBALS['$Trans_tittle'] = "Set Mula(C) Liquidate Rate";
										$currency_name = "agloan";
										$currency_symbol= "M(C)";
										$currency_operation = "currency_operationshow";
										}
						

						//---------------------------------------Mula C agloan -------------------
		


		if($divid == "minmulatransfer"){
			$GLOBALS['$Transaction_type'] = "setminimumamount";
			$GLOBALS['$Trans_tittle'] = "Set Minimum Mula Transfer";
			$currency_name = "Mula";
			$currency_symbol= "M";
			$currency_operation = "currency_operationshow";
			}

			if($divid == "maxmulatransfer"){
				$GLOBALS['$Transaction_type'] = "setmaximumamount";
				$GLOBALS['$Trans_tittle'] = "Set Maximum Mula Transfer";
				$currency_name = "Mula";
				$currency_symbol= "M";
				$currency_operation = "currency_operationshow";
				}

				if($divid == "mulatransferfeefx"){
					$GLOBALS['$Transaction_type'] = "settransactionfeefixed";
					$GLOBALS['$Trans_tittle'] = "Set Mula Transfer Fee(Fixed Value)";
					$currency_name = "Mula";
					$currency_symbol= "M";
					$currency_operation = "currency_operationshow";
					}
					if($divid == "mulatransferfeept"){
						$GLOBALS['$Transaction_type'] = "settransactionfeepercent";
						$GLOBALS['$Trans_tittle'] = "Set Mula Transfer Fee(%age Value Moved)";
						$currency_name = "Mula";
						$currency_symbol= "M(%)";
						$currency_operation = "currency_operationshow";
						}	

					if($divid == "automulaaccount"){
						$GLOBALS['$Transaction_type'] = "openmulaselfaddaccount";
						$GLOBALS['$Trans_tittle'] = "Allow account to be automatically enrolled as MULA account";
						$currency_name = "Mula";
						$currency_symbol= "Enter 1";
						$currency_operation = "currency_operationshow";
						}

						if($divid == "disableautomulaaccount"){
							$GLOBALS['$Transaction_type'] = "closemulaselfaddaccount";
							$GLOBALS['$Trans_tittle'] = "Disable Automatically enrolled as MULA account";
							
							$currency_name = "Mula";
							$currency_symbol= "Enter 0 ";
							$currency_operation = "currency_operationshow";
							}

							if($divid == "allowaccountbuymulanaira"){
								$GLOBALS['$Transaction_type'] = "openexternalbuy";
								$GLOBALS['$Trans_tittle'] = "Allow account to buy MULA with Naira";
								$currency_name = "naira";
								$currency_symbol= "Enter 1";
								$currency_operation = "currency_operationshow";
								}
		
								if($divid == "disableaccountbuymulanaira"){
									$GLOBALS['$Transaction_type'] = "closeexternalbuy";
									$GLOBALS['$Trans_tittle'] = "Disallow account to buy MULA with Naira";
									
									$currency_name = "naira";
									$currency_symbol= "Enter 0 ";
									$currency_operation = "currency_operationshow";
									}


									if($divid == "allowaccountbuymuladollar"){
										$GLOBALS['$Transaction_type'] = "openexternalbuy";
										$GLOBALS['$Trans_tittle'] = "Allow account to buy MULA with Dollar";
										$currency_name = "dollar";
										$currency_symbol= "Enter 1";
										$currency_operation = "currency_operationshow";
										}
				
										if($divid == "disableaccountbuymuladollar"){
											$GLOBALS['$Transaction_type'] = "closeexternalbuy";
											$GLOBALS['$Trans_tittle'] = "Disallow account to buy MULA with Dollar";
											
											$currency_name = "dollar";
											$currency_symbol= "Enter 0 ";
											$currency_operation = "currency_operationshow";
											}
				
		

							if($divid == "minnairatransfer"){
								$GLOBALS['$Transaction_type'] = "setminimumamount";
								$GLOBALS['$Trans_tittle'] = "Set Minimum Naira Transfer";
								$currency_name = "Naira";
								$currency_symbol= "N";
								$currency_operation = "currency_operationshow";
								}
					
								if($divid == "maxnairatransfer"){
									$GLOBALS['$Transaction_type'] = "setmaximumamount";
									$GLOBALS['$Trans_tittle'] = "Set Maximum Naira Transfer";
									$currency_name = "Naira";
									$currency_symbol= "N";
									$currency_operation = "currency_operationshow";
									}

									if($divid == "nairatransferfeefx"){
										$GLOBALS['$Transaction_type'] = "settransactionfeefixed";
										$GLOBALS['$Trans_tittle'] = "Set Naira Transfer Fee(Fixed Value)";
										$currency_name = "Naira";
										$currency_symbol= "N";
										$currency_operation = "currency_operationshow";
										}
										if($divid == "nairatransferfeept"){
											$GLOBALS['$Transaction_type'] = "settransactionfeepercent";
											$GLOBALS['$Trans_tittle'] = "Set Naira Transfer Fee(%age Value Moved)";
											$currency_name = "Naira";
											$currency_symbol= "N(%)";
											$currency_operation = "currency_operationshow";
											}	
					
					
									if($divid == "nairatransferfee"){
										$GLOBALS['$Transaction_type'] = "settransactionfee";
										$GLOBALS['$Trans_tittle'] = "Set Naira Transfer Fee";
										$currency_name = "Naira";
										$currency_symbol= "N";
										$currency_operation = "currency_operationshow";
										}

										if($divid == "mindollartransfer"){
											$GLOBALS['$Transaction_type'] = "setminimumamount";
											$GLOBALS['$Trans_tittle'] = "Set Minimum Dollar Transfer";
											$currency_name = "Dollar";
											$currency_symbol= "$";
											$currency_operation = "currency_operationshow";
											}
																
											if($divid == "maxdollartransfer"){
											$GLOBALS['$Transaction_type'] = "setmaximumamount";
											$GLOBALS['$Trans_tittle'] = "Set Maximum Dollar Transfer";
											$currency_name = "Dollar";
											$currency_symbol= "$";
											$currency_operation = "currency_operationshow";
											}
																
											if($divid == "dollartransferfeefx"){
												$GLOBALS['$Transaction_type'] = "settransactionfeefixed";
												$GLOBALS['$Trans_tittle'] = "Set Dollar Transfer Fee(Fixed Value)";
												$currency_name = "Dollar";
												$currency_symbol= "$";
												$currency_operation = "currency_operationshow";
												}
												if($divid == "dollartransferfeept"){
													$GLOBALS['$Transaction_type'] = "settransactionfeepercent";
													$GLOBALS['$Trans_tittle'] = "Set Dollar Transfer Fee(%age Value Moved)";
													$currency_name = "Dollar";
													$currency_symbol= "$(%)";
													$currency_operation = "currency_operationshow";
													}	


																
							
		if($divid == "setbuymuladollar"){
			$GLOBALS['$Transaction_type'] = "setbuyprice";
			$GLOBALS['$Trans_tittle'] = "Set Mula Minting Rate(Dollar)";
			$currency_name = "dollar";
			$currency_symbol= "$";
			$currency_operation = "currency_operationshow";
			}

			if($divid == "setbuymulabgorder"){
				$GLOBALS['$Transaction_type'] = "setbuyprice";
				$GLOBALS['$Trans_tittle'] = "Set Mula(B) Minting Rate(Market Place)";
				$currency_name = "gorder";
				$currency_symbol= "M(B)";
				$currency_operation = "currency_operationshow";
				}

				if($divid == "dealerredeemloan"){
					$GLOBALS['$Transaction_type'] = "redeemloan";
					$GLOBALS['$Trans_tittle'] = "Dealer Redeem Farmers Loan";
					$currency_name = "agloan";
					$currency_namex = "mula";
					$currency_symbol= "MC";
					$res_address_query = "select concat(username,'-',wphone) as wphone2, wphone as wphone1_id2 from `m_user` where wphone in(select msisdnfar from m_farmer where transaction_type = 'adddealer' and tran_status like '%Success%')";
					$reserve_cap ="Report on Dealers Redeem Farmers loan";
					$reserve_op_cur = "reserve_op_curshow";
					$reserve_op_cur_amount = "reserve_op_cur_amountshow";
					$reserve_operation = "reserve_operationshow";
				   }







				if($divid == "setbuymulacagloan"){
					$GLOBALS['$Transaction_type'] = "setbuyprice";
					$GLOBALS['$Trans_tittle'] = "Set Mula Minting Rate(Loan Market Place)";
					$currency_name = "agloan";
					$currency_symbol= "M(C)";
					$currency_operation = "currency_operationshow";
					}

			if($divid == "buymulanaira"){
				$GLOBALS['$Transaction_type'] = "buymulafor";
				$GLOBALS['$Trans_tittle'] = "Minting Mula from (Naira)";
				$reserve_cap ="Report on Minted Mula for Reserve";
				$currency_name = "Naira";
				$res_address_query = "select concat(username,'-',wphone) as wphone2, wphone as wphone1_id2 from `m_user` where username = 'naira@cellulant.com'";
				$currency_symbol= "N";
				$reserve_op_cur = "reserve_op_curshow";
				$reserve_op_cur_amount = "reserve_op_cur_amountshow";
				$reserve_operation = "reserve_operationshow";

				}		
				if($divid == "buymuladollar"){
					$GLOBALS['$Transaction_type'] = "buymulafor";
					$GLOBALS['$Trans_tittle'] = "Minting Mula from (Dollar)";
					$reserve_cap ="Report on Minted Mula for Reserve";
					$currency_name = "Dollar";
					$res_address_query = "select concat(username,'-',wphone) as wphone2, wphone as wphone1_id2 from `m_user` where username = 'dollar@cellulant.com'";
					$currency_symbol= "$";
					$reserve_op_cur = "reserve_op_curshow";
					$reserve_op_cur_amount = "reserve_op_cur_amountshow";
				   $reserve_operation = "reserve_operationshow";
					
				}

				if($divid == "setsellmulanaira"){
					$GLOBALS['$Transaction_type'] = "setsellprice";
					$GLOBALS['$Trans_tittle'] = "Set Liquidate Mula Rate(Naira)";
					$currency_name = "naira";
					$currency_symbol= "N";
					$currency_operation = "currency_operationshow";
					}
			
					if($divid == "setsellmuladollar"){
						$GLOBALS['$Transaction_type'] = "setsellprice";
						$GLOBALS['$Trans_tittle'] = "Set Liquidate Mula Rate(Dollar)";
						$currency_name = "dollar";
						$currency_symbol= "$";
						$currency_operation = "currency_operationshow";
						}

						if($divid == "setsellmulabgorder"){
							$GLOBALS['$Transaction_type'] = "setsellprice";
							$GLOBALS['$Trans_tittle'] = "Set Liquidate Mula(B) Rate(Market Lace)";
							$currency_name = "gorder";
							$currency_symbol= "M(B)";
							$currency_operation = "currency_operationshow";
							}
					
							if($divid == "setsellmulacagloan"){
								$GLOBALS['$Transaction_type'] = "setsellprice";
								$GLOBALS['$Trans_tittle'] = "Set Liquidate Mula(C) Rate(Market Place Loan)";
								$currency_name = "agloan";
								$currency_symbol= "M(C)";
								$currency_operation = "currency_operationshow";
								}

					if($divid == "sellmulanaira"){
						$GLOBALS['$Transaction_type'] = "sellmulafor";
						$GLOBALS['$Trans_tittle'] = "Liquidating Mula to (Naira)";
						$reserve_cap ="Report on Liquidate Mula from Reserve";
						$currency_name = "Naira";
						$currency_symbol= "N";
						$res_address_query = "select concat(username,'-',wphone) as wphone2, wphone as wphone1_id2 from `m_user` where username not in('naira@cellulant.com','mula@cellulant.com','dollar@cellulant.com')";
						$reserve_op_cur = "reserve_op_curshow";
						$reserve_op_cur_amount = "reserve_op_cur_amountshow";
				        $reserve_operation = "reserve_operationshow";
						
						}		
						if($divid == "sellmuladollar"){
							$GLOBALS['$Transaction_type'] = "sellmulafor";
							$GLOBALS['$Trans_tittle'] = "Liquidating Mula to (Dollar)";
							$reserve_cap ="Report on Liquidate Mula from Reserve";
							$currency_name = "Dollar";
							$currency_symbol= "$";
							$reserve_op_cur = "reserve_op_curshow";
							$reserve_op_cur_amount = "reserve_op_cur_amountshow";
				            $reserve_operation = "reserve_operationshow";
							}	
						

							if($divid == "adddealerexpitem"){

								$GLOBALS['$Transaction_type'] = "adddealerexpitem";
								$GLOBALS['$Trans_tittle'] = "Dealers Expenses";	 
								$role = "Loaner";
								$currency_name = "Add Expense to Dealer";
								$currency_symbol= "N";
								$sqlfarloc = "select exp_name as far_loc,exp_index as loc_index from `m_expenses` where transaction_id like '%Success%'";
								$add_role = "add_roleshow";
								$add_loc_title = "Expenses";
								$add_role_block = "add_roles_blockshow";
								$add_farmerrole = "add_farmerroleshow";
								$sqlfarquery = "select concat(username,'-',wphone) as wphonefar, wphone as wphonefar_id from `m_user` 
								where username not like 'naira@cellulant.com%'
								and username not like 'dollar@cellulant.com%'
								and username not like 'mula@cellulant.com%'
								and username not like 'cellulant@cellulant.com%'
								and wphone in (SELECT msisdnfar FROM m_farmer where tran_status like '%Success%'
								and transaction_type ='adddealer')";
								}


								if($divid == "operatorrole"){

									$GLOBALS['$Transaction_type'] = "addoperator";
									$GLOBALS['$Trans_tittle'] = "Agrikore Operator";	 
									$role = "Add Operator";
									$currency_name = "Add Operator";
									$currency_symbol= "N";
									$add_offtakerrole = "add_offtakerroleshow";
									$offtaker_receipt = "offtaker_receipt";
									$add_role_block = "add_roles_block";
									$add_role_block2 = "add_roles_blockshow";
									
									}

							if($divid == "loanerrole"){

								$GLOBALS['$Transaction_type'] = "addloaner";
								$GLOBALS['$Trans_tittle'] = "Agriculture Loaner Role";	 
								$role = "Loaner";
								$currency_name = "Add Loaner";
								$currency_symbol= "N";
								$sqlfarloc = "select loc_name as far_loc,loc_index from `m_location` where transaction_id like '%Success%'";
								$add_role = "add_roleshow";
								$add_loc_title = "Loaction";
								$add_role_block = "add_roles_blockshow";
								$add_farmerrole = "add_farmerroleshow";
								$sqlfarquery = "select concat(username,'-',wphone) as wphonefar, wphone as wphonefar_id from `m_user` 
								where username not like 'naira@cellulant.com%'
								and username not like 'dollar@cellulant.com%'
								and username not like 'mula@cellulant.com%'
								and username not like 'cellulant@cellulant.com%'
								and wphone not in (SELECT msisdnfar FROM m_farmer where tran_status like '%Success%'
								UNION
								SELECT msisdncer FROM m_certifier where tran_status like '%Success%'
								UNION
								SELECT msisdnoff FROM m_offtaker where tran_status like '%Success%')";
								}

                                if($divid == "agloan"){
										$GLOBALS['$Transaction_type'] = "addagloan";
										$GLOBALS['$Trans_tittle'] = "Agriculture Loan Contract ";
										
										$currency_name = "Activate a Item Specific Loaner Contract";
										$currency_symbol= "M";
										$role = "Activate/Issue Loan";
										$add_agloan = "add_loanershow";
										$exp_item = "add_expitemshow";
										
										$addloansql =	"select concat(username,'-',wphone) as lonwphoneagloan, wphone as lonwphoneagloan_id 
										from m_user u,m_farmer f 
										where u.wphone = f.msisdnfar 
										and f.transaction_type = 'addloaner' 
										and f.tran_status like '%Success%' 
										and u.username not in('cellulant@cellulant.com','cellulant@cellulant.com.ng','naira@cellulant.com','naira@cellulant.com.ng','mula@cellulant.com','mula@cellulant.com.ng','dollar@cellulant.com','dollar@cellulant.com.ng');";

										}

										if($divid == "muloan"){
											$GLOBALS['$Transaction_type'] = "addmuloan";
											$GLOBALS['$Trans_tittle'] = "Mula Loan Contract ";
											
											$currency_name = "Activate a General Loaner Contract";
											$currency_symbol= "M";
											$role = "Activate/Issue Loan";
											$add_agloan = "add_loanershow";
											$exp_item = "add_expitem";
											
											$addloansql =	"select concat(username,'-',wphone) as lonwphoneagloan, wphone as lonwphoneagloan_id 
											from m_user u,m_farmer f 
											where u.wphone = f.msisdnfar 
											and f.transaction_type = 'addloaner' 
											and f.tran_status like '%Success%' 
											and u.username not in('cellulant@cellulant.com','cellulant@cellulant.com.ng','naira@cellulant.com','naira@cellulant.com.ng','mula@cellulant.com','mula@cellulant.com.ng','dollar@cellulant.com','dollar@cellulant.com.ng');";
	
											}
	


                                      	//----------------------------------------Mula C agloan---------------------
						if($divid == "minagloantransfer"){
							$GLOBALS['$Transaction_type'] = "setminamount";
							$GLOBALS['$Trans_tittle'] = "Set Minimum Mula(C) Transfer)";
							$currency_name = "agloan";
							$currency_symbol= "M(C)";
							$currency_operation = "currency_operationshow";
							}
				
							if($divid == "maxagloantransfer"){
								$GLOBALS['$Transaction_type'] = "setmaxamount";
								$GLOBALS['$Trans_tittle'] = "Set Maximum Mula(C)";
								$currency_name = "agloan";
								$currency_symbol= "M(C)";
								$currency_operation = "currency_operationshow";
								}

                                                 if($divid == "confirmdelivery"){

													$GLOBALS['$Transaction_type'] = "confirmdelivery";
													$GLOBALS['$Trans_tittle'] = "Buyer Confirmation of Produce Delivery";	 
													$role = "Confirm Delivery";
													$processed_own = "Buyer ";
													$currency_name = "Confirm Produce Delivery";
													$currency_symbol= "N";
													$cersqlcre_cer = "SELECT DISTINCT concat(concat(username,'-'),wphone) as cerwphonecre, wphone as cerwphonecre_id from m_user where wphone in (Select msisdncre from m_p_receipt_cer where tran_type = 'certify' and (outcre like '%Success%' or outcre like '%receiptpay-204%')) ";
													$addcertifyproduce = "addcertifyproduceshow";
													}
 							









							if($divid == "buyerrole"){

								$GLOBALS['$Transaction_type'] = "addbuyer";
								$GLOBALS['$Trans_tittle'] = "Corporate Buyer Role";	 
								$role = "Buyer";
								$currency_name = "Add Buyer";
								$currency_symbol= "N";
								$sqlfarloc = "select loc_name as far_loc,loc_index from `m_location` where transaction_id like '%Success%'";
								$add_role = "add_roleshow";
								$add_loc_title = "Loaction";
								$add_role_block = "add_roles_blockshow";
								$add_farmerrole = "add_farmerroleshow";
								$sqlfarquery = "select concat(username,'-',wphone) as wphonefar, wphone as wphonefar_id from `m_user` 
								where username not like 'naira@cellulant.com%'
								and username not like 'dollar@cellulant.com%'
								and username not like 'mula@cellulant.com%'
								and username not like 'cellulant@cellulant.com%'
								and wphone not in (SELECT msisdnfar FROM m_farmer where tran_status like '%Success%'
								UNION
								SELECT msisdncer FROM m_certifier where tran_status like '%Success%'
								UNION
								SELECT msisdnoff FROM m_offtaker where tran_status like '%Success%')";
								}
								
								if($divid == "gorder"){
									$GLOBALS['$Transaction_type'] = "gorder";
									$GLOBALS['$Trans_tittle'] = "Corporate Buyer Contract ";
									
									$currency_name = "Add a Buyer Contract";
									$currency_symbol= "$";
									$add_order = "add_ordershow";
									}
								
									if($divid == "offtakerrole"){

										$GLOBALS['$Transaction_type'] = "addofftaker1";
										$GLOBALS['$Trans_tittle'] = "Commodity aggregation site operators (PASO) Contracts";	 
										$role = "Add Offtaker";
										$currency_name = "Add Offtaker";
										$currency_symbol= "N";
										$add_offtakerrole = "add_offtakerroleshow";
										$offtaker_receipt = "offtaker_receiptshow";
										$add_role_block = "add_roles_block";
										$add_role_block2 = "add_roles_blockshow";
										
										}

										if($divid == "logisticsrole"){

											$GLOBALS['$Transaction_type'] = "addlogistics";
											$GLOBALS['$Trans_tittle'] = "Logistics Operators  Contracts";	 
											$role = "Add Logistics";
											$currency_name = "Add Logistics";
											$currency_symbol= "N";
											$add_offtakerrole = "add_offtakerroleshow";
											$offtaker_receipt = "offtaker_receiptblock";
											$add_role_block = "add_roles_block";
											$add_role_block2 = "add_roles_blockshow";
											
											}

											if($divid == "insurerrole"){

												$GLOBALS['$Transaction_type'] = "addinsurer";
												$GLOBALS['$Trans_tittle'] = "Insurance Service Contracts";	 
												$role = "Add Insurance Service";
												$currency_name = "Add Insurance Service";
												$currency_symbol= "N";
												$add_offtakerrole = "add_offtakerroleshow";
												$offtaker_receipt = "offtaker_receiptblock";
												$add_role_block = "add_roles_block";
												$add_role_block2 = "add_roles_blockshow";
												
												}
		
	

										if($divid == "genericrole"){

											$GLOBALS['$Transaction_type'] = "addgenericrole";
											$GLOBALS['$Trans_tittle'] = "Agrikore Generic Role Contracts";	 
											$role = "Add Generic Role";
											$currency_name = "Generic Role";
											$currency_symbol= "N";
											$add_offtakerrole = "add_offtakerroleshow";
											$add_role_block = "add_roles_blockshow";
											$add_role_block2 = "add_roles_block";
											$generic = "generic";
											}

											if($divid == "approveln"){

												$GLOBALS['$Transaction_type'] = "approveloan";
												$GLOBALS['$Trans_tittle'] = "Sign/Approve Loaner";	 
												$role = "Loaner";
												$role2 = "Loaner MSISDN";
												$role3 = "Loan Address";
												$sqlgotquery = "select concat(username,'-',wphone) as wphonegot, wphone as wphonegot_id from `m_user` 
												where wphone in (select lonmsisdn from m_agloan where tran_script like '%farmer-100-Success,loaner-100-Success%')";
												$currency_name = "Approve (Loaner Contract) ";
												$currency_symbol= "N";
												$guaranteedorderauxillary = "addofftakergoshow";

												$offsqlgotquery = "select concat(username,'-',wphone) as offwphonegot, wphone as offwphonegot_id 
												from `m_user` 
												where wphone in(select msisdnoff from m_offtaker where  tran_status like '%Success%')" ;
												}

												if($divid == "revokeln"){

													$GLOBALS['$Transaction_type'] = "revokeloan";
													$GLOBALS['$Trans_tittle'] = "UnSign/Revoke Loan";	 
													$role = "Loaner";
													$role2 = "Loaner MSISDN";
													$role3 = "Loan Address";
													$sqlgotquery = "select concat(username,'-',wphone) as wphonegot, wphone as wphonegot_id from `m_user` 
													where wphone in (select lonmsisdn from m_agloan where tran_script like '%farmer-100-Success,loaner-100-Success%')";
													$currency_name = "Revoke (Loan) ";
													$currency_symbol= "N";
													$guaranteedorderauxillary = "addofftakergoshow";
													$offsqlgotquery = "select concat(username,'-',wphone) as offwphonegot, wphone as offwphonegot_id 
												from `m_user` 
												where wphone in(select msisdnoff from m_offtaker where  tran_status like '%Success%')" ;
											
													}

													if($divid == "expireln"){

														$GLOBALS['$Transaction_type'] = "expireloan";
														$GLOBALS['$Trans_tittle'] = "Expire Loan";	 
														$role = "Loaner";
														$role2 = "Loaner MSISDN";
														$role3 = "Loan Address";
														$sqlgotquery = "select concat(username,'-',wphone) as wphonegot, wphone as wphonegot_id from `m_user` 
														where wphone in (select lonmsisdn from m_agloan where tran_script like '%farmer-100-Success,loaner-100-Success%')";
														$currency_name = "Expire (Loan) ";
														$currency_symbol= "N";
														$guaranteedorderauxillary = "addofftakergoshow";
														$offsqlgotquery = "select concat(username,'-',wphone) as offwphonegot, wphone as offwphonegot_id 
												from `m_user` 
												where wphone in(select msisdnoff from m_offtaker where  tran_status like '%Success%')" ;
											
														}

														if($divid == "addloandisburseln"){

															$GLOBALS['$Transaction_type'] = "addloandisburse";
															$GLOBALS['$Trans_tittle'] = "Add Disburse Loan";	 
															$role = "Loaner";
															$role2 = "Loaner MSISDN";
															$role3 = "Loan Address";
															$sqlgotquery = "select concat(username,'-',wphone) as wphonegot, wphone as wphonegot_id from `m_user` 
															where wphone in (select lonmsisdn from m_agloan where tran_script like '%farmer-100-Success,loaner-100-Success%')";
															$currency_name = "Disburse a (Loan) ";
															$currency_symbol= "N";
															$guaranteedorderauxillary = "addofftakergoshow";
															$offsqlgotquery = "select concat(username,'-',wphone) as offwphonegot, wphone as offwphonegot_id 
												from `m_user` 
												where wphone in(select msisdnoff from m_offtaker where  tran_status like '%Success%')" ;
											
															}

															if($divid == "unsuspendln"){

																$GLOBALS['$Transaction_type'] = "unsuspendloan";
																$GLOBALS['$Trans_tittle'] = "UnSuspend Loan";	 
																$role = "Loaner";
																$role2 = "Loaner MSISDN";
																$role3 = "Loan Address";
																$sqlgotquery = "select concat(username,'-',wphone) as wphonegot, wphone as wphonegot_id from `m_user` 
																where wphone in (select lonmsisdn from m_agloan where tran_script like '%farmer-100-Success,loaner-100-Success%')";
																$currency_name = "UnSuspend (Loan) ";
																$currency_symbol= "N";
																$guaranteedorderauxillary = "addofftakergoshow";
																$offsqlgotquery = "select concat(username,'-',wphone) as offwphonegot, wphone as offwphonegot_id 
												from `m_user` 
												where wphone in(select msisdnoff from m_offtaker where  tran_status like '%Success%')" ;
											
																}

																if($divid == "suspendln"){

																	$GLOBALS['$Transaction_type'] = "suspendloan";
																	$GLOBALS['$Trans_tittle'] = "Suspend Loan";	 
																	$role = "Loaner";
																	$role2 = "Loaner MSISDN";
																	$role3 = "Loan Address";
																	$sqlgotquery = "select concat(username,'-',wphone) as wphonegot, wphone as wphonegot_id from `m_user` 
																	where wphone in (select lonmsisdn from m_agloan where tran_script like '%farmer-100-Success,loaner-100-Success%')";
																	$currency_name = "Suspend (Loan) ";
																	$currency_symbol= "N";
																	$guaranteedorderauxillary = "addofftakergoshow";
																	$offsqlgotquery = "select concat(username,'-',wphone) as offwphonegot, wphone as offwphonegot_id 
																	from `m_user` 
																	where wphone in(select msisdnoff from m_offtaker where  tran_status like '%Success%')" ;
																
																	}

																	if($divid == "payloanln"){

																		$GLOBALS['$Transaction_type'] = "payloan";
																		$GLOBALS['$Trans_tittle'] = "Farmer Pay Loan";	 
																		$role = "Farmer";
																		$role2 = "Farmer MSISDN";
																		$role3 = "Loan Address";
																		$sqlgotquery = "select concat(username,'-',wphone) as wphonegot, wphone as wphonegot_id from `m_user` 
																		where wphone in (select benemsisdn from m_agloan where tran_script like '%farmer-100-Success,loaner-100-Success%')";
																		$currency_name = "Farmer Pay (Loan) ";
																		$currency_symbol= "M";
																		$guaranteedorderauxillary = "addofftakergoshow";
																		$offsqlgotquery = "select concat(username,'-',wphone) as offwphonegot, wphone as offwphonegot_id 
																		from `m_user` 
																		where wphone in(select msisdnfar from m_farmer where  tran_status like '%Success%' and transaction_type = 'addfarmer')" ;
																	
																		}


																		if($divid == "spendloanln"){

																			$GLOBALS['$Transaction_type'] = "spendloan";
																			$GLOBALS['$Trans_tittle'] = "Farmer Spend Loan";	 
																			$role = "Farmer";
																			$role2 = "Farmer MSISDN";
																			$role3 = "Farmer Loan Address";
																			$sqlgotquery = "select concat(username,'-',wphone) as wphonegot, wphone as wphonegot_id from `m_user` 
																			where wphone in (select benemsisdn from m_agloan where tran_script like '%farmer-100-Success,loaner-100-Success%')";
																			$currency_name = "Farmer Spend (Loan) ";
																			$currency_symbol= "M";
																			$guaranteedorderauxillary = "addofftakergoshow";
																			$offsqlgotquery = "select concat(username,'-',wphone) as offwphonegot, wphone as offwphonegot_id 
																			from `m_user` 
																			where wphone in(select msisdnfar from m_farmer 
																						  where tran_status like '%Success%'
																						  and transaction_type = 'adddealer')";
																		
																			}
	


																			if($divid == "approvemuln"){

																				$GLOBALS['$Transaction_type'] = "approveloanmula";
																				$GLOBALS['$Trans_tittle'] = "Sign/Approve Mula Loan";	 
																				$role = "Loaner";
																				$role2 = "Loaner MSISDN";
																				$role3 = "Loan Address";
																				$sqlgotquery = "select concat(username,'-',wphone) as wphonegot, wphone as wphonegot_id from `m_user` 
																				where wphone in (select lonmsisdn from m_agloan where tran_script like '%farmer-100-Success,loaner-100-Success%')";
																				$currency_name = "Approve (Mula Loan Contract) ";
																				$currency_symbol= "N";
																				$guaranteedorderauxillary = "addofftakergoshow";
								
																				$offsqlgotquery = "select concat(username,'-',wphone) as offwphonegot, wphone as offwphonegot_id 
																				from `m_user` 
																				where wphone in(select msisdnoff from m_offtaker where  tran_status like '%Success%')" ;
																				}
								
																				if($divid == "revokemuln"){
								
																					$GLOBALS['$Transaction_type'] = "revokeloanmula";
																					$GLOBALS['$Trans_tittle'] = "UnSign/Revoke Mula Loan";	 
																					$role = "Loaner";
																					$role2 = "Loaner MSISDN";
																					$role3 = "Loan Address";
																					$sqlgotquery = "select concat(username,'-',wphone) as wphonegot, wphone as wphonegot_id from `m_user` 
																					where wphone in (select lonmsisdn from m_agloan where tran_script like '%farmer-100-Success,loaner-100-Success%')";
																					$currency_name = "Revoke (Loan) ";
																					$currency_symbol= "N";
																					$guaranteedorderauxillary = "addofftakergoshow";
																					$offsqlgotquery = "select concat(username,'-',wphone) as offwphonegot, wphone as offwphonegot_id 
																				from `m_user` 
																				where wphone in(select msisdnoff from m_offtaker where  tran_status like '%Success%')" ;
																			
																					}
								
																					if($divid == "expiremuln"){
								
																						$GLOBALS['$Transaction_type'] = "expireloanmula";
																						$GLOBALS['$Trans_tittle'] = "Expire Mula Loan";	 
																						$role = "Loaner";
																						$role2 = "Loaner MSISDN";
																						$role3 = "Loan Address";
																						$sqlgotquery = "select concat(username,'-',wphone) as wphonegot, wphone as wphonegot_id from `m_user` 
																						where wphone in (select lonmsisdn from m_agloan where tran_script like '%farmer-100-Success,loaner-100-Success%')";
																						$currency_name = "Expire (Loan) ";
																						$currency_symbol= "N";
																						$guaranteedorderauxillary = "addofftakergoshow";
																						$offsqlgotquery = "select concat(username,'-',wphone) as offwphonegot, wphone as offwphonegot_id 
																				from `m_user` 
																				where wphone in(select msisdnoff from m_offtaker where  tran_status like '%Success%')" ;
																			
																						}
								
																						if($divid == "addloandisbursemuln"){
								
																					$GLOBALS['$Transaction_type'] = "addloandisbursemula";
																							$GLOBALS['$Trans_tittle'] = "Add Disburse Mula Loan";	 
																							$role = "Loaner";
																							$role2 = "Loaner MSISDN";
																							$role3 = "Loan Address";
																							$sqlgotquery = "select concat(username,'-',wphone) as wphonegot, wphone as wphonegot_id from `m_user` 
																							where wphone in (select lonmsisdn from m_agloan where tran_script like '%farmer-100-Success,loaner-100-Success%')";
																							$currency_name = "Disburse a (Mula Loan) ";
																							$currency_symbol= "N";
																							$guaranteedorderauxillary = "addofftakergoshow";
																							$offsqlgotquery = "select concat(username,'-',wphone) as offwphonegot, wphone as offwphonegot_id 
																				from `m_user` 
																				where wphone in(select msisdnoff from m_offtaker where  tran_status like '%Success%')" ;
																			
																							}
								
																							if($divid == "unsuspendmuln"){
								
																								$GLOBALS['$Transaction_type'] = "unsuspendloanmula";
																								$GLOBALS['$Trans_tittle'] = "UnSuspend Mula Loan";	 
																								$role = "Loaner";
																								$role2 = "Loaner MSISDN";
																								$role3 = "Loan Address";
																								$sqlgotquery = "select concat(username,'-',wphone) as wphonegot, wphone as wphonegot_id from `m_user` 
																								where wphone in (select lonmsisdn from m_agloan where tran_script like '%farmer-100-Success,loaner-100-Success%')";
																								$currency_name = "UnSuspend (Loan) ";
																								$currency_symbol= "N";
																								$guaranteedorderauxillary = "addofftakergoshow";
																								$offsqlgotquery = "select concat(username,'-',wphone) as offwphonegot, wphone as offwphonegot_id 
																				from `m_user` 
																				where wphone in(select msisdnoff from m_offtaker where  tran_status like '%Success%')" ;
																			
																								}
								
																								if($divid == "suspendmuln"){
								
																									$GLOBALS['$Transaction_type'] = "suspendloanmula";
																									$GLOBALS['$Trans_tittle'] = "Suspend Mula Loan";	 
																									$role = "Loaner";
																									$role2 = "Loaner MSISDN";
																									$role3 = "Loan Address";
																									$sqlgotquery = "select concat(username,'-',wphone) as wphonegot, wphone as wphonegot_id from `m_user` 
																									where wphone in (select lonmsisdn from m_agloan where tran_script like '%farmer-100-Success,loaner-100-Success%')";
																									$currency_name = "Suspend (Loan) ";
																									$currency_symbol= "N";
																									$guaranteedorderauxillary = "addofftakergoshow";
																									$offsqlgotquery = "select concat(username,'-',wphone) as offwphonegot, wphone as offwphonegot_id 
																									from `m_user` 
																									where wphone in(select msisdnoff from m_offtaker where  tran_status like '%Success%')" ;
																								
																									}
								
																									if($divid == "payloanmuln"){
								
																										$GLOBALS['$Transaction_type'] = "payloanmula";
																										$GLOBALS['$Trans_tittle'] = "Recepient Pay Loan";	 
																										$role = "Recipient";
																										$role2 = "Recipient MSISDN";
																										$role3 = "Loan Address";
																										$sqlgotquery = "select concat(username,'-',wphone) as wphonegot, wphone as wphonegot_id from `m_user` 
																										where wphone in (select benemsisdn from m_agloan where tran_script like '%farmer-100-Success,loaner-100-Success%')";
																										$currency_name = "Farmer Pay (Loan) ";
																										$currency_symbol= "M";
																										$guaranteedorderauxillary = "addofftakergoshow";
																										$offsqlgotquery = "select concat(username,'-',wphone) as offwphonegot, wphone as offwphonegot_id 
																										from `m_user` 
																										where wphone in(select msisdnfar from m_farmer where  tran_status like '%Success%' and transaction_type = 'addfarmer')" ;
																									
																										}
								
								
																										if($divid == "spendloanmuln"){
								
																											$GLOBALS['$Transaction_type'] = "spendloanmula";
																											$GLOBALS['$Trans_tittle'] = "Farmer Spend Loan";	 
																											$role = "Farmer";
																											$role2 = "Farmer MSISDN";
																											$role3 = "Farmer Loan Address";
																											$sqlgotquery = "select concat(username,'-',wphone) as wphonegot, wphone as wphonegot_id from `m_user` 
																											where wphone in (select benemsisdn from m_agloan where tran_script like '%farmer-100-Success,loaner-100-Success%')";
																											$currency_name = "Farmer Spend (Loan) ";
																											$currency_symbol= "M";
																											$guaranteedorderauxillary = "addofftakergoshow";
																											$offsqlgotquery = "select concat(username,'-',wphone) as offwphonegot, wphone as offwphonegot_id 
																											from `m_user` 
																											where wphone in(select msisdnfar from m_farmer 
																														  where tran_status like '%Success%'
																														  and transaction_type = 'adddealer')";
																										
																											}
									
								
								
								









											if($divid == "approvego"){

												$GLOBALS['$Transaction_type'] = "approve";
												$GLOBALS['$Trans_tittle'] = "Sign/Approve Guaranteed Order";	 
												$role = "CCB/Buyer";
												$role2 = "CCB/Buyer MSISDN";
												$role3 = "CCB/Buyer Order Address";
												$sqlgotquery = "select concat(username,'-',wphone) as wphonegot, wphone as wphonegot_id from `m_user` 
												where wphone in (select msisdnreq from m_request where gorderaccounting_status like '%buyer-100-Success%')";
												$currency_name = "Approve (Guaranteed Order) ";
												$currency_symbol= "N";
												$guaranteedorderauxillary = "addofftakergoshow";
												$offsqlgotquery = "select concat(username,'-',wphone) as offwphonegot, wphone as offwphonegot_id 
												from `m_user` 
												where wphone in(select msisdnoff from m_offtaker where  tran_status like '%Success%')" ;
											
												}

												if($divid == "revokego"){

													$GLOBALS['$Transaction_type'] = "revoke";
													$GLOBALS['$Trans_tittle'] = "UnSign/Revoke Guaranteed Order";	 
													$role = "CCB/Buyer";
													$role2 = "CCB/Buyer MSISDN";
													$role3 = "CCB/Buyer Order Address";
													$sqlgotquery = "select concat(username,'-',wphone) as wphonegot, wphone as wphonegot_id from `m_user` 
											    	where wphone in (select msisdnreq from m_request where gorderaccounting_status like '%buyer-100-Success%')";
													$currency_name = "Revoke (Guaranteed Order) ";
													$currency_symbol= "N";
													$guaranteedorderauxillary = "addofftakergoshow";
													$offsqlgotquery = "select concat(username,'-',wphone) as offwphonegot, wphone as offwphonegot_id 
												from `m_user` 
												where wphone in(select msisdnoff from m_offtaker where  tran_status like '%Success%')" ;
											
													}

													if($divid == "expirego"){

														$GLOBALS['$Transaction_type'] = "expire";
														$GLOBALS['$Trans_tittle'] = "Expire Guaranteed Order";	 
														$role = "CCB/Buyer";
														$role2 = "CCB/Buyer MSISDN";
														$role3 = "CCB/Buyer Order Address";
														$sqlgotquery = "select concat(username,'-',wphone) as wphonegot, wphone as wphonegot_id from `m_user` 
												        where wphone in (select msisdnreq from m_request where gorderaccounting_status like '%buyer-100-Success%')";
														$currency_name = "Expire (Guaranteed Order) ";
														$currency_symbol= "N";
														$guaranteedorderauxillary = "addofftakergoshow";
														$offsqlgotquery = "select concat(username,'-',wphone) as offwphonegot, wphone as offwphonegot_id 
												from `m_user` 
												where wphone in(select msisdnoff from m_offtaker where  tran_status like '%Success%')" ;
											
														}

														if($divid == "expirenrfgo"){

															$GLOBALS['$Transaction_type'] = "expireandrefund";
															$GLOBALS['$Trans_tittle'] = "Expire and Refund Guaranteed Order";	 
															$role = "CCB/Buyer";
															$role2 = "CCB/Buyer MSISDN";
															$role3 = "CCB/Buyer Order Address";
															$sqlgotquery = "select concat(username,'-',wphone) as wphonegot, wphone as wphonegot_id from `m_user` 
												            where wphone in (select msisdnreq from m_request where gorderaccounting_status like '%buyer-100-Success%')";
															$currency_name = "Expire and Refund (Guaranteed Order) ";
															$currency_symbol= "N";
															$guaranteedorderauxillary = "addofftakergoshow";
															$offsqlgotquery = "select concat(username,'-',wphone) as offwphonegot, wphone as offwphonegot_id 
												from `m_user` 
												where wphone in(select msisdnoff from m_offtaker where  tran_status like '%Success%')" ;
											
															}

															if($divid == "unsuspendgo"){

																$GLOBALS['$Transaction_type'] = "unsuspend";
																$GLOBALS['$Trans_tittle'] = "UnSuspend Guaranteed Order";	 
																$role = "CCB/Buyer";
																$role2 = "CCB/Buyer MSISDN";
																$role3 = "CCB/Buyer Order Address";
																$sqlgotquery = "select concat(username,'-',wphone) as wphonegot, wphone as wphonegot_id from `m_user` 
											                 	where wphone in (select msisdnreq from m_request where gorderaccounting_status like '%buyer-100-Success%')";
																$currency_name = "UnSuspend (Guaranteed Order) ";
																$currency_symbol= "N";
																$guaranteedorderauxillary = "addofftakergoshow";
																$offsqlgotquery = "select concat(username,'-',wphone) as offwphonegot, wphone as offwphonegot_id 
												from `m_user` 
												where wphone in(select msisdnoff from m_offtaker where  tran_status like '%Success%')" ;
											
																}

																if($divid == "suspendgo"){

																	$GLOBALS['$Transaction_type'] = "suspend";
																	$GLOBALS['$Trans_tittle'] = "Suspend Guaranteed Order";	 
																	$role = "CCB/Buyer";
																	$role2 = "CCB/Buyer MSISDN";
																	$role3 = "CCB/Buyer Order Address";
																	$sqlgotquery = "select concat(username,'-',wphone) as wphonegot, wphone as wphonegot_id from `m_user` 
											                    	where wphone in (select msisdnreq from m_request where gorderaccounting_status like '%buyer-100-Success%')";
																	$currency_name = "Suspend (Guaranteed Order) ";
																	$currency_symbol= "N";
																	$guaranteedorderauxillary = "addofftakergoshow";
																	$offsqlgotquery = "select concat(username,'-',wphone) as offwphonegot, wphone as offwphonegot_id 
												from `m_user` 
												where wphone in(select msisdnoff from m_offtaker where  tran_status like '%Success%')" ;
											
																	}

																	if($divid == "addfundgo"){

																		$GLOBALS['$Transaction_type'] = "addfunds";
																		$GLOBALS['$Trans_tittle'] = "Add Fund/Re-Finance Guaranteed Order";	 
																		$role = "CCB/Buyer";
																		$role2 = "CCB/Buyer MSISDN";
																		$role3 = "CCB/Buyer Order Address";
																		$sqlgotquery = "select concat(username,'-',wphone) as wphonegot, wphone as wphonegot_id from `m_user` 
												                        where wphone in (select msisdnreq from m_request where gorderaccounting_status like '%buyer-100-Success%')";
																		$currency_name = "Add Fund/Re-Finance (Guaranteed Order) ";
																		$currency_symbol= "M";
																		$guaranteedorderauxillary = "addofftakergoshow";
																		$offsqlgotquery = "select concat(username,'-',wphone) as offwphonegot, wphone as offwphonegot_id 
												from `m_user` 
												where wphone in(select msisdnoff from m_offtaker where  tran_status like '%Success%')" ;
											
																		}
				
			
																		if($divid == "addgenericgo"){

																			$GLOBALS['$Transaction_type'] = "addgenericrole1";
																			$GLOBALS['$Trans_tittle'] = "Acctivate Generic Contract(Guaranteed Order)";	 
																			$role = "Generic";
																			$role2 = "Generic MSISDN";
																			$role3 = "CCB/Buyer Order Address";
																			$sqlgotquery = "select concat(username,'-',wphone) as wphonegot, wphone as wphonegot_id from `m_user` 
												                            where wphone in (select msisdnreq from m_request where gorderaccounting_status like '%buyer-100-Success%')";
																			$currency_name = "Add Generic(Guaranteed Order) ";
																			$currency_symbol= "N";
																			
																			$guaranteedorderauxillary = "addofftakergoshow";
																			$offsqlgotquery = "select concat(username,'-',wphone) as offwphonegot, wphone as offwphonegot_id 
																			from `m_user` 
																			where wphone in(select msisdnoff from m_offtaker where  tran_status like '%Success%')" ;
											
																			}
								
								
								
																			if($divid == "removegenericgo"){
								
																				$GLOBALS['$Transaction_type'] = "removegenericrole";
																				$GLOBALS['$Trans_tittle'] = "De-activate Generic Contract(Guaranteed Order)";	 
																				$role = "Remove Generic";
																				$role2 = "Generic MSISDN";
																				$role3 = "CCB/Buyer Order Address";
																				$sqlgotquery = "select concat(username,'-',wphone) as wphonegot, wphone as wphonegot_id from `m_user` 
												                                where wphone in (select msisdnreq from m_request where gorderaccounting_status like '%buyer-100-Success%')";
																				$currency_name = "Remove Generic(Guaranteed Order)";
																				$currency_symbol= "N";
																				$guaranteedorderauxillary = "removeofftakergoshow";
																				$offsqlgotquery = "select concat(username,'-',wphone) as offwphonegot, wphone as offwphonegot_id 
																				from `m_user` 
																				where wphone in(select msisdnoff from m_offtaker where  tran_status like '%Success%')" ;
											
																				}
								




	

										if($divid == "addofftakergo"){

											$GLOBALS['$Transaction_type'] = "addofftaker";
											$GLOBALS['$Trans_tittle'] = "Add Offtaker to Guaranteed Order";	 
											$role = "CCB/Buyer";
											$role2 = "CCB/Buyer MSISDN";
											$role3 = "CCB/Buyer Order Address";
											$sqlgotquery = "select concat(username,'-',wphone) as wphonegot, wphone as wphonegot_id from `m_user` 
												where wphone in (select msisdnreq from m_request where gorderaccounting_status like '%buyer-100-Success%')";
											$currency_name = "Add Offtaker(Guaranteed Order) ";
											$currency_symbol= "N";
											$guaranteedorderauxillary = "addofftakergoshow";
											$offsqlgotquery = "select concat(username,'-',wphone) as offwphonegot, wphone as offwphonegot_id 
												from `m_user` 
												where wphone in(select msisdnoff from m_offtaker where  tran_status like '%Success%')" ;
											
											}



											if($divid == "removeofftakergo"){

												$GLOBALS['$Transaction_type'] = "removeofftaker";
												$GLOBALS['$Trans_tittle'] = "Remove Offtaker from Guaranteed Order";	 
												$role = "CCB/Buyer";
												$role2 = "CCB/Buyer MSISDN";
												$role3 = "CCB/Buyer Order Address";
												$sqlgotquery = "select concat(username,'-',wphone) as wphonegot, wphone as wphonegot_id from `m_user` 
												where wphone in (select msisdnreq from m_request where gorderaccounting_status like '%buyer-100-Success%')";
												$currency_name = "Remove Offtaker(Guaranteed Order)";
												$currency_symbol= "N";
												$guaranteedorderauxillary = "removeofftakergoshow";
												$offsqlgotquery = "select concat(username,'-',wphone) as offwphonegot, wphone as offwphonegot_id 
												from `m_user` 
												where wphone in(select msisdnoff from m_offtaker where  tran_status like '%Success%')" ;
											
												}

										if($divid == "farmerrole"){

											$GLOBALS['$Transaction_type'] = "addfarmer";
											$GLOBALS['$Trans_tittle'] = "Farmer Role";	 
											$role = "Farmer";
											$currency_name = "Add Farmer";
											$currency_symbol= "N";
											$sqlfarloc = "select loc_name as far_loc,loc_index from `m_location` where transaction_id like '%Success%'";
											$add_role = "add_roleshow";
											$add_loc_title = "Loaction";
											$add_role_block = "add_roles_blockshow";
											$add_farmerrole = "add_farmerroleshow";
											$sqlfarquery = "select concat(username,'-',wphone) as wphonefar, wphone as wphonefar_id from `m_user` 
								where username not like 'naira@cellulant.com%'
								and username not like 'dollar@cellulant.com%'
								and username not like 'mula@cellulant.com%'
								and username not like 'cellulant@cellulant.com%'
								and wphone not in (SELECT msisdnfar FROM m_farmer where tran_status like '%Success%'
								UNION
								SELECT msisdncer FROM m_certifier where tran_status like '%Success%'
								UNION
								SELECT msisdnoff FROM m_offtaker where tran_status like '%Success%')";
											}

											if($divid == "dealerrole"){

												$GLOBALS['$Transaction_type'] = "adddealer";
												$GLOBALS['$Trans_tittle'] = "Dealer/Supplier Role";	 
												$role = "Dealer/Supplier";
												$currency_name = "Add Dealer/Supplier";
												$currency_symbol= "N";
												$sqlfarloc = "select loc_name as far_loc,loc_index from `m_location` where transaction_id like '%Success%'";
												$add_role = "add_roleshow";
												$add_loc_title = "Loaction";
												$add_role_block = "add_roles_blockshow";
												$add_farmerrole = "add_farmerroleshow";
												$sqlfarquery = "select concat(username,'-',wphone) as wphonefar, wphone as wphonefar_id from `m_user` 
								where username not like 'naira@cellulant.com%'
								and username not like 'dollar@cellulant.com%'
								and username not like 'mula@cellulant.com%'
								and username not like 'cellulant@cellulant.com%'
								and wphone not in (SELECT msisdnfar FROM m_farmer where tran_status like '%Success%'
								UNION
								SELECT msisdncer FROM m_certifier where tran_status like '%Success%'
								UNION
								SELECT msisdnoff FROM m_offtaker where tran_status like '%Success%')";
												}

												if($divid == "genericrt"){

													$GLOBALS['$Transaction_type'] = "addgenericroletype";
													$GLOBALS['$Trans_tittle'] = "Generic Role Type";	 
													$role = "Role Type";
													$currency_name = "Define Role Type";
													$currency_symbol= "N";
													$sqlfarloc = "select loc_name as far_loc,loc_index from `m_location` where transaction_id like '%Success%'";
													$add_role = "add_role";
													$add_loc_title = "Loaction";
													$add_role_block = "add_roles_block";
													//$add_role_block = "add_roles_blockshow";
													$add_farmerrole = "add_farmerroleshow";
													$sqlfarquery = "select concat(username,'-',wphone) as wphonefar, wphone as wphonefar_id from `m_user` 
								where username not like 'naira@cellulant.com%'
								and username not like 'dollar@cellulant.com%'
								and username not like 'mula@cellulant.com%'
								and username not like 'cellulant@cellulant.com%'
								and wphone not in (SELECT msisdnfar FROM m_farmer where tran_status like '%Success%'
								UNION
								SELECT msisdncer FROM m_certifier where tran_status like '%Success%'
								UNION
								SELECT msisdnoff FROM m_offtaker where tran_status like '%Success%')";
													}

											if($divid == "certifierrole"){

												$GLOBALS['$Transaction_type'] = "Corporate Certifier Role";
												$GLOBALS['$Trans_tittle'] = "Add Certifier";	 
												$role = "Receipt Certifier";
												$currency_name = "Add Certifier";
												$currency_symbol= "N";
												$addcertifierrole = "addcertifierroleshow";
												}

												if($divid == "confirmdelivery"){

													$GLOBALS['$Transaction_type'] = "confirmdelivery";
													$GLOBALS['$Trans_tittle'] = "Buyer Confirmation of Produce Delivery";	 
													$role = "Confirm Delivery";
													$processed_own = "Buyer ";
													$currency_name = "Confirm Produce Delivery";
													$currency_symbol= "N";
													$cersqlcre_cer = "SELECT DISTINCT concat(concat(username,'-'),wphone) as cerwphonecre, wphone as cerwphonecre_id from m_user where wphone in (Select msisdncre from m_p_receipt_cer where tran_type = 'certify' and (outcre like '%Success%' or outcre like '%receiptpay-204%')) ";
													$addcertifyproduce = "addcertifyproduceshow";
													}

													if($divid == "certifyproduce"){

														$GLOBALS['$Transaction_type'] = "certify";
														$GLOBALS['$Trans_tittle'] = "Produce Receipt Certifier";	 
														$role = "Receipt Certifier";
														$processed_own = "Certifier ";
														$currency_name = "Certify Produce receipt";
														$currency_symbol= "N";
														$cersqlcre_cer = "select concat(item_name,concat('-',concat(u.username,'-',u.wphone))) as cerwphonecre, u.wphone as cerwphonecre_id
 
					                                    from m_item i,m_certifier c,m_user u
					                                    where c.msisdncer = u.wphone 
					                                    and c.tran_status LIKE '%Success%'
					                                    and cast(i.loc_index as int) = cast(c.commodity as int) ";
														$addcertifyproduce = "addcertifyproduceshow";
														}

													if($divid == "insurertocontract"){

														$GLOBALS['$Transaction_type'] = "addinsurer1";
														$GLOBALS['$Trans_tittle'] = "Activate Insurer Contract";	 
														$role = "Insurer Contract";
														$processed_own = "Insurer";
														$currency_name = "Insurer Contract";
														$currency_symbol= "N";
														$cersqlcre_cer = "select concat(concat(username,'-'),wphone) as cerwphonecre, u.wphone as cerwphonecre_id
														from m_user,m_offtaker
														where wphone = msisdnoff
														and   tran_type = 'addgenericrole'
														and tran_status like '%Success%'";
														$addcertifyproduce = "addcertifyproduceshow";
														}


														if($divid == "generictocontract"){

															$GLOBALS['$Transaction_type'] = "addgenericrole1";
															$GLOBALS['$Trans_tittle'] = "Activate Generic Contract";	 
															$role = "Generic Contract";
															$processed_own = "Generic";
															$currency_name = "Generic Contract";
															$currency_symbol= "N";
															$cersqlcre_cer = "select concat(concat(username,'-'),wphone) as cerwphonecre, wphone as cerwphonecre_id
															from m_user,m_offtaker
															where wphone = msisdnoff
															and   tran_type = 'addgenericrole'
															and tran_status like '%Success%'";
															$addcertifyproduce = "addcertifyproduceshow";
															}






													if($divid == "issuereceipt"){

														$GLOBALS['$Transaction_type'] = "addpreceipt";
														$GLOBALS['$Trans_tittle'] = "Report Offtaker Issue Produce Receipt to Farmer";	 
														$role = "Issue Receipt to Farmer";
														$currency_name = "Produce receipt";
														$currency_symbol= "N";
														$add_offtakerreceipt = "add_offtakerreceiptshow";
														}

														if($divid == "addinsurertoreceipt"){

															$GLOBALS['$Transaction_type'] = "addinsurer1";
															$GLOBALS['$Trans_tittle'] = "Report Activate Insurere Contract(Produce Receipt to Farmer)";	 
															$role = "Activate Insurer Contract(Receipt to Farmer)";
															$currency_name = "Produce receipt";
															$currency_symbol= "N";
															$add_offtakerreceipt = "add_offtakerreceiptshow";
															}
			

	if($divid == "redeemreceipt"){

		$GLOBALS['$Transaction_type'] = "Redeem Produce Receipt";
		$GLOBALS['$Trans_tittle'] = "Farmer Redeem Produce Receipt";	 
		$role = "Redeem Receipt";
		$currency_name = "Produce receipt";
		$currency_symbol= "N";
		$addredeemreceipt = "addredeemreceiptshow";
			}
			
		
	

	if($divid == "addcommodity"){

	$GLOBALS['$Transaction_type'] = "addcommodity";
	$GLOBALS['$Trans_tittle'] = "Agrikore Commodities";	 
	$role = "Commodity";
	$currency_name = "Add Commodity";
	$currency_symbol= "N";
	$add_commodity = "addcommodityshow";
	}

	if($divid == "addexpenses"){

		$GLOBALS['$Transaction_type'] = "addexpenses";
		$GLOBALS['$Trans_tittle'] = "Agrikore Expenses";	 
		$role = "Expenses";
		$currency_name = "Add Expenses";
		$currency_symbol= "N";
		$add_expenses = "addexpensesshow";
		}


		if($divid == "addlocation"){

			$GLOBALS['$Transaction_type'] = "addlocation";
		$GLOBALS['$Trans_tittle'] = "Agrikore Location";	 
		$role = "Location";
		$currency_name = "Add Location";
		$currency_symbol= "N";
		$add_location = "addlocationshow";
		}
		
	
	$trans_type = $GLOBALS['$Transaction_type'];
	$trans_tittle = $GLOBALS['$Trans_tittle'];
?>



<input type="hidden" id="divid" value="<?php echo $trans_type ?>" />

<script type="text/javascript">

$(document).ready(function(){
  $("#set_addr_com_red").hide();
});
$(document).ready(function(){
  $("#set_addr_com_redshow").hide();
});


$(document).ready(function(){
  $("#mainmenu").hide();
});
$(document).ready(function(){
  $("#setcomm").hide();
});

//Generic Role Type Block
$(document).ready(function(){
  $("#generic").hide();
});
$(document).ready(function(){
  $("#genericshow").hide();
});

//Remove offtaker from G.O
$(document).ready(function(){
  $("#removeofftakergo").hide();
});
$(document).ready(function(){
  $("#removeofftakergoshow").show();
});

//Add offtaker to G.O
$(document).ready(function(){
  $("#addofftakergo").hide();
});
$(document).ready(function(){
  $("#addofftakergoshow").show();
});

//Add Issue Receipt
$(document).ready(function(){
  $("#issuereceipt").hide();
});
$(document).ready(function(){
  $("#issuereceiptshow").show();
});

//Add redeem receipt
$(document).ready(function(){
  $("#addredeemreceipt").hide();
});
$(document).ready(function(){
  $("#addredeemreceiptshow").show();
});

//Add certifier
$(document).ready(function(){
  $("#addcertifyproduce").hide();
});
$(document).ready(function(){
  $("#addcertifyproduceshow").show();
});

// certify produce
$(document).ready(function(){
  $("#addcertifierrole").hide();
});
$(document).ready(function(){
  $("#addcertifierroleshow").show();
});


//Add Location
$(document).ready(function(){
  $("#addlocation").hide();
});
$(document).ready(function(){
  $("#addlocationshow").show();
});

//Add Location
$(document).ready(function(){
  $("#addcommodity").hide();
});
$(document).ready(function(){
  $("#addcommodityshow").show();
});

//Add expenses
$(document).ready(function(){
  $("#addexpenses").hide();
});
$(document).ready(function(){
  $("#addexpensesshow").show();
});



//set comm/redeem
$(document).ready(function(){
  $("#commission_set_operation").hide();
});
$(document).ready(function(){
  $("#commission_set_operationshow").show();
});


//reserve op hide currency 
$(document).ready(function(){
  $("#reserve_op_cur").hide();
});
$(document).ready(function(){
  $("#reserve_op_curshow").show();
});

//reserve op hide  amount
$(document).ready(function(){
  $("#reserve_op_cur_amount").hide();
});
$(document).ready(function(){
  $("#reserve_op_cur_amountshow").show();
});

//naira/dollar deposits
$(document).ready(function(){
  $("#reserve_operation").hide();
});
$(document).ready(function(){
  $("#reserve_operationshow").show();
});

//set minting mula
$(document).ready(function(){
  $("#currency_operation").hide();
});
$(document).ready(function(){
  $("#currency_operationshow").show();
});


//add offtaker receipt
$(document).ready(function(){
  $("#offtaker_receiptblock").hide();
});
$(document).ready(function(){
  $("#offtaker_receiptshow").show();
});

//add role sub-block
$(document).ready(function(){
  $("#add_roles_block").hide();
});
$(document).ready(function(){
  $("#add_roles_blockshow").show();
});

//add farmer role
$(document).ready(function(){
  $("#add_farmerrole").hide();
});
$(document).ready(function(){
  $("#add_farmerroleshow").show();
});

//add offtaker role
$(document).ready(function(){
  $("#add_offtakerrole").hide();
});
$(document).ready(function(){
  $("#add_offtakerroleshow").show();
});


//Set Redemption Commission And Address
$(document).ready(function(){
  $("#redem_comm_address").hide();
});
$(document).ready(function(){
  $("#redem_comm_addressshow").show();
});

//add offtaker role
$(document).ready(function(){
  $("#add_offtakerreceipt").hide();
});
$(document).ready(function(){
  $("#add_offtakerreceiptshow").show();
});

//add role
$(document).ready(function(){
  $("#add_role").hide();
});
$(document).ready(function(){
  $("#add_roleshow").show();
});
//buyer contract
$(document).ready(function(){
  $("#add_order").hide();
});
$(document).ready(function(){
  $("#add_ordershow").show();
});

//loaner contract
$(document).ready(function(){
  $("#add_loaner").hide();
});
$(document).ready(function(){
  $("#add_loanershow").show();
});

//loaner expenses item contract
$(document).ready(function(){
  $("#add_expitem").hide();
});
$(document).ready(function(){
  $("#add_expitemshow").show();
});

</script>



<div id="<?php echo $set_comm; ?>" style="display: none">
<section class="content">
	<div class="box box-success">
		<div class="box-header with-border">
			<h2 class="box-title">Corporate Commodity Buyer</h2>
		</div>
		<!--./ box header-->
		<div class="box-body">
			<div class="row">
				<div class="col-md-250">
					<center>
					
					<button type="submit" class="btn btn-primary " id="btnaddrequest" name=""><i class="fa fa-plus"></i> Request to Buy</button>
					<button type="submit" class="btn btn-primary " id="btnadd" name=""><i class="fa fa-plus"></i> Set Commission</button>
					<button type="submit" class="btn btn-primary " id="btnaddloc" name=""><i class="fa fa-plus"></i>Add Location</button>
					<button type="submit" class="btn btn-primary " id="btnaddoff" name=""><i class="fa fa-plus"></i>Add Offtaker</button>
					<button type="submit" class="btn btn-primary " id="btnaddcer" name=""><i class="fa fa-plus"></i> Add Certifier</button>
					<button type="submit" class="btn btn-primary " id="btnaddfar" name=""><i class="fa fa-plus"></i> Add Farmer</button>
				<button type="submit" class="btn btn-primary " id="btnadd" name=""><i class="fa fa-plus"></i> Confirm Order</button>
				<button type="submit" class="btn btn-primary " id="btnadd" name=""><i class="fa fa-plus"></i> Fund Account</button>
				<button type="submit" class="btn btn-primary " id="btnadd" name=""><i class="fa fa-plus"></i> Create Certifier</button>
				<button type="submit" class="btn btn-primary " id="btnadd" name=""><i class="fa fa-plus"></i> Confirm Certifier</button>
				<button type="submit" class="btn btn-primary " id="btnadd" name=""><i class="fa fa-plus"></i> Confirm Receipt</button>
				<button type="submit" class="btn btn-primary " id="btnadd" name=""><i class="fa fa-plus"></i> Produce Receipt</button>
				<button type="submit" class="btn btn-primary " id="btnadd" name=""><i class="fa fa-plus"></i> Add Produce</button>
				
					
					<br>
					<br>
					<br>
</center>
				</div>

			</div>
			
		</div>
	</div><!-- /.box -->

</section><!-- /.content -->

</div>







<!--
//******************************************************************************
 //   Block Chain Set Redemption Commission
 //   *******************************************************************************/
-->

<div id="<?php echo $redem_comm_address; ?>" style="display: none">
<section class="content">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title">Set Redemption Commission And Address)</h3>
		</div>
		
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<button type="submit" class="btn btn-primary " id="btnaddrco" name=""><i class="fa fa-plus"></i> Set Commission Address and Percentage,Redemption Percentage</button>
					<br>
				</div>
			</div>
			<div class="box-body table-responsive no-padding" style="max-width:1124px;">
				<table id="table_rco" class="table  table-bordered table-hover ">
					<thead>
					<tr class="tableheader">
							<th style="width:40px">#</th>
							<th style="width:60px">Id</th>
							<th style="width:100px">Title</th>
							
							<th style="width:60px">Commission(%)</th>
							<th style="width:100px">Receipt Reclaim(%)</th>
							<th style="width:100px">Receipt Reclaim value</th>
							<th style="width:60px">MSISDN </th>
							<th style="width:140px">Account Status</th> 
							<th style="width:140px">Commission Status</th> 
							<th style="width:140px">Reclaim Status</th> 
							<th></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>		
		</div>
	</div><!-- /.box -->

</section><!-- /.content -->



<div id="modalmasterrco" class="modal fade ">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">Set Redemption Commission and Address Form</h4>
			</div>
			<!--modal header-->
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="box-body">
						<div class="form-group"> <label class="col-sm-3  control-label">Id</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtidrco" name="txtidrco" value="*New" placeholder="" disabled=""><input type="hidden" id="inputcrud" name="inputcrud" class="" value="N"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Transaction Title</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtrconame" name="txtrconame" value="" placeholder="Please fill out Tran. name"> 
							</div>
						</div>

						<div class="form-group"> <label class="col-sm-3  control-label">Currency Type</label>
							<div class="col-sm-7"><select name="txtctyrco" class="form-control" id="txtctyrco">
					<option value=''>--- Select --</option>
					<?php 
					$sql = "select * from `m_currency` where id_currency = '$currency_name' ";
					$res = mysqli_query($con, $sql);
					if(mysqli_num_rows($res) > 0) {
						while($row = mysqli_fetch_object($res)) {
							echo "<option value='".$row->id_currency."'>".$row->currency."</option>";
						}
					}
					?>
				    </select></div>
					</div>
					</div>


						
						<div class="form-group"> <label class="col-sm-3  control-label">Commission Percentage</label>
							<div class="col-sm-7"><input type="number" class="form-control " id="txtcomrco" name="txtcomrco" value="" placeholder="Please fill out Commission Percentage"> 
							</div>
						</div>

						<div class="form-group"> <label class="col-sm-3  control-label">Redemption Commission Percentage</label>
							<div class="col-sm-7"><input type="number" class="form-control " id="txtredrco" name="txtredrco" value="" placeholder="Please fill out Redemption Commission Percentage"> 
							</div>
						</div>
                    
						<div class="form-group"> <label class="col-sm-3  control-label">Fixrd Redemption Commission</label>
							<div class="col-sm-7"><input type="number" class="form-control " id="txtfredrco" name="txtfredrco" value="" placeholder="Please fill out Redemption Commission Percentage"> 
							</div>
						</div>
						
							
						<div class="form-group"> <label class="col-sm-3  control-label">Wallet No:</label>
							<div class="col-sm-7"><select name="txtmsisdnrco" class="form-control" id="txtmsisdnrco">
					<option value=''>---- Select ---</option>
					<?php 
					$sql = "select concat(username,'-',wphone) as wphone2, wphone as wphone1_id2 from `m_user` where wphone is not null";
					$res = mysqli_query($con, $sql);
					if(mysqli_num_rows($res) > 0) {
						while($row = mysqli_fetch_object($res)) {
							echo "<option value='".$row->wphone1_id2."'>".$row->wphone2."</option>";
						}
					}
					?>
				    </select>
					</div>
					</div>	
						<div class="form-group"> <label class="col-sm-3  control-label">Commission Account Address</label>
						<div class="col-sm-7"><select name="txtaddressrco" class="form-control" id="txtaddressrco" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>
						
		
							<div class="form-group"> <label class="col-sm-1  control-label"></label>
								<div class="col-sm-11"><button type="submit" title="Save Button" class="btn btn-primary " id="btnsaverco" name=""><i class="fa fa-save"></i> Submit</button> <span id="infoprosesrco"></span> </div>
							</div>
						</div>
					</div>
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
</div>
		

				

<!--
//******************************************************************************
 //   Block Chain Set Redemption Commission
 //   *******************************************************************************/

-->
				




<!--
//******************************************************************************
 //   Block Chain Import Currency
 //   *******************************************************************************/
-->


<div id="<?php echo $reserve_operation; ?>" style="display: none">
<section class="content">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title"><?php echo $reserve_cap." :".$currency_name; ?></h3>
		</div>
		<!--./ box header-->
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<button type="submit" class="btn btn-primary " id="btnaddcur" name=""><i class="fa fa-plus"></i> <?php echo $trans_tittle?></button>
					<br>
				</div>
			</div>
			<div class="box-body table-responsive no-padding" style="max-width:1124px;">
				<table id="table_cur" class="table  table-bordered table-hover ">
					<thead>
					<tr class="tableheader">
							<th style="width:40px">#</th>
							<th style="width:60px">Id</th>
							<th style="width:190px">Transaction Title</th>
							<th style="width:60px">transaction_type </th>
							<th style="width:60px">Currency</th>
							
							<th style="width:60px">Value</th>
							<th style="width:60px">MSISDN</th>
							<th style="width:200px">Transaction Status</th> 
							<th></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>		
		</div>
	</div><!-- /.box -->

</section><!-- /.content -->


<div id="modalmastercur" class="modal fade ">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title"> <?php echo $trans_tittle." ".$currency_name; ?></h4>
			</div>
			<!--modal header-->
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="box-body">
						<div class="form-group"> <label class="col-sm-3  control-label">Id</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtidcur" name="txtidcur" value="*New" placeholder="" disabled=""><input type="hidden" id="inputcrud" name="inputcrud" class="" value="N"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Transaction Title</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtcurname" name="txtcurname" value="" placeholder="Please fill out Tran. name"> 
							</div>
						</div>
                    

						<div class="form-group"> <label class="col-sm-3  control-label">Transaction Type</label>
							<div class="col-sm-7"><select name="txttctycur" class="form-control" id="txttctycur" >
					<option value=''>--- Select --</option>
					<?php 
					//$sql = "select * from `m_transaction` where id_tran in ('sellmulafor','buymulafor','transferfromreserve','transfertoreserve','sellmula','buymula','importtoken','exporttoken','setcommissionaddress')";
					$sql = "select * from `m_transaction` where id_tran in ('$trans_type')";
					$res = mysqli_query($con, $sql);
					if(mysqli_num_rows($res) > 0) {
						while($row = mysqli_fetch_object($res)) {
							echo "<option value='".$row->id_tran."'>".$row->transaction."</option>";
						}
					}
					?>
				    </select></div>
					</div>
                        
					<div id="<?php echo $reserve_op_cur; ?>" style="display: none">

						<div class="form-group"> <label class="col-sm-3  control-label">Currency Type</label>
							<div class="col-sm-7"><select name="txtctycur" class="form-control" id="txtctycur">
					<option value=''>--- Select --</option>
					<?php 
					$sql = "select * from `m_currency` where id_currency = '$currency_name' ";
					$res = mysqli_query($con, $sql);
					if(mysqli_num_rows($res) > 0) {
						while($row = mysqli_fetch_object($res)) {
							echo "<option value='".$row->id_currency."'>".$row->currency."</option>";
						}
					}
					?>
				    </select></div>
					</div>
					</div>

                     <div id="<?php echo $reserve_op_cur_amount; ?>" style="display: none">
					 
							<div class="form-group"> <label class="col-sm-3  control-label">Amount</label>
							<div class="col-sm-7">
								<div class="input-group">
									<span class="input-group-addon"><?php echo $currency_symbol?></span>
									<input type="text" class="form-control money" id="txtcvalcur" name="txtcvalcur" value="" placeholder=""></div>
								</div>
							</div>
               </div>

						<div class="form-group"> <label class="col-sm-3  control-label">Wallet No:</label>
							<div class="col-sm-7"><select name="txtmsisdncur" class="form-control" id="txtmsisdncur">
					<option value=''>---- Select ---</option>
					<?php 
					$sql = $res_address_query;
					$res = mysqli_query($con, $sql);
					if(mysqli_num_rows($res) > 0) {
						while($row = mysqli_fetch_object($res)) {
							echo "<option value='".$row->wphone1_id2."'>".$row->wphone2."</option>";
						}
					}
					?>
				    </select>
					</div>
					</div>	
						<div class="form-group"> <label class="col-sm-3  control-label">Account Address</label>
						<div class="col-sm-7"><select name="txtaddresscur" class="form-control" id="txtaddresscur" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>
						
						<div class="form-group"> <label class="col-sm-3  control-label">Password</label>
				
							<div class="col-sm-7">  <input type="password" class="form-control" name="txtpasscur" id="txtpasscur" value="" placeholder="Please Enter Your password for the Sender Wallet">
			         	</div>
					   </div>	

						
		
							<div class="form-group"> <label class="col-sm-1  control-label"></label>
								<div class="col-sm-11"><button type="submit" title="Save Button" class="btn btn-primary " id="btnsavecur" name=""><i class="fa fa-save"></i> Submit</button> <span id="infoprosescur"></span> </div>
							</div>
						</div>
					</div>
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


</div>
<!--
//******************************************************************************
 //   Block Chain fund wallet
 //   *******************************************************************************/

-->

<!--
//******************************************************************************
 //   Block Chain Buy Currency
 //   *******************************************************************************/
-->

<div id="<?php echo $currency_operation; ?>" style="display: none">
<section class="content">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title">Currency Transaction :<?php echo $trans_tittle ?></h3>
		</div>
		<!--./ box header-->
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<button type="submit" class="btn btn-primary " id="btnaddmul" name=""><i class="fa fa-plus"></i><?php echo $trans_tittle ?></button>
					<br>
				</div>
			</div>
			<div class="box-body table-responsive no-padding" style="max-width:1124px;">
				<table id="table_mul" class="table  table-bordered table-hover ">
					<thead>
					<tr class="tableheader">
							<th style="width:40px">#</th>
							<th style="width:60px">Id</th>
							<th style="width:130px">Title</th>
							<th style="width:80px">Transaction</th>
							<th style="width:30px">Exchange</th>
							<th style="width:120px">Value</th>
							<th style="width:90px">Source</th>
							<th style="width:90px">Destination</th>
							<th style="width:100px"> Status:</th>
							<th></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>		
		</div>
	</div><!-- /.box -->

</section><!-- /.content -->


<div id="modalmastermul" class="modal fade ">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">Currency Transaction:<?php echo " ".$trans_tittle." "?>  Form</h4>
			</div>
			<!--modal header-->
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="box-body">
						<div class="form-group"> <label class="col-sm-3  control-label">Id</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtidmul" name="txtidmul" value="*New" placeholder="" disabled=""><input type="hidden" id="inputcrud" name="inputcrud" class="" value="N"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Transaction Title</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtmulname" name="txtmulname" value="" placeholder="Please fill out Redemption Title"> </div>
						</div>
						
						
						
						<script type="text/javascript">
                       
				
						function ShowHideBuymula1() {
                        var ddlPassport = document.getElementById("txtmultcty");
                       var dvPassport = document.getElementById("actmsisdn1");
                       dvPassport.style.display = (ddlPassport.value == "setbuyprice" || ddlPassport.value == "setsellprice") ? "block" : "none";
						}

						

						function ShowHideBuymula2() {
                        var ddlPassport = document.getElementById("txtmultcty");
                       var dvPassport = document.getElementById("actmsisdn2");
                       dvPassport.style.display = (ddlPassport.value == "buymula" || ddlPassport.value == "sellmula" || ddlPassport.value == "sellmulafor" || ddlPassport.value == "buymulafor" || ddlPassport.value == "transferfromreserve" || ddlPassport.value == "transfertoreserve") ? "block" : "none";
						}
						
						function ShowHideTransfer() {
                        var ddlPassport = document.getElementById("txtmultcty");
                       var dvPassport = document.getElementById("transfer");
                       dvPassport.style.display = (ddlPassport.value == "admintransfernofee" || ddlPassport.value == "transfer") ? "block" : "none";
					   	
					}
						
						
					   </script>
					   <!--modal header
					  
	
						-->
						<div class="form-group"> <label class="col-sm-3  control-label">Transsaction Type</label>
							<div class="col-sm-7"><select name="txtmultcty" class="form-control" id="txtmultcty"  onchange="ShowHideTransfer()" >
					<option value=''>--- Select --</option>
					<?php 
					//$sql = "select * from `m_transaction` where id_tran not in ('transferfromreserve','transfertoreserve','sellmula','buymula','importtoken','exporttoken','addbuyer','addfarmer','adddealer','addfunds','addgrantor','addloaner','addofftaker','approve')";
					$sql = "select * from `m_transaction` where id_tran in ('$trans_type')";
					$res = mysqli_query($con, $sql);
					if(mysqli_num_rows($res) > 0) {
						while($row = mysqli_fetch_object($res)) {
							echo "<option value='".$row->id_tran."'>".$row->transaction."</option>";
						}
					}
					?>
				    </select></div>
					</div>
					<div class="form-group"> <label class="col-sm-3  control-label">With(Exchange) Currency</label>
							<div class="col-sm-7"><select name="txtmulfcty" class="form-control" id="txtmulfcty">
					<option value=''>--- Select --</option>
					<?php 
					$sql = "select * from `m_currency` where id_currency = '$currency_name' ";
					$res = mysqli_query($con, $sql);
					if(mysqli_num_rows($res) > 0) {
						while($row = mysqli_fetch_object($res)) {
							echo "<option value='".$row->id_currency."'>".$row->currency."</option>";
						}
					}
					?>
				    </select></div>
					</div>
						<div class="form-group" > 
								<label class="col-sm-3  control-label" ><?php echo $trans_tittle?></label>
							<div class="col-sm-7">
								<div class="input-group">
									<span class="input-group-addon"><?php echo $currency_symbol?></span>
									<input type="text" class="form-control money" id="txtmulcval" name="txtmulcval" value="" placeholder=""></div>
								</div>
							</div>

							<div id="transfer" style="display: none">

                      
							<!--Source address begin
							<div id="actmsisdn2" style="display: none"> -->
						<div class="form-group"> <label class="col-sm-3  control-label" >Wallet No:</label>
							<div class="col-sm-7">
							
							<select name="txtmsisdnmul" class="form-control" id="txtmsisdnmul" >
					<option value=''>---- Select ---</option>
					<?php 

                    
					$sqlmull = "select concat(username,'-',wphone) as wphone1, wphone as wphone1_id 
					from m_user where wphone is not null ";
					//$sql = "select * from `m_user` where wphone=".$walletno;
					$resmull = mysqli_query($con, $sqlmull);
					if(mysqli_num_rows($resmull) > 0) {
						while($row = mysqli_fetch_object($resmull)) {
							echo "<option value='".$row->wphone1_id."'>".$row->wphone1."</option>";
						}
					}
					?>
				    </select>
					</div>
					</div>	
						<div class="form-group"> <label class="col-sm-3  control-label">Account Address</label>
						<div class="col-sm-7"><select name="txtaddressmul" class="form-control" id="txtaddressmul" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>


							<div class="form-group"> <label class="col-sm-3  control-label">Password</label>
				
							<div class="col-sm-7">  <input type="password" class="form-control" name="txtpassmul" id="txtpassmul" value="" placeholder="Please Enter Your password for the Sender Wallet">
			         	</div>
					   </div>	
					   
					   
					<!--	
				</div>
						Source address ends-->

					   <!--Destination address begin-->
					   
					   <div class="form-group"> <label class="col-sm-3  control-label">Destination-Wallet No:</label>
						<div class="col-sm-7"><select name="txtmsisdnmuldes" class="form-control" id="txtmsisdnmuldes" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>

						<div class="form-group"> <label class="col-sm-3  control-label">Destination-Account Address</label>
						<div class="col-sm-7"><select name="txtaddressmuldes" class="form-control" id="txtaddressmuldes" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>

						</div>
						
				<!--		
				
						Source address ends-->

							<div class="form-group"> <label class="col-sm-1  control-label"></label>
								<div class="col-sm-11"><button type="submit" title="Save Button" class="btn btn-primary " id="btnsavemul" name=""><i class="fa fa-save"></i> Submit</button> <span id="infoproses"></span> </div>
							</div>
						</div>
					</div>
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
<!--farmer-->
				</div>
<!--
//******************************************************************************
 //   Block Chain Buy Currency
 //   *******************************************************************************/
-->






<div id="<?php echo $add_commodity; ?>" style="display: none">
<section class="content">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title">Available Commodity</h3>
		</div>
		<!--./ box header-->
		<div class="box-body">
			<div class="row">
				<div class="col-md-3">
					<button type="submit" class="btn btn-primary " id="btnadditem" name=""><i class="fa fa-plus"></i> Add Commodity</button>
					<br>
				</div>
			</div>
			<div class="box-body table-responsive no-padding" style="max-width:1124px;">
				<table id="table_item" class="table  table-bordered table-hover ">
					<thead>
					<tr class="tableheader">
							<th style="width:40px">#</th>
							<th style="width:60px">Id</th>
							<th style="width:100px">Item</th>
							
							<th style="width:120px">Ware-H Price</th>
							<th style="width:120px">Farm Price</th>
							<th style="width:60px">Stock</th>
							<th style="width:60px">term</th>
							<th style="width:140px">Status</th>
							<th></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>		
		</div>
	</div><!-- /.box -->

</section><!-- /.content -->

<div id="modalmasteritem" class="modal fade ">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">Add Commodity</h4>
			</div>
			<!--modal header-->
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="box-body">

						<div class="form-group"> <label class="col-sm-3  control-label">Id</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtiditem" name="txtiditem" value="*New" placeholder="" disabled=""><input type="hidden" id="inputcrud" name="inputcrud" class="" value="N"> </div>
						</div>

						<div class="form-group"> <label class="col-sm-3  control-label">Item</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtname" name="txtname" value="" placeholder=""> </div>
							
						</div>
						
						<div class="form-group"> <label class="col-sm-3  control-label">Location</label>
						
							<div class="col-sm-7"><select name="txtindexloc" class="form-control" id="txtindexloc">
					<option value=''>--- Select --</option>
					
					//<?php 
					$sql = "select loc_name,loc_index from `m_location` where transaction_id like '%agriclocation-100-Success%'";
					$res = mysqli_query($con, $sql);
					if(mysqli_num_rows($res) > 0) {
						while($row = mysqli_fetch_object($res)) {
							echo "<option value='".$row->loc_index."'>".$row->loc_name."</option>";
						}
					}
					?>
					
				    </select></div>
					</div>

						<div class="form-group"> <label class="col-sm-3  control-label"> Price</label>
							<div class="col-sm-7">
								<div class="input-group">
									<span class="input-group-addon">N.</span>
									<input type="text" class="form-control money" id="txtprice" name="" value="" placeholder=""></div>
								</div>
							</div>

							<div class="form-group"> <label class="col-sm-3  control-label">WareHouse Price</label>
							<div class="col-sm-7">
								<div class="input-group">
									<span class="input-group-addon">N.</span>
									<input type="text" class="form-control money" id="txtstock" name="" value="" placeholder=""></div>
								</div>
							</div>	
						

						<div class="form-group"> <label class="col-sm-3  control-label">Terms</label>
							<div class="col-sm-7"><input type="text" class="form-control decimal" id="txtterms" name="" value="0" placeholder=""> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Unit</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtunit" name="" value="" placeholder="Please fill out unit name"> </div>
						</div>
						

							<div class="form-group"> <label class="col-sm-3  control-label">Farm Price</label>
							<div class="col-sm-7">
								<div class="input-group">
									<span class="input-group-addon">N.</span>
									<input type="text" class="form-control money" id="txtfprice" name="" value="" placeholder=""></div>
								</div>
							</div>

							<div class="form-group"> <label class="col-sm-3  control-label">Note</label>
								<div class="col-sm-7"><textarea class="form-control " rows="3" id="txtnote" name="" placeholder="Note"></textarea> </div>
							</div>
							<div class="form-group"> <label class="col-sm-3  control-label"></label>
								<div class="col-sm-7"><button type="submit" title="Save Button" class="btn btn-primary "id="btnsaveitem" name=""><i class="fa fa-save"></i> Save</button> <span id="infoprosescom"></span> </div>
							</div>
						</div>
					</div>
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
	</div>
	<!--
/******************************************************************************
    Block Chain location Open
    *******************************************************************************/
-->

<div id="<?php echo $add_location; ?>" style="display: none">
<section class="content">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title">Commodity Locations</h3>
		</div>
		<!--./ box header-->
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<button type="submit" class="btn btn-primary " id="btnaddloc" name=""><i class="fa fa-plus"></i> Add Location</button>
					<br>
				</div>
			</div>
			<div class="box-body table-responsive no-padding" style="max-width:1124px;">
				<table id="table_loc" class="table  table-bordered table-hover ">
					<thead>
					<tr class="tableheader">
							<th style="width:40px">#</th>
							<th style="width:60px">Id</th>
							<th style="width:60px">location</th>
							<th style="width:60px">coordinate</th>
							<th style="width:60px">postal</th>
							<th style="width:60px">locality</th>
							<th style="width:60px">State</th>
							<th style="width:60px">Country</th>
							<th></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>		
		</div>
	</div><!-- /.box -->

</section><!-- /.content 

-->
<div id="modalmasterloc" class="modal fade ">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">Add Location Form</h4>
			</div>
			<!--modal header-->
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="box-body">
						<div class="form-group"> <label class="col-sm-3  control-label">Id</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtidloc" name="txtidloc" value="*New" placeholder="" disabled=""><input type="hidden" id="inputcrud" name="inputcrud" class="" value="N"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">location</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtlocname" name="ltxtlocname" value="" placeholder="Please fill out Location name"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Coordinates</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtcood" name="txtcood" value="" placeholder="Please fill out Coordinates"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Postal</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtpostal" name="txtpostal" value="" placeholder="Please fill out Postal Code"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Locality</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtlocality" name="txtlocality" value="" placeholder="Please fill out Locality"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">State</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtstate" name="txtstate" value="" placeholder="Please fill out State"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Country</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtcountry" name="txtcountry" value="" placeholder="Please fill out Country"> </div>
						</div>
						
							<div class="form-group"> <label class="col-sm-1  control-label"></label>
								<div class="col-sm-11"><button type="submit" title="Save Button" class="btn btn-primary " id="btnsaveloc" name=""><i class="fa fa-save"></i> Submit</button> <span id="infoprosesloc"></span> </div>
							</div>
						</div>
					</div>
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

</div>



<!--
//******************************************************************************
 //   Block Chain location Close
 //   *******************************************************************************/



/******************************************************************************
    Block Chain Expenses Open
    *******************************************************************************/
-->

<div id="<?php echo $add_expenses; ?>" style="display: none">
<section class="content">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title">Expenses</h3>
		</div>
		<!--./ box header-->
		<div class="box-body">
			<div class="row">
				<div class="col-md-3">
					<button type="submit" class="btn btn-primary " id="btnaddexp" name=""><i class="fa fa-plus"></i> Add Expenses</button>
					<br>
				</div>
			</div>
			<div class="box-body table-responsive no-padding" style="max-width:1124px;">
				<table id="table_exp" class="table  table-bordered table-hover ">
					<thead>
					<tr class="tableheader">
							<th style="width:40px">#</th>
							<th style="width:60px">Id</th>
							<th style="width:100px">Expenses</th>
							
							<th style="width:120px">Price</th>
							<th style="width:120px">Whole-Sale Price</th>
							<th style="width:60px">terms</th>
							<th style="width:140px">Status</th>
							<th></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>		
		</div>
	</div><!-- /.box -->

</section><!-- /.content -->

<div id="modalmasterexp" class="modal fade ">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">Expenses</h4>
			</div>
			<!--modal header-->
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="box-body">

						<div class="form-group"> <label class="col-sm-3  control-label">Id</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtidexp" name="txtidexp" value="*New" placeholder="" disabled=""><input type="hidden" id="inputcrud" name="inputcrud" class="" value="N"> </div>
						</div>

						<div class="form-group"> <label class="col-sm-3  control-label">Expenses</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtexpname" name="txtexpname" value="" placeholder=""> </div>
							
						</div>
						
						<div class="form-group"> <label class="col-sm-3  control-label">Location</label>
						
							<div class="col-sm-7"><select name="txtexpindexloc" class="form-control" id="txtexpindexloc">
					<option value=''>--- Select --</option>
					
					//<?php 
					$sqlexp = "select loc_name as exploc_name,loc_index as exploc_index from `m_location` where transaction_id like '%agriclocation-100-Success%'";
					$resexp = mysqli_query($con, $sqlexp);
					if(mysqli_num_rows($resexp) > 0) {
						while($row = mysqli_fetch_object($resexp)) {
							echo "<option value='".$row->exploc_index."'>".$row->exploc_name."</option>";
						}
					}
					?>
					
				    </select></div>
					</div>

						<div class="form-group"> <label class="col-sm-3  control-label"> Price</label>
							<div class="col-sm-7">
								<div class="input-group">
									<span class="input-group-addon">N.</span>
									<input type="text" class="form-control money" id="txtexpprice" name="" value="" placeholder=""></div>
								</div>
							</div>

							
						<div class="form-group"> <label class="col-sm-3  control-label">Terms</label>
							<div class="col-sm-7"><input type="text" class="form-control decimal" id="txtexpterms" name="txtexpterms" value="0" placeholder=""> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Unit</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtexpunit" name="" value="" placeholder="Please fill out unit name"> </div>
						</div>
						

							<div class="form-group"> <label class="col-sm-3  control-label">Whole Sale Price</label>
							<div class="col-sm-7">
								<div class="input-group">
									<span class="input-group-addon">N.</span>
									<input type="text" class="form-control money" id="txtexpwprice" name="" value="" placeholder=""></div>
								</div>
							</div>

							
							<div class="form-group"> <label class="col-sm-3  control-label"></label>
								<div class="col-sm-7"><button type="submit" title="Save Button" class="btn btn-primary "id="btnsaveexp" name=""><i class="fa fa-save"></i> Save</button> <span id="infoprosesexp"></span> </div>
							</div>
						</div>
					</div>
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
	</div>
	<!--
/******************************************************************************
    Block Chain Expenses Close
    *******************************************************************************/


//******************************************************************************
 //   Block Chain Offtaker Open
 //   *******************************************************************************/
-->


<div id="<?php echo $add_offtakerrole; ?>" style="display: none">

<section class="content">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title"><?php echo $trans_tittle; ?></h3>
		</div>
		<!--./ box header-->
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<button type="submit" class="btn btn-primary " id="btnaddoff" name=""><i class="fa fa-plus"></i><?php echo $role; ?></button>
					<br>
				</div>
			</div>
			<div class="box-body table-responsive no-padding" style="max-width:1124px;">
				<table id="table_off" class="table  table-bordered table-hover ">
					<thead>
					<tr class="tableheader">
							<th style="width:40px">#</th>
							<th style="width:60px">Id</th>
							<th style="width:100px"><?php echo $currency_name; ?></th>
							<th style="width:60px">MSISDN</th>
							<th style="width:110px">Receipt Limit</th>
							
							<th style="width:90px">Fixed Rate</th>
							<th style="width:60px">%-Rate</th>
							<th style="width:160px">Transaction</th>
							<th style="width:160px">Status</th>
							<th></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>		
		</div>
	</div><!-- /.box -->

</section><!-- /.content -->


<div id="modalmasteroff" class="modal fade ">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title"><?php echo $role; ?> Contract Form</h4>
			</div>
			<!--modal header-->
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="box-body">
						<div class="form-group"> <label class="col-sm-3  control-label">Id</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtidoff" name="txtidoff" value="*New" placeholder="" disabled=""><input type="hidden" id="inputcrud" name="inputcrud" class="" value="N"> </div>
						</div>
						
						<div class="form-group"> <label class="col-sm-3  control-label"><?php echo $currency_name; ?></label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtoffname" name="txtoffname" value="" placeholder="Please fill out Certifier name"> </div>
					   </div>

                   <div class="form-group"> <label class="col-sm-3  control-label">Transsaction Type</label>
							<div class="col-sm-7"><select name="txttctyoff" class="form-control" id="txttctyoff" >
					<option value=''>--- Select --</option>
					<?php 
					//$sql = "select id_tran as id_tranfar,transaction as tranfar from `m_transaction` where id_tran in ('addfarmer','addbuyer','adddealer','addloaner','addgrantor')";
					$sql = "select id_tran as id_tranfar,transaction as tranfar from `m_transaction` where id_tran in ('$trans_type')";
					$res = mysqli_query($con, $sql);
					if(mysqli_num_rows($res) > 0) {
						while($row = mysqli_fetch_object($res)) {
							echo "<option value='".$row->id_tranfar."'>".$row->tranfar."</option>";
						}
					}
					?>
				    </select>
					</div>
					</div>


					   
					   <div id="<?php echo $add_role_block; ?>" style="display: none">

					<div class="form-group"> <label class="col-sm-3  control-label">Generic Role Type</label>	
							<div class="col-sm-7"><select name="txtgenrtoff" class="form-control" id="txtgenrtoff">
					<option value=''>--- Select --</option>
					
					<?php 
					$sqlgenoff = "SELECT SUBSTRING_INDEX(far_name,' ', -1) as idgen,far_name as genname from m_farmer where tran_status  = 'Status :genericrole-100-Success,'";
					$resgen = mysqli_query($con, $sqlgenoff);
					if(mysqli_num_rows($resgen) > 0) {
						while($row = mysqli_fetch_object($resgen)) {
							echo "<option value='".$row->idgen."'>".$row->genname."</option>";
						}
					}
					?>
					
					</select>
				   </div>
					</div>	
           </div>

					<div class="form-group"> <label class="col-sm-3  control-label">Location</label>	
							<div class="col-sm-7"><select name="txtlocnameoff" class="form-control" id="txtlocnameoff">
					<option value=''>--- Select --</option>
					
					<?php 
					$sqloff = "select loc_name as off_loc,loc_index from `m_location` where transaction_id like '%Success%'";
					$res = mysqli_query($con, $sqloff);
					if(mysqli_num_rows($res) > 0) {
						while($row = mysqli_fetch_object($res)) {
							echo "<option value='".$row->loc_index."'>".$row->off_loc."</option>";
						}
					}
					?>
					
					</select>
				   </div>
					</div>	
					
					
                    <div id="<?php echo $offtaker_receipt; ?>" style="display: none">

						<div class="form-group"> <label class="col-sm-3  control-label"> Receipt Limit</label>
							<div class="col-sm-7">
								<div class="input-group">
									<span class="input-group-addon">N.</span>
									<input type="text" class="form-control money" id="txtlimitoff" name="txtlimitoff" value="" placeholder="">
									</div>
								</div>
							</div>
                    </div>


						<div class="form-group"> <label class="col-sm-3  control-label">Fixed Rate</label>
							<div class="col-sm-7">
								<div class="input-group">
									<span class="input-group-addon">N.</span>
									<input type="text" class="form-control money" id="txtfrateoff" name="txtfrateoff" value="" placeholder=""></div>
								</div>
							</div>

						<div class="form-group"> <label class="col-sm-3  control-label">Percentage Rate</label>
							<div class="col-sm-7">
								<div class="input-group">
									<span class="input-group-addon">N(%).</span>
									<input type="text" class="form-control money" id="txtprateoff" name="txtprateoff" value="" placeholder=""></div>
								</div>
							</div>


						<div class="form-group"> <label class="col-sm-3  control-label" >Wallet No:</label>
							<div class="col-sm-7">
							
							<select name="txtmsisdnoff" class="form-control" id="txtmsisdnoff" >
					<option value=''>---- Select ---</option>
					<?php 

                    
					$sql = "select concat(username,'-',wphone) as wphoneoff, wphone as wphoneoff_id 
					from `m_user` 
					where wphone not in(select msisdnfar from m_farmer where tran_status like '%Success%') ";
					//$sql = "select * from `m_user` where wphone=".$walletno;
					$res = mysqli_query($con, $sql);
					if(mysqli_num_rows($res) > 0) {
						while($row = mysqli_fetch_object($res)) {
							echo "<option value='".$row->wphoneoff_id."'>".$row->wphoneoff."</option>";
						}
					}
					?>
				    </select>
					</div>
					</div>	
						<div class="form-group"> <label class="col-sm-3  control-label">Account Address</label>
						<div class="col-sm-7"><select name="txtaddressoff" class="form-control" id="txtaddressoff" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>

						
							<div class="form-group"> <label class="col-sm-1  control-label"></label>
								<div class="col-sm-11"><button type="submit" title="Save Button" class="btn btn-primary " id="btnsaveoff" name=""><i class="fa fa-save"></i> Submit</button> <span id="infoprosesoff"></span> </div>
							</div>
						</div>
					</div>
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

</div>
<!--
//******************************************************************************
 //   Block Chain Offtaker Close
 //   *******************************************************************************/



//******************************************************************************
 //   Block Chain Certifier Open
 //   *******************************************************************************/
-->

<div id="<?php echo $addcertifierrole; ?>" style="display: none">

<section class="content">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title">Commodity Certifiers</h3>
		</div>
		<!--./ box header-->
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<button type="submit" class="btn btn-primary " id="btnaddcer" name=""><i class="fa fa-plus"></i> Add Certifier</button>
					<br>
				</div>
			</div>
			<div class="box-body table-responsive no-padding" style="max-width:1124px;">
				<table id="table_cer" class="table  table-bordered table-hover ">
					<thead>
					<tr class="tableheader">
							<th style="width:40px">#</th>
							<th style="width:60px">Id</th>
							<th style="width:60px">Certifier</th>
							<th style="width:60px">location</th>
							<th style="width:60px">Commodity</th>
							<th style="width:150px">Status</th>
							
							<th></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>		
		</div>
	</div><!-- /.box -->

</section><!-- /.content -->


<div id="modalmastercer" class="modal fade ">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">Add Certifier Role Form</h4>
			</div>
			<!--modal header-->
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="box-body">
						<div class="form-group"> <label class="col-sm-3  control-label">Id</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtidcer" name="txtidcer" value="*New" placeholder="" disabled=""><input type="hidden" id="inputcrud" name="inputcrud" class="" value="N"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Certifier</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtcername" name="txtcername" value="" placeholder="Please fill out Certifier name"> </div>
						</div>
						

                    <div class="form-group"> <label class="col-sm-3  control-label">Location</label>	
							<div class="col-sm-7"><select name="txtlocnamec" class="form-control" id="txtlocnamec">
					<option value=''>--- Select --</option>
					
					<?php 
					$sqloff = "select loc_name as off_loc_name,loc_index as off_loc from `m_location`";
					$res = mysqli_query($con, $sqloff);
					if(mysqli_num_rows($res) > 0) {
						while($row = mysqli_fetch_object($res)) {
							echo "<option value='".$row->off_loc."'>".$row->off_loc_name."</option>";
						}
					}
					?>
					
					</select>
				   </div>
					</div>	

					<div class="form-group"> <label class="col-sm-3  control-label">Commodity</label>	
							<div class="col-sm-7"><select name="txtcommodityc" class="form-control" id="txtcommodityc">
					<option value=''>--- Select --</option>
					
					<?php 
					$sqloffitem = "select item_name,loc_index  from `m_item`";
					$res = mysqli_query($con, $sqloffitem);
					if(mysqli_num_rows($res) > 0) {
						while($row = mysqli_fetch_object($res)) {
							echo "<option value='".$row->loc_index."'>".$row->item_name."</option>";
						}
					}
					?>
					
					</select>
				   </div>
					</div>
					<div class="form-group"> <label class="col-sm-3  control-label">Percentage Rate</label>
							<div class="col-sm-7"><input type="number" class="form-control " id="txtpratecer" name="txtpratecer" value="" placeholder="0"> </div>
						</div>
						
						<div class="form-group"> <label class="col-sm-3  control-label">Fixed Commission Rate</label>
							<div class="col-sm-7"><input type="number" class="form-control " id="txtfratecer" name="txtfratecer" value="" placeholder="0"> </div>
						</div>

						<div class="form-group"> <label class="col-sm-3  control-label" >Wallet No:</label>
							<div class="col-sm-7">
							
							<select name="txtmsisdncer" class="form-control" id="txtmsisdncer" >
					<option value=''>---- Select ---</option>
					<?php 

                    
					$sqlcer = "select concat(username,'-',wphone) as wphonecer, wphone as wphonecer_id 
					from `m_user` 
					where wphone is not null
					and username not like 'naira@cellulant.com%'
					and username not like 'dollar@cellulant.com%'
					and username not like 'mula@cellulant.com%'
					and username not like 'cellulant@cellulant.com%'
					and wphone not in (SELECT msisdnfar FROM m_farmer where tran_status like '%Success%') 
					and wphone not in (SELECT msisdnoff FROM m_offtaker where tran_status like '%Success%')  ";
					//$sql = "select * from `m_user` where wphone=".$walletno;
					$rescer = mysqli_query($con, $sqlcer);
					if(mysqli_num_rows($rescer) > 0) {
						while($row = mysqli_fetch_object($rescer)) {
							echo "<option value='".$row->wphonecer_id."'>".$row->wphonecer."</option>";
						}
					}
					?>
				    </select>
					</div>
					</div>	
						<div class="form-group"> <label class="col-sm-3  control-label">Account Address</label>
						<div class="col-sm-7">
							<select name="txtaddresscer" class="form-control" id="txtaddresscer" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>

						
							<div class="form-group"> <label class="col-sm-1  control-label"></label>
								<div class="col-sm-11"><button type="submit" title="Save Button" class="btn btn-primary " id="btnsavecer" name=""><i class="fa fa-save"></i> Submit</button> <span id="infoprosescer"></span> </div>
							</div>
						</div>
					</div>
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

</div>
<!--
//******************************************************************************
 //   Block Chain Certifier Close
 //   *******************************************************************************/



//******************************************************************************
 //   Block Chain Farmer Open
 //   *******************************************************************************/
-->


<div id="<?php echo $add_farmerrole; ?>" style="display: none">
<section class="content">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title">Agrikore Role.:<?php echo " ".$currency_name; ?></h3>
		</div>
		<!--./ box header-->
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<button type="submit" class="btn btn-primary " id="btnaddfar" name=""><i class="fa fa-plus"></i> <?php echo " ".$currency_name; ?></button>
					<br>
				</div>
			</div>
			<div class="box-body table-responsive no-padding" style="max-width:1124px;">
				<table id="table_far" class="table  table-bordered table-hover ">
					<thead>
					<tr class="tableheader">
							<th style="width:40px">#</th>
							<th style="width:60px">Id</th>
							<th style="width:60px">Transaction Type</th>
							<th style="width:100px"><?php echo $role ?></th>
							<th style="width:100px"><?php echo $add_loc_title ?></th>
							
							<th style="width:60px">MSISDN</th>
							<th style="width:100px">Status</th>
							<th></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>		
		</div>
	</div><!-- /.box -->

</section><!-- /.content -->


<div id="modalmasterfar" class="modal fade ">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title"><?php echo $trans_tittle ?> Form</h4>
			</div>
			<!--modal header-->
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="box-body">
						<div class="form-group"> <label class="col-sm-3  control-label">Id</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtidfar" name="txtidfar" value="*New" placeholder="" disabled=""><input type="hidden" id="inputcrud" name="inputcrud" class="" value="N"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label"><?php echo " ".$role." " ?></label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtfarname" name="txtfarname" value="" placeholder="Please fill out <?php echo " ".$role." " ?> name"> </div>
						</div>

						<div class="form-group"> <label class="col-sm-3  control-label">Transsaction Type</label>
							<div class="col-sm-7"><select name="txttctyfar" class="form-control" id="txttctyfar" >
					<option value=''>--- Select --</option>
					<?php 
					//$sql = "select id_tran as id_tranfar,transaction as tranfar from `m_transaction` where id_tran in ('addfarmer','addbuyer','adddealer','addloaner','addgrantor')";
					$sql = "select id_tran as id_tranfar,transaction as tranfar from `m_transaction` where id_tran in ('$trans_type')";
					$res = mysqli_query($con, $sql);
					if(mysqli_num_rows($res) > 0) {
						while($row = mysqli_fetch_object($res)) {
							echo "<option value='".$row->id_tranfar."'>".$row->tranfar."</option>";
						}
					}
					?>
				    </select>
					</div>
					</div>
						
                    
					
					<div id="<?php echo $add_role; ?>" style="display: none">

						<div class="form-group"> <label class="col-sm-3  control-label"><?php echo $add_loc_title; ?></label>	
							<div class="col-sm-7"><select name="txtlocnamefar" class="form-control" id="txtlocnamefar">
					<option value=''>--- Select --</option>
					
					<?php 
					$sqlfar = $sqlfarloc;
					$res = mysqli_query($con, $sqlfar);
					if(mysqli_num_rows($res) > 0) {
						while($row = mysqli_fetch_object($res)) {
							echo "<option value='".$row->loc_index."'>".$row->far_loc."</option>";
						}
					}
					?>
					
					</select>
				   </div>
					</div>
                    
					


					<div class="form-group"> <label class="col-sm-3  control-label" >Wallet No:</label>
							<div class="col-sm-7">
							
							<select name="txtmsisdnfar" class="form-control" id="txtmsisdnfar" >
					<option value=''>---- Select ---</option>
					<?php 

                    
					$sqlfar = $sqlfarquery;
					//$sql = "select * from `m_user` where wphone=".$walletno;
					$resfar = mysqli_query($con, $sqlfar);
					if(mysqli_num_rows($resfar) > 0) {
						while($row = mysqli_fetch_object($resfar)) {
							echo "<option value='".$row->wphonefar_id."'>".$row->wphonefar."</option>";
						}
					}
					?>
				    </select>
					</div>
					</div>	
						<div class="form-group"> <label class="col-sm-3  control-label">Account Address</label>
						<div class="col-sm-7">
							<select name="txtaddressfar" class="form-control" id="txtaddressfar" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>

<!--inner div block-->
</div>


						
							<div class="form-group"> <label class="col-sm-1  control-label"></label>
								<div class="col-sm-11"><button type="submit" title="Save Button" class="btn btn-primary " id="btnsavefar" name=""><i class="fa fa-save"></i> Submit</button> <span id="infoprosesfar"></span> </div>
							</div>
						</div>
					</div>
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
<!--farmer-->
				</div>
<!--
//******************************************************************************
 //   Block Chain Farmer Close
 //   *******************************************************************************/



//******************************************************************************
 //   Block Chain Guaranteed Order Open
 //   *******************************************************************************/
-->


<div id="<?php echo $add_order; ?>" style="display: none">
<section class="content">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title"><?php echo $trans_tittle; ?></h3>
		</div>
		<!--./ box header-->
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<button type="submit" class="btn btn-primary " id="btnaddrequest" name=""><i class="fa fa-plus"></i> <?php echo $currency_name; ?></button>
					<br>
				</div>
			</div>
			<div class="box-body table-responsive no-padding" style="max-width:1824px;">
				<table id="table_request" class="table  table-bordered table-hover ">
					<thead>
					<tr class="tableheader">
							<th style="width:20px">#</th>
							<th style="width:90px">Title &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp;      </th>
							<th style="width:90px">Issuer &nbsp; &nbsp; &nbsp;  &nbsp;   &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp;    </th>
							<th style="width:90px">Commodity &nbsp; &nbsp; &nbsp;  &nbsp;      </th>
							<th style="width:90px">QTY &nbsp; &nbsp; &nbsp;  &nbsp;&nbsp; &nbsp; &nbsp;  &nbsp;  </th>
							
							<th style="width:90px">Price &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; </th>
							<th style="width:90px">Allowed C.% &nbsp; &nbsp; &nbsp;  &nbsp; </th>
							<th style="width:90px">Covered &nbsp; &nbsp; &nbsp;  &nbsp; </th>
							<th style="width:90px">Bond &nbsp; &nbsp; &nbsp;  &nbsp; </th>
							<th style="width:90px">Handling Type</th>
							<th style="width:90px">Interest Rate</th>
							
							<th style="width:90px">Gorder&nbsp; &nbsp; &nbsp;  &nbsp; </th>
							
							<th style="width:90px">Accounting&nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; </th>
							<th style="width:90px">Transfer&nbsp; &nbsp; &nbsp;  &nbsp;&nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp;  </th>
							
							<th></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>		
		</div>
	</div><!-- /.box -->

</section><!-- /.content -->


<div id="modalmasterrequest" class="modal fade ">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title"><?php echo $trans_tittle; ?> Form</h4>
			</div>
			<!--modal header-->
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="box-body">
						<div class="form-group"> <label class="col-sm-3  control-label">Id</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtidrequest" name="txtidrequest" value="*New" placeholder="" disabled=""><input type="hidden" id="inputcrud" name="inputcrud" class="" value="N"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Title</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="requesttxtname" name="requesttxtname" value="" placeholder="Please fill out request name"> </div>
						</div>
					
						
					   
                      <div class="form-group"> <label class="col-sm-3  control-label">Commodity</label>	
							<div class="col-sm-7"><select name="requesttxtcommodity" class="form-control" id="requesttxtcommodity">
					<option value=''>--- Select --</option>
					
					<?php 
					$sqlrequest = "select item_name as item_namereq,loc_index as comm_idex  from m_item where transaction_id like '%Success%'";
					$resrequest = mysqli_query($con, $sqlrequest);
					if(mysqli_num_rows($resrequest) > 0) {
						while($row = mysqli_fetch_object($resrequest)) {
							echo "<option value='".$row->comm_idex."'>".$row->item_namereq."</option>";
						}
					}
					?>
					
					</select>
				   </div>
					</div>

					<div class="form-group"> <label class="col-sm-3  control-label">CCB-Toal Order</label>
							<div class="col-sm-7">
								<div class="input-group">
									<span class="input-group-addon">N.</span>
									<input type="text" class="form-control money" id="requesttxtstock" name="" value="" placeholder=""></div>
								</div>
							</div>
						
<!-- 
						<div class="form-group"> <label class="col-sm-3  control-label">Guaranteed QTY</label>
							<div class="col-sm-7"><input type="text" class="form-control money" id="requesttxtstock" name="" value="0" placeholder=""> </div>
						</div>
 -->						
						
						<div class="form-group"> <label class="col-sm-3  control-label">Coupon Price (per kg)</label>
							<div class="col-sm-7">
								<div class="input-group">
									<span class="input-group-addon">N.</span>
									<input type="text" class="form-control money" id="requesttxtprice" name="" value="" placeholder=""></div>
								</div>
							</div>

							<div class="form-group"> <label class="col-sm-3  control-label">Unit</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="requesttxtunit" name="" value="" placeholder="Please fill out unit name"> </div>
						</div>

                            <div class="form-group"> <label class="col-sm-3  control-label">Strike Price (per kg)</label>
							<div class="col-sm-7">
								<div class="input-group">
									<span class="input-group-addon">N.</span>
									<input type="text" class="form-control money" id="requesttxtbvalue" name="" value="" placeholder=""></div>
								</div>
							</div>
							<div class="form-group"> <label class="col-sm-3  control-label">Cover.Value</label>
							<div class="col-sm-7">
								<div class="input-group">
									<span class="input-group-addon">N.</span>
									<input type="text" class="form-control money" id="requesttxtcvalue" name="" value="" placeholder=""></div>
								</div>
							</div>
							
							<div class="form-group"> <label class="col-sm-3  control-label">Handling Type</label>
							<div class="col-sm-7"><input type="text" class="form-control decimal" id="requesttxthtype" name="" value="0" placeholder=""> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Allowed Credit Percentage (%)Y</label>
							<div class="col-sm-7"><input type="text" class="form-control decimal" id="requesttxtacpercentage" name="" value="0" placeholder=""> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Interest Rate (%)</label>
							<div class="col-sm-7"><input type="text" class="form-control decimal" id="requesttxtirate" name="" value="0" placeholder=""> </div>
						</div>
						<!--modal footer
						<div class="form-group"> <label class="col-sm-3  control-label">Offtaker Rate (%)</label>
							<div class="col-sm-7"><input type="text" class="form-control decimal" id="requesttxtorate" name="" value="0" placeholder=""> </div>
						</div>
						-->
						<div class="form-group"> <label class="col-sm-3  control-label">Duration</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="requesttxtduration" name="requesttxtduration" value="0" placeholder=""> </div>
						</div>
						
						<div class="form-group"> <label class="col-sm-3  control-label" >Wallet No:</label>
							<div class="col-sm-7">
							
							<select name="txtmsisdnrequest" class="form-control" id="txtmsisdnrequest" >
					<option value=''>---- Select ---</option>
					<?php 

                    
					$sqlrequest = "SELECT 
					concat(username,'-',wphone) as wphonerequest, wphone as wphonerequest_id FROM m_user t1	INNER JOIN	m_farmer t2 ON t1.wphone = t2.msisdnfar
					where transaction_type = 'addbuyer'; ";
					//$sql = "select * from `m_user` where wphone=".$walletno;
					$resrequest = mysqli_query($con, $sqlrequest);
					if(mysqli_num_rows($resrequest) > 0) {
						while($row = mysqli_fetch_object($resrequest)) {
							echo "<option value='".$row->wphonerequest_id."'>".$row->wphonerequest."</option>";
						}
					}
					?>
				    </select>
					</div>
					</div>	
						<div class="form-group"> <label class="col-sm-3  control-label">Account Address</label>
						<div class="col-sm-7">
							<select name="txtaddressrequest" class="form-control" id="txtaddressrequest" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>
						


						
						<div class="form-group"> <label class="col-sm-3  control-label">Password</label>
							<div class="col-sm-7"><input type="password" class="form-control " id="requesttxtpass" name="requesttxtpass" value="" placeholder="Please fill out Address Password"> </div>
						</div>


							<div class="form-group"> <label class="col-sm-1  control-label"></label>
								<div class="col-sm-11"><button type="submit" title="Save Button" class="btn btn-primary " id="btnsaverequest" name=""><i class="fa fa-save"></i> Submit Request</button> <span id="infoprosesrequest"></span> </div>
							</div>
						</div>
					</div>
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

</div>
<!--
//******************************************************************************
 //   Block Chain Guaranteed Order Close
 //   *******************************************************************************/

//******************************************************************************
 //   Block Chain Guaranteed Order Transactions Open
 //   *******************************************************************************/
-->


<div id="<?php echo $guaranteedorderauxillary; ?>" style="display: none">
<section class="content">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title"><?php echo $trans_tittle ?></h3>
		</div>
		<!--./ box header-->
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<button type="submit" class="btn btn-primary " id="btnaddgot" name=""><i class="fa fa-plus"></i> <?php echo $currency_name?></button>
					<br>
				</div>
			</div>
			<div class="box-body table-responsive no-padding" style="max-width:1124px;">
				<table id="table_got" class="table  table-bordered table-hover ">
					<thead>
					<tr class="tableheader">
							<th style="width:40px">#</th>
							<th style="width:60px">Id</th>
							<th style="width:150px">Transaction Type</th>
							<th style="width:130px"><?php echo $role ?></th>
							<th style="width:130px"><?php echo $role2 ?></th>
							<th style="width:140px">Order MSISDN</th>
							<th style="width:140px">Status</th>
							<th></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>		
		</div>
	</div><!-- /.box -->

</section><!-- /.content -->


<div id="modalmastergot" class="modal fade ">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title"><?php echo $trans_tittle ?> Form</h4>
			</div>
			<!--modal header-->
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="box-body">
						<div class="form-group"> <label class="col-sm-3  control-label">Id</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtidgot" name="txtidgot" value="*New" placeholder="" disabled=""><input type="hidden" id="inputcrud" name="inputcrud" class="" value="N"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Transaction Title</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtgotname" name="txtgotname" value="" placeholder="Please fill out Farmer name"> </div>
						</div>

                    <script type="text/javascript">
                       
				
					   function ShowHideOfftaker() {
					   var ddlPassport = document.getElementById("txttctygot");
					  var dvPassport = document.getElementById("offtaker");
					  dvPassport.style.display = (ddlPassport.value == "removeofftaker" || ddlPassport.value == "spendloan" || ddlPassport.value == "addofftaker" || ddlPassport.value == "removegenericrole" || ddlPassport.value == "addgenericrole1") ? "block" : "none";
					   }


					    function ShowHideAddfunds() {
					   var ddlPassport = document.getElementById("txttctygot");
					  var dvPassport = document.getElementById("addfunds");
					  dvPassport.style.display = (ddlPassport.value == "addfunds" || ddlPassport.value == "spendloan" || ddlPassport.value == "payloan" || ddlPassport.value == "addloandisburse"|| ddlPassport.value == "addloandisbursemula" || ddlPassport.value == "admintransfernofee") ? "block" : "none";
					   }

					  </script>




						<div class="form-group"> <label class="col-sm-3  control-label">Transsaction Type</label>
							<div class="col-sm-7"><select name="txttctygot" class="form-control" id="txttctygot" onchange="ShowHideOfftaker();ShowHideAddfunds()">
					<option value=''>--- Select --</option>
					<?php 
					//$sql = "select id_tran as id_trangot,transaction as trangot from `m_transaction` where id_tran in ('addfunds','admintransfernofee','addofftaker','removeofftaker','approve')";
					$sql = "select id_tran as id_trangot,transaction as trangot from `m_transaction` where id_tran in ('$trans_type')";
					$res = mysqli_query($con, $sql);
					if(mysqli_num_rows($res) > 0) {
						while($row = mysqli_fetch_object($res)) {
							echo "<option value='".$row->id_trangot."'>".$row->trangot."</option>";
						}
					}
					?>
				    </select></div>
					</div>
						
						
					<div class="form-group"> <label class="col-sm-3  control-label" ><?php echo $role ?> (Wallet No):</label>
							<div class="col-sm-7">
							
							<select name="txtmsisdngot" class="form-control" id="txtmsisdngot" >
					<option value=''>---- Select ---</option>
					<?php 

                    
					$sqlgot = $sqlgotquery;
					//$sql = "select * from `m_user` where wphone=".$walletno;
					$resgot = mysqli_query($con, $sqlgot);
					if(mysqli_num_rows($resgot) > 0) {
						while($row = mysqli_fetch_object($resgot)) {
							echo "<option value='".$row->wphonegot_id."'>".$row->wphonegot."</option>";
						}
					}
					?>
				    </select>
					</div>
					</div>	
						<div class="form-group"> <label class="col-sm-3  control-label"><?php echo $role ?>Account Address</label>
						<div class="col-sm-7">
							<select name="txtaddressgot" class="form-control" id="txtaddressgot" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>

                       
						<div class="form-group"> <label class="col-sm-3  control-label"><?php echo $role3 ?></label>
						<div class="col-sm-7">
							<select name="txtoaddressgor" class="form-control" id="txtoaddressgot" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>
						
						<div id="addfunds" style="display: none">
						<div class="form-group"> <label class="col-sm-3  control-label">Amount</label>
							<div class="col-sm-7">
								<div class="input-group">
									<span class="input-group-addon"><?php echo $currency_symbol?></span>
									<input type="text" class="form-control money" id="txtoamount" name="txtoamount" value="" placeholder=""></div>
								</div>
							</div>
                            </div>
                 
                         <div class="form-group"> <label class="col-sm-3  control-label"><?php echo $role ?>Password</label>
							<div class="col-sm-7"><input type="password" class="form-control " id="txtpassgot" name="txtpassgot" value="" placeholder="Please fill out the Wallet Password"> </div>
						</div>
						


                    <div id="offtaker" style="display: none">
						<div class="form-group"> <label class="col-sm-3  control-label" >Wallet No:</label>
							<div class="col-sm-7">
							
							<select name="offtxtmsisdngot" class="form-control" id="offtxtmsisdngot" >
					<option value=''>---- Select ---</option>
					<?php 

                    
					$offsqlgot = $offsqlgotquery;
					//$sql = "select * from `m_user` where wphone=".$walletno;
					$offresgot = mysqli_query($con, $offsqlgot);
					if(mysqli_num_rows($offresgot) > 0) {
						while($row = mysqli_fetch_object($offresgot)) {
							echo "<option value='".$row->offwphonegot_id."'>".$row->offwphonegot."</option>";
						}
					}
					?>
				    </select>
					</div>
					</div>	
						<div class="form-group"> <label class="col-sm-3  control-label">Account Address</label>
						<div class="col-sm-7">
							<select name="offtxtaddressgot" class="form-control" id="offtxtaddressgot" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>
                     </div>

							<div class="form-group"> <label class="col-sm-1  control-label"></label>
								<div class="col-sm-11"><button type="submit" title="Save Button" class="btn btn-primary " id="btnsavegot" name=""><i class="fa fa-save"></i> Submit</button> <span id="infoprosesgot"></span> </div>
							</div>
						</div>
					</div>
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
<!--got-->
</div>
<!--
//******************************************************************************
 //   Block Chain Guaranteed ord Transactions Close
 //   *******************************************************************************/
-->


<!--
//******************************************************************************
 //   Block Chain Produce Receipt Open
 //   *******************************************************************************/
-->

<div id="<?php echo $add_offtakerreceipt; ?>" style="display: none">

<section class="content">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title"><?php echo $trans_tittle; ?></h3>
		</div>
		<!--./ box header-->
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<button type="submit" class="btn btn-primary " id="btnaddpre" name=""><i class="fa fa-plus"></i> <?php echo $role; ?></button>
					<br>
				</div>
			</div>
			<div class="box-body table-responsive no-padding" style="max-width:1924px;">
				<table id="table_pre" class="table  table-bordered table-hover ">
					<thead>
					<tr class="tableheader">
							<th style="width:40px">#</th>
							<th style="width:60px">Id</th>
							<th style="width:160px">Receipt Title</th>
							<th style="width:160px">CCB (Order Holder)</th>
							<th style="width:160px">Issued By(Offtaker)</th>
							<th style="width:160px">Issued To(Farmer)</th>
							<th style="width:60px">Terms</th>
							<th style="width:60px">Quantity QTY</th>
							<th style="width:60px">Issued Value</th>
                            <th style="width:60px">Issued Date</th>
							<th></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>		
		</div>
	</div><!-- /.box -->

</section><!-- /.content -->





<div id="modalmasterpre" class="modal fade ">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">Add/ <?php echo $role; ?> Form</h4>
			</div>
			<!--modal header-->
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="box-body">
						<div class="form-group"> <label class="col-sm-3  control-label">Id</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtidpre" name="txtidpre" value="*New" placeholder="" disabled=""><input type="hidden" id="inputcrud" name="inputcrud" class="" value="N"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Transaction Title</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtprename" name="txtprename" value="" placeholder="Please fill out Farmer name"> </div>
						</div>

                    <div class="form-group"> <label class="col-sm-3  control-label">Transaction Type</label>
							<div class="col-sm-7"><select name="txttctypre" class="form-control" id="txttctypre" >
					<option value=''>--- Select --</option>
					<?php 
					//$sql = "select * from `m_transaction` where id_tran in ('sellmulafor','buymulafor','transferfromreserve','transfertoreserve','sellmula','buymula','importtoken','exporttoken','setcommissionaddress')";
					$sql = "select * from `m_transaction` where id_tran in ('$trans_type')";
					$res = mysqli_query($con, $sql);
					if(mysqli_num_rows($res) > 0) {
						while($row = mysqli_fetch_object($res)) {
							echo "<option value='".$row->id_tran."'>".$row->transaction."</option>";
						}
					}
					?>
				    </select></div>
					</div>
						
					<div class="form-group"> <label class="col-sm-3  control-label" >CCB Wallet No:</label>
							<div class="col-sm-7">
							
							<select name="txtmsisdnpre" class="form-control" id="txtmsisdnpre" >
					<option value=''>---- Select ---</option>
					<?php 

                    
					$sqlpre = "select concat(username,'-',wphone) as wphonepre, wphone as wphonepre_id from `m_user` 
					where wphone in (select msisdnreq from m_request where gorderaccounting_status like '%buyer-100-Success%')";
					//$sql = "select * from `m_user` where wphone=".$walletno;
					$respre = mysqli_query($con, $sqlpre);
					if(mysqli_num_rows($respre) > 0) {
						while($row = mysqli_fetch_object($respre)) {
							echo "<option value='".$row->wphonepre_id."'>".$row->wphonepre."</option>";
						}
					}
					?>
				    </select>
					</div>
					</div>	
						<div class="form-group"> <label class="col-sm-3  control-label">CCB Address</label>
						<div class="col-sm-7">
							<select name="txtaddresspre" class="form-control" id="txtaddresspre" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>

                       
						<div class="form-group"> <label class="col-sm-3  control-label">CCB Order Address</label>
						<div class="col-sm-7">
							<select name="txtoaddresspre" class="form-control" id="txtoaddresspre" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>
						
						
						<div class="form-group"> <label class="col-sm-3  control-label">Receipt Amount</label>
							<div class="col-sm-7">
								<div class="input-group">
									<span class="input-group-addon">N/$.</span>
									<input type="text" class="form-control money" id="txtamountpre" name="txtamountpre" value="" placeholder=""></div>
								</div>
							</div>
                            
                 
                        

                   
						<div class="form-group"> <label class="col-sm-3  control-label" >Offtaker Wallet No:</label>
							<div class="col-sm-7">
							
							<select name="offtxtmsisdnpre" class="form-control" id="offtxtmsisdnpre" >
					<option value=''>---- Select ---</option>
					<?php 

                    
					$offsqlpre = "select concat(username,'-',wphone) as offwphonepre, wphone as offwphonepre_id 
					from `m_user` 
					where wphone  in(select msisdnoff from m_offtaker where tran_status like '%Success%')";
					//$sql = "select * from `m_user` where wphone=".$walletno;
					$offrespre = mysqli_query($con, $offsqlpre);
					if(mysqli_num_rows($offrespre) > 0) {
						while($row = mysqli_fetch_object($offrespre)) {
							echo "<option value='".$row->offwphonepre_id."'>".$row->offwphonepre."</option>";
						}
					}
					?>
				    </select>
					</div>
					</div>	
						<div class="form-group"> <label class="col-sm-3  control-label">Offtaker Account Address</label>
						<div class="col-sm-7">
							<select name="offtxtaddresspre" class="form-control" id="offtxtaddresspre" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>

						 <div class="form-group"> <label class="col-sm-3  control-label">Offtaker Password</label>
							<div class="col-sm-7"><input type="password" class="form-control " id="txtpasspre" name="txtpasspre" value="" placeholder="Please fill out the Wallet Password"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Offtaker Quantity</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtqtypre" name="txtqtypre" value="" placeholder="Please fill out the Produce Qty"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Offtaker Terms</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txttermspre" name="txttermspre" value="" placeholder="Please fill out the Terms"> </div>
						</div>
					 
						<div class="form-group"> <label class="col-sm-3  control-label" >Receipt Issued to:</label>
							<div class="col-sm-7">
							
							<select name="fartxtmsisdnpre" class="form-control" id="fartxtmsisdnpre" >
					<option value=''>---- Select ---</option>
					<?php 

                    
					$farsqlpre = "select concat(username,'-',wphone) as farwphonepre, wphone as farwphonepre_id 
					from `m_user` 
					where wphone in(select msisdnfar from m_farmer where tran_status like '%Success%')";
					//$sql = "select * from `m_user` where wphone=".$walletno;
					$farrespre = mysqli_query($con, $farsqlpre);
					if(mysqli_num_rows($farrespre) > 0) {
						while($row = mysqli_fetch_object($farrespre)) {
							echo "<option value='".$row->farwphonepre_id."'>".$row->farwphonepre."</option>";
						}
					}
					?>
				    </select>
					</div>
					</div>	
						<div class="form-group"> <label class="col-sm-3  control-label">Issued Address:</label>
						<div class="col-sm-7">
							<select name="fartxtaddresspre" class="form-control" id="fartxtaddresspre" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>
					 
					 
					

							<div class="form-group"> <label class="col-sm-1  control-label"></label>
								<div class="col-sm-11"><button type="submit" title="Save Button" class="btn btn-primary " id="btnsavepre" name=""><i class="fa fa-save"></i> Submit</button> <span id="infoprosespre"></span> </div>
							</div>
						</div>
					</div>
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
<!--pre-->
</div>
<!--
//******************************************************************************
 //   Block Chain Produce Receipt Close
 //   *******************************************************************************/
 
-->


<!--
//******************************************************************************
 //   Block Chain Certify Produce Receipt Open
 //   *******************************************************************************/
-->
<div id="<?php echo $addcertifyproduce; ?>" style="display: none">

<section class="content">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title"><?php echo $trans_tittle ; ?></h3>
		</div>
		<!--./ box header-->
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<button type="submit" class="btn btn-primary " id="btnaddcre" name=""><i class="fa fa-plus"></i> <?php echo $currency_name; ?></button>
					<br>
				</div>
			</div>
			<div class="box-body table-responsive no-padding" style="max-width:1924px;">
				<table id="table_cre" class="table  table-bordered table-hover ">
					<thead>
					<tr class="tableheader">
					<th style="width:40px">#</th>
							<th style="width:60px">Id</th>
							<th style="width:160px"> Title</th>
							<th style="width:160px">Transaction</th>
							<th style="width:160px">CCB </th>
							<th style="width:160px">Owner</th>
							<th style="width:160px">Transaction Status</th>
                            <th style="width:60px">Date</th>
							<th></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>		
		</div>
	</div><!-- /.box -->

</section><!-- /.content -->





<div id="modalmastercre" class="modal fade ">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title"><?php echo $currency_name; ?> Form</h4>
			</div>
			<!--modal header-->
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="box-body">
						<div class="form-group"> <label class="col-sm-3  control-label">Id</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtidcre" name="txtidcre" value="*New" placeholder="" disabled=""><input type="hidden" id="inputcrud" name="inputcrud" class="" value="N"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Transaction Title</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtcrename" name="txtcrename" value="" placeholder="Please fill out Farmer name"> </div>
						</div>

                    <div class="form-group"> <label class="col-sm-3  control-label">Transsaction Type</label>
							<div class="col-sm-7"><select name="txttctycre" class="form-control" id="txttctycre" >
					<option value=''>--- Select --</option>
					<?php 
					//$sql = "select id_tran as id_tranfar,transaction as tranfar from `m_transaction` where id_tran in ('addfarmer','addbuyer','adddealer','addloaner','addgrantor')";
					$sql = "select id_tran as id_trancre,transaction as trancre from `m_transaction` where id_tran in ('$trans_type')";
					$res = mysqli_query($con, $sql);
					if(mysqli_num_rows($res) > 0) {
						while($row = mysqli_fetch_object($res)) {
							echo "<option value='".$row->id_trancre."'>".$row->trancre."</option>";
						}
					}
					?>
				    </select>
					</div>
					</div>
						
					<div class="form-group"> <label class="col-sm-3  control-label" >CCB Wallet No:</label>
							<div class="col-sm-7">
							
							<select name="txtmsisdncre" class="form-control" id="txtmsisdncre" >
					<option value=''>---- Select ---</option>
					<?php 

                    
$sqlcre = "SELECT distinct concat(a.username,'-',a.wphone) as wphonecre, a.wphone as wphonecre_id 
from m_p_receipt r,m_user a
where msisdnpre = wphone
and outpre like '%preceipt-100-Success%' and outpred like '%farmer-100-Success,offtaker-100-Success,operator-100-Success,preceipt-100-Success,preceipt-100-Success,preceipt-100-Success,preceipt-100-Success%'";
//$sql = "select * from `m_user` where wphone=".$walletno;
$rescre = mysqli_query($con, $sqlcre);
if(mysqli_num_rows($rescre) > 0) {
	while($row = mysqli_fetch_object($rescre)) {
		echo "<option value='".$row->wphonecre_id."'>".$row->wphonecre."</option>";
	}
}
					?>
				    </select>
					</div>
					</div>	
						<div class="form-group"> <label class="col-sm-3  control-label">CCB Order</label>
						<div class="col-sm-7">
							<select name="txtoaddresscre" class="form-control" id="txtoaddresscre" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>

                       
						<div class="form-group"> <label class="col-sm-3  control-label">CCB Order Receipts</label>
						<div class="col-sm-7">
							<select name="txtoreceiptcre" class="form-control" id="txtoreceiptcre" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>
						
						
                   
						<div class="form-group"> <label class="col-sm-3  control-label" ><?php echo $processed_own; ?> Wallet:</label>
							<div class="col-sm-7">
							
							<select name="certxtmsisdncre" class="form-control" id="certxtmsisdncre" >
					<option value=''>---- Select ---</option>
					<?php 

                    
					$cersqlcre = $cersqlcre_cer;
					//$sql = "select * from `m_user` where wphone=".$walletno;
					$cerrescre = mysqli_query($con, $cersqlcre);
					if(mysqli_num_rows($cerrescre) > 0) {
						while($row = mysqli_fetch_object($cerrescre)) {
							echo "<option value='".$row->cerwphonecre_id."'>".$row->cerwphonecre."</option>";
						}
					}
					?>
				    </select>
					</div>
					</div>	
						<div class="form-group"> <label class="col-sm-3  control-label"><?php echo $processed_own; ?>:Account Address</label>
						<div class="col-sm-7">
							<select name="certxtaddresscre" class="form-control" id="certxtaddresscre" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>

						 <div class="form-group"> <label class="col-sm-3  control-label"><?php echo $processed_own; ?>: Password</label>
							<div class="col-sm-7"><input type="password" class="form-control " id="txtpasscre" name="txtpasscre" value="" placeholder="Please fill out the Wallet Password"> </div>
						</div>
						

							<div class="form-group"> <label class="col-sm-1  control-label"></label>
								<div class="col-sm-11"><button type="submit" title="Save Button" class="btn btn-primary " id="btnsavecre" name=""><i class="fa fa-save"></i> Submit</button> <span id="infoprosescre"></span> </div>
							</div>
						</div>
					</div>
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
<!--cre-->
</div>
<!--
//******************************************************************************
 //   Block Chain Certify Produce Receipt Close
 //   *******************************************************************************/
 
-->


<!--
//******************************************************************************
 //   Block Chain Redeem Produce Receipt Open
 //   *******************************************************************************/
-->
<div id="<?php echo $addredeemreceipt; ?>" style="display: none">
<section class="content">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title">Redeem Produce Receipt</h3>
		</div>
		<!--./ box header-->
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<button type="submit" class="btn btn-primary " id="btnaddred" name=""><i class="fa fa-plus"></i> Redeem Produce Receipt</button>
					<br>
				</div>
			</div>
			<div class="box-body table-responsive no-padding" style="max-width:1924px;">
				<table id="table_red" class="table  table-bordered table-hover ">
					<thead>
					<tr class="tableheader">
							<th style="width:40px">#</th>
							<th style="width:60px">Id</th>
							<th style="width:160px">Redeemption Title</th>
							<th style="width:160px">CCB </th>
							<th style="width:160px">Farmer</th>
							<th style="width:160px">Transaction Status</th>
                            <th style="width:60px">Date</th>
							<th></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>		
		</div>
	</div><!-- /.box -->

</section><!-- /.content -->





<div id="modalmasterred" class="modal fade ">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">Redeem Produce Receipt Form</h4>
			</div>
			<!--modal header-->
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="box-body">
						<div class="form-group"> <label class="col-sm-3  control-label">Id</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtidred" name="txtidred" value="*New" placeholder="" disabled=""><input type="hidden" id="inputcrud" name="inputcrud" class="" value="N"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Transaction Title</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtredname" name="txtredname" value="" placeholder="Please fill out Farmer name"> </div>
						</div>

                    
						
					<div class="form-group"> <label class="col-sm-3  control-label" >CCB Wallet No:</label>
							<div class="col-sm-7">
							
							<select name="txtmsisdnred" class="form-control" id="txtmsisdnred" >
					<option value=''>---- Select ---</option>
					<?php 

                    
$sqlred = "SELECT distinct concat(a.username,'-',a.wphone) as wphonered, a.wphone as wphonered_id 
FROM m_user a
WHERE wphone in (
    select msisdncre from m_p_receipt_cer c,m_p_receipt p
    where c.oreceipt = p.order_rpt_address
    and c.tran_type = 'confirmdelivery' 
    and c.outcre like '%preceipt-100-Success,receiptpay-100-Success%')";
//$sql = "select * from `m_user` where wphone=".$walletno;
$resred = mysqli_query($con, $sqlred);
if(mysqli_num_rows($resred) > 0) {
	while($row = mysqli_fetch_object($resred)) {
		echo "<option value='".$row->wphonered_id."'>".$row->wphonered."</option>";
	}
}
					?>
				    </select>
					</div>
					</div>	
						<div class="form-group"> <label class="col-sm-3  control-label">CCB Order</label>
						<div class="col-sm-7">
							<select name="txtoaddressred" class="form-control" id="txtoaddressred" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>

                       
						<div class="form-group"> <label class="col-sm-3  control-label">CCB Order Receipts</label>
						<div class="col-sm-7">
							<select name="txtoreceiptred" class="form-control" id="txtoreceiptred" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>
						
						
                   
						<div class="form-group"> <label class="col-sm-3  control-label" >Farmer Wallet No:</label>
							<div class="col-sm-7">
							
							<select name="fartxtmsisdnred" class="form-control" id="fartxtmsisdnred" >
					<option value=''>---- Select ---</option>
					<?php 

                    
					$farsqlred = "select concat(username,'-',wphone) as farwphonered, wphone as farwphonered_id from `m_user` ";
					//$sql = "select * from `m_user` where wphone=".$walletno;
					$farresred = mysqli_query($con, $farsqlred);
					if(mysqli_num_rows($farresred) > 0) {
						while($row = mysqli_fetch_object($farresred)) {
							echo "<option value='".$row->farwphonered_id."'>".$row->farwphonered."</option>";
						}
					}
					?>
				    </select>
					</div>
					</div>	
						<div class="form-group"> <label class="col-sm-3  control-label">farmer Account Address</label>
						<div class="col-sm-7">
							<select name="fartxtaddressred" class="form-control" id="fartxtaddressred" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>

						 <div class="form-group"> <label class="col-sm-3  control-label">farmer Password</label>
							<div class="col-sm-7"><input type="password" class="form-control " id="txtpassred" name="txtpassred" value="" placeholder="Please fill out the Wallet Password"> </div>
						</div>
						

							<div class="form-group"> <label class="col-sm-1  control-label"></label>
								<div class="col-sm-11"><button type="submit" title="Save Button" class="btn btn-primary " id="btnsavered" name=""><i class="fa fa-save"></i> Submit</button> <span id="infoprosesred"></span> </div>
							</div>
						</div>
					</div>
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
<!--red-->
</div>
<!--
//******************************************************************************
 //   Block Chain Redeem Produce Receipt Close
 //   *******************************************************************************/
 



//******************************************************************************
 //   Block Chain agloan Open
 //   *******************************************************************************/
-->

<div id="<?php echo $add_agloan; ?>" style="display: none">

<section class="content">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title"><?php echo $trans_tittle; ?></h3>
		</div>
		<!--./ box header-->
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<button type="submit" class="btn btn-primary " id="btnaddagloan" name=""><i class="fa fa-plus"></i> <?php echo $role; ?></button>
					<br>
				</div>
			</div>
			<div class="box-body table-responsive no-padding" style="max-width:1924px;">
				<table id="table_agloan" class="table  table-bordered table-hover ">
					<thead>
					<tr class="tableheader">
							<th style="width:40px">#</th>
							<th style="width:60px">Id</th>
							<th style="width:160px"> Title</th>
							<th style="width:160px">CCB (Order Holder)</th>
							<th style="width:160px">Issued By(Loaner)</th>
							<th style="width:160px">Issued To(Beneficiary)</th>
							<th style="width:60px">Principal</th>
							<th style="width:60px">Principal limit</th>
							<th style="width:60px">Terms</th>
							<th style="width:60px">Moratorium</th>
							<th style="width:60px">Interest</th>
							<th style="width:60px">Penalty</th>
							<th style="width:60px">AutoPay</th>
							<th style="width:60px">PayDay</th>
							<th style="width:60px">Issued Date</th>
							<th></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>		
		</div>
	</div><!-- /.box -->

</section><!-- /.content -->





<div id="modalmasteragloan" class="modal fade ">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">Add/ <?php echo $role; ?> Form</h4>
			</div>
			<!--modal header-->
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="box-body">
						<div class="form-group"> <label class="col-sm-3  control-label">Id</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtidagloan" name="txtidagloan" value="*New" placeholder="" disabled=""><input type="hidden" id="inputcrud" name="inputcrud" class="" value="N"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Transaction Title</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtagloanname" name="txtagloanname" value="" placeholder="Please fill out Farmer name"> </div>
						</div>

                    <div class="form-group"> <label class="col-sm-3  control-label">Transaction Type</label>
							<div class="col-sm-7"><select name="txttctyagloan" class="form-control" id="txttctyagloan" >
					<option value=''>--- Select --</option>
					<?php 
					//$sql = "select * from `m_transaction` where id_tran in ('sellmulafor','buymulafor','transferfromreserve','transfertoreserve','sellmula','buymula','importtoken','exporttoken','setcommissionaddress')";
					$sql = "select * from `m_transaction` where id_tran in ('$trans_type')";
					$res = mysqli_query($con, $sql);
					if(mysqli_num_rows($res) > 0) {
						while($row = mysqli_fetch_object($res)) {
							echo "<option value='".$row->id_tran."'>".$row->transaction."</option>";
						}
					}
					?>
				    </select></div>
					</div>
						
	
                   
						<div class="form-group"> <label class="col-sm-3  control-label" >Loaner:</label>
							<div class="col-sm-7">
							
							<select name="lontxtmsisdnagloan" class="form-control" id="lontxtmsisdnagloan" >
					<option value=''>---- Select ---</option>
					<?php 

                    
					$lonsqlagloan = $addloansql;
					//$sql = "select * from `m_user` where wphone=".$walletno;
					$lonresagloan = mysqli_query($con, $lonsqlagloan);
					if(mysqli_num_rows($lonresagloan) > 0) {
						while($row = mysqli_fetch_object($lonresagloan)) {
							echo "<option value='".$row->lonwphoneagloan_id."'>".$row->lonwphoneagloan."</option>";
						}
					}
					?>
				    </select>
					</div>
					</div>	
						<div class="form-group"> <label class="col-sm-3  control-label">Loaner Account Address</label>
						<div class="col-sm-7">
							<select name="lontxtaddressagloan" class="form-control" id="lontxtaddressagloan" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>

						 <div class="form-group"> <label class="col-sm-3  control-label">Loaner Password</label>
							<div class="col-sm-7"><input type="password" class="form-control " id="txtpassagloan" name="txtpassagloan" value="" placeholder="Please fill out the Wallet Password"> </div>
						</div>


                        
						<div class="form-group"> <label class="col-sm-3  control-label">Principal</label>
							<div class="col-sm-7">
								<div class="input-group">
									<span class="input-group-addon"><?php echo $currency_symbol?></span>
									<input type="text" class="form-control money" id="txtprinagloan" name="txtprinagloan" value="" placeholder=""></div>
								</div>
							</div>
                           

                             
						<div class="form-group"> <label class="col-sm-3  control-label">Principal Limit</label>
							<div class="col-sm-7">
								<div class="input-group">
									<span class="input-group-addon"><?php echo $currency_symbol?></span>
									<input type="text" class="form-control money" id="txtlprinagloan" name="txtlprinagloan" value="" placeholder=""></div>
								</div>
							</div>

                            <div class="form-group"> <label class="col-sm-3  control-label">Term</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txttermagloan" name="txttermagloan" value="" placeholder="Please fill out the Terms"> </div>
						</div>

                         <div class="form-group"> <label class="col-sm-3  control-label">Moratorium</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtmoratagloan" name="txtmoratagloan" value="" placeholder="Please fill out the Terms"> </div>
						</div>


						<div id="<?php echo $exp_item; ?>" style="display: none">
                        <div class="form-group"> <label class="col-sm-3  control-label">Expenses</label>	
							<div class="col-sm-7"><select name="txtexpagloan" class="form-control" id="txtexpagloan">
					<option value=''>--- Select --</option>
					
					<?php 
					$sqlexpagloan = "select exp_name,exp_index  from `m_expenses`";
					$resexpagloan = mysqli_query($con, $sqlexpagloan);
					if(mysqli_num_rows($resexpagloan) > 0) {
						while($row = mysqli_fetch_object($resexpagloan)) {
							echo "<option value='".$row->exp_index."'>".$row->exp_name."</option>";
						}
					}
					?>
					
					</select>
				   </div>
					</div>
</div>					
					 <div class="form-group"> <label class="col-sm-3  control-label">Interest Rate</label>
							<div class="col-sm-7"><input type="number" class="form-control " id="txtirateagloan" name="txtirateagloan" value="" placeholder="Please fill out the Interest "> </div>
						</div>

                     <div class="form-group"> <label class="col-sm-3  control-label">Late Penalty</label>
							<div class="col-sm-7"><input type="number" class="form-control " id="txtlpenagloan" name="txtlpenagloan" value="" placeholder="Please fill out the Penalty"> </div>
						</div>


						<div class="form-group"> <label class="col-sm-3  control-label" >Auto Pay:</label>
							<div class="col-sm-7">
							
							<select name="txtapayagloan" class="form-control" id="txtapayagloan" >
					<option value=''>---- Select ---</option>
					<?php 

                    
					$autopaysqlagloan = "select * from (select 1 r, 'Yes' d union select 2, 'No') A";
					//$sql = "select * from `m_user` where wphone=".$walletno;
					$autopayresagloan = mysqli_query($con, $autopaysqlagloan);
					if(mysqli_num_rows($autopayresagloan) > 0) {
						while($row = mysqli_fetch_object($autopayresagloan)) {
							echo "<option value='".$row->r."'>".$row->d."</option>";
						}
					}
					?>
				    </select>
					</div>
					</div>

						

						<div class="form-group"> <label class="col-sm-3  control-label" >Pay Day:</label>
							<div class="col-sm-7">
							
							<select name="txtpaydayagloan" class="form-control" id="txtpaydayagloan" >
					<option value=''>---- Select ---</option>
					<?php 

                    
					$paydaysqlagloan = "select * from (select 1 x union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9 union select 10 union select 11 union select 12 union select 13 union select 14 union select 15 union select 16 union select 17 union select 18 union select 19 union select 20 union select 21 union select 22 union select 23 union select 24 union select 25 union select 26 union select 27 union select 28) A";
					//$sql = "select * from `m_user` where wphone=".$walletno;
					$paydayresagloan = mysqli_query($con, $paydaysqlagloan);
					if(mysqli_num_rows($paydayresagloan) > 0) {
						while($row = mysqli_fetch_object($paydayresagloan)) {
							echo "<option value='".$row->x."'>".$row->x."</option>";
						}
					}
					?>
				    </select>
					</div>
					</div>

                    <div class="form-group"> <label class="col-sm-3  control-label">Description</label>
								<div class="col-sm-7"><textarea class="form-control " rows="3" id="txtdescagloan" name="" placeholder="e.g a simple agro loan test"></textarea> </div>
							</div>


					 
						<div class="form-group"> <label class="col-sm-3  control-label" >Loan Issued to:</label>
							<div class="col-sm-7">
							
							<select name="bentxtmsisdnagloan" class="form-control" id="bentxtmsisdnagloan" >
					<option value=''>---- Select ---</option>
					<?php 

                    
					$bensqlagloan = "select concat(username,'-',wphone) as benwphoneagloan, wphone as benwphoneagloan_id from `m_user` where username not in('cellulant@cellulant.com','cellulant@cellulant.com.ng','naira@cellulant.com','naira@cellulant.com.ng','mula@cellulant.com','mula@cellulant.com.ng','dollar@cellulant.com','dollar@cellulant.com.ng')";
					//$sql = "select * from `m_user` where wphone=".$walletno;
					$benresagloan = mysqli_query($con, $bensqlagloan);
					if(mysqli_num_rows($benresagloan) > 0) {
						while($row = mysqli_fetch_object($benresagloan)) {
							echo "<option value='".$row->benwphoneagloan_id."'>".$row->benwphoneagloan."</option>";
						}
					}
					?>
				    </select>
					</div>
					</div>	
						<div class="form-group"> <label class="col-sm-3  control-label">Issued Address:</label>
						<div class="col-sm-7">
							<select name="bentxtaddressagloan" class="form-control" id="bentxtaddressagloan" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>
					 
					 
					

							<div class="form-group"> <label class="col-sm-1  control-label"></label>
								<div class="col-sm-11"><button type="submit" title="Save Button" class="btn btn-primary " id="btnsaveagloan" name=""><i class="fa fa-save"></i> Submit</button> <span id="infoprosesagloan"></span> </div>
							</div>
						</div>
					</div>
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
<!--agloan-->
</div>
<!--
//******************************************************************************
 //   Block Chain agloan Close
 //   *******************************************************************************/
 


//******************************************************************************
 //   Block Chain Redeem Produce Receipt Open
 //   *******************************************************************************/
-->


<div id="<?php echo $set_comm; ?>" style="display: none">
<section class="content">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title">Redeem Produce Receipt</h3>
		</div>
		<!--./ box header-->
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<button type="submit" class="btn btn-primary " id="btnaddrpr" name=""><i class="fa fa-plus"></i> Redeem a Receipt</button>
					<br>
				</div>
			</div>
			<div class="box-body table-responsive no-padding" style="max-width:1124px;">
				<table id="table_rpr" class="table  table-bordered table-hover ">
					<thead>
					<tr class="tableheader">
							<th style="width:40px">#</th>
							<th style="width:60px">Id</th>
							<th style="width:60px">Redemption Title</th>
							<th style="width:60px">Guaranteed Order</th>
							<th style="width:60px">Produce Receipt</th>
							<th style="width:60px">Redeemed Farmer</th>
							<th style="width:60px">Current Receipt Status:</th>
							<th></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>		
		</div>
	</div><!-- /.box -->

</section><!-- /.content -->


<div id="modalmasterrpr" class="modal fade ">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">Redeem Receipt Form</h4>
			</div>
			<!--modal header-->
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="box-body">
						<div class="form-group"> <label class="col-sm-3  control-label">Id</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtidrpr" name="txtidrpr" value="*New" placeholder="" disabled=""><input type="hidden" id="inputcrud" name="inputcrud" class="" value="N"> </div>
						</div>
						<div class="form-group"> <label class="col-sm-3  control-label">Redemption Title</label>
							<div class="col-sm-7"><input type="text" class="form-control " id="txtrprname" name="txtrprname" value="" placeholder="Please fill out Redemption Title"> </div>
						</div>
						
						
	<div class="form-group"> <label class="col-sm-3  control-label" >Farmer(Issued to) Wallet:</label>
							<div class="col-sm-7">
							
							<select name="txtmsisdnrpr" class="form-control" id="txtmsisdnrpr" >
					<option value=''>---- Select ---</option>
					<?php 

                    
					$sqlrpr = "SELECT concat(a.username,'-',a.wphone) as wphonerpr, a.wphone as wphonerpr_id 
					FROM m_user a, m_farmer b
					WHERE a.b_address = b.addressfar
					and b.transaction_type = 'addfarmer'
					and b.tran_status LIKE '%farmer-100-Success%'";
					//$sql = "select * from `m_user` where wphone=".$walletno;
					$resrpr = mysqli_query($con, $sqlrpr);
					if(mysqli_num_rows($resrpr) > 0) {
						while($row = mysqli_fetch_object($resrpr)) {
							echo "<option value='".$row->wphonerpr_id."'>".$row->wphonerpr."</option>";
						}
					}
					?>
				    </select>
					</div>
					</div>	
						<div class="form-group"> <label class="col-sm-3  control-label">Farmer(Issued to) Address</label>
						<div class="col-sm-7">
							<select name="txtaddressrpr" class="form-control" id="txtaddressrpr" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>

                       
						<div class="form-group"> <label class="col-sm-3  control-label">CCB Order Address</label>
						<div class="col-sm-7">
							<select name="txtoaddressrpr" class="form-control" id="txtoaddressrpr" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>
						
						<div class="form-group"> <label class="col-sm-3  control-label">Produce Receipt</label>
						<div class="col-sm-7">
							<select name="txtoreceiptrpr" class="form-control" id="txtoreceiptrpr" disabled="disabled"><option>------- Select --------</option></select>
						</div>
						</div>

						 <div class="form-group"> <label class="col-sm-3  control-label">Farmer(Issued to) Password</label>
							<div class="col-sm-7"><input type="password" class="form-control " id="txtpassrpr" name="txtpassrpr" value="" placeholder="Please fill out the Wallet Password"> </div>
						</div>
					
						
						
							<div class="form-group"> <label class="col-sm-1  control-label"></label>
								<div class="col-sm-11"><button type="submit" title="Save Button" class="btn btn-primary " id="btnsaverpr" name=""><i class="fa fa-save"></i> Submit</button> <span id="infoproses"></span> </div>
							</div>
						</div>
					</div>
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
<!--farmer-->
</div>

	<?php include "../layout/footer.php"; //footer template ?> 
	<?php include "../layout/bottom-footer.php"; //footer template ?> 
	<script src="j_item.js"></script>
	<script src="j_request.js"></script>
	<script src="j_loc.js"></script>
	<script src="j_cer.js"></script>
	<script src="j_off.js"></script>
	<script src="j_far.js"></script>
	<script src="j_pre.js"></script>
	<script src="j_cre.js"></script>
	<script src="j_cpr.js"></script>
	<script src="j_rpr.js"></script>
	<script src="j_cur.js"></script>
	<script src="j_mul.js"></script>
	<script src="j_gof.js"></script>
	<script src="j_got.js"></script>
	<script src="j_red.js"></script>
	<script src="j_rco.js"></script>
	<script src="j_exp.js"></script>
	<script src="j_agloan.js"></script>
	
	
</body>
</html>
