<!--<!DOCTYPE html>
[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

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
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Bootstrap-Themed Tree Widget Documentation</title>
	<meta name="description" content="Applied Internet Technologies timekeeping software">
	<meta name="author" content="Applied Internet Technologies: Jeromy French">
	<meta http-equiv="expires" content="Fri, 21 Jun 2013 20:24:32 GMT" />
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="bootstrap-combined.min.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
	<script src="js/bootstrap-tree.js"></script>
</head>
<body class="container-fluid" style="">
	
	<div class="row-fluid">
			<h2 id="demo2">Agrikore BlockChain</h2>
			<div class="tree">
			    <ul>
					
			        <li>
			            <span><i class="icon-calendar"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><font color=brown>Reserve</font></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
			            <ul>
								<li>
										<span class="badge badge-important"><i class="icon-minus-sign"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ADMINISTRATOR-INFORMATION&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										<ul>
											<li>
												<a href="index_dash.php"><span><i class="icon-time"></i> DASHBOARD</span> &ndash; </a> <a href="index_currency.php" ?>'<span><i class="icon-time"></i> Block Information</span> </a> 
											</li>
											
										</ul>
									</li>
								







			                <li>
			                	<span class="badge badge-success"><i class="icon-minus-sign"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fund reserve&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
			                    <ul>
			                        <li>
									<a href='../master/v_item.php?id=<?php echo "naira" ?>'  <span><i class="icon-time"></i> Naira Deposit</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "dollar" ?>'<span><i class="icon-time"></i> Dollar Deposit</span> &ndash; </a> <a href=""><span><i class="icon-time"></i> Other Currency Deposit</span></a>
									</li>
									
			                    </ul>
							</li>
							<li>
			                	<span class="badge badge-info"><i class="icon-minus-sign"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mint Mula)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
			                    <ul>
			                        <li>
				                        <a href='../master/v_item.php?id=<?php echo "setbuymulanaira" ?>'><span><i class="icon-time"></i> Set Minting Rate(Naira)</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "setbuymuladollar" ?>'><span><i class="icon-time"></i> Set Minting Rate(Dollar)</span> &ndash; </a><a href='../master/v_item.php?id=<?php echo "buymulanaira" ?>'><span><i class="icon-time"></i> Mint Mula from Naira</span>&ndash; </a> <a href='../master/v_item.php?id=<?php echo "buymuladollar" ?>'><span><i class="icon-time"></i> Mint Mula from Dollar</span></a>
									</li>
									
			                    </ul>
							</li>
							<li>
			                	<span class="badge badge-warning"><i class="icon-minus-sign"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Liquidate Mula&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
			                    <ul>
			                        <li>
									<a href='../master/v_item.php?id=<?php echo "setsellmulanaira" ?>'><span><i class="icon-time"></i> Set Liquidate Mula Rate(Naira)</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "setsellmuladollar" ?>'><span><i class="icon-time"></i> Set Liquidate Mula Rate(Dollar)</span> &ndash;</a>    <a href='../master/v_item.php?id=<?php echo "sellmulanaira" ?>'><span><i class="icon-time"></i> Liquidate Mula(Naira)</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "sellmuladollar" ?>'><span><i class="icon-time"></i> Liquidate Mula(Dollar)</span> </a> 
									</li>
									
			                    </ul>
							</li>
							<li>
			                	<span class="badge badge-dark"><i class="icon-minus-sign"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Withdraw &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
			                    <ul>
			                        <li>
				                        <a href='../master/v_item.php?id=<?php echo "cashoutnaira" ?>'><span><i class="icon-time"></i> Withdraw(Naira)</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "cashoutdollar" ?>'><span><i class="icon-time"></i> Withdraw(Dollar)</span> </a> 
									</li>
									
			                    </ul>
							</li>
							
			              
			            </ul>
					</li>
					

						
					<li>
							<span><i class="icon-calendar"></i> <b><font color="#141470">Marketplace Smart Contracts</font></b></span>
							<ul>

							<li>
									<span class="badge badge-important"><i class="icon-minus-sign"></i> Agrikore Operator Role</span>
									<ul>
											<li>
													<a href='../master/v_item.php?id=<?php echo "operatorrole" ?>'><span><i class="icon-time"></i> Add Operator</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "gorder" ?>'><span><i class="icon-time"></i> Activate/Operate a Buyer Contract</span>  </a> 
											</li>
										
									</ul>
								</li>

							<li>
									<span class="badge badge-success"><i class="icon-minus-sign"></i> Agrikore Generic Role</span>
									<ul>
											<li>
													<a href='../master/v_item.php?id=<?php echo "genericrt" ?>'><span><i class="icon-time"></i> Add Generic Role Type</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "genericrole" ?>'><span><i class="icon-time"></i> Add Generic Contract</span>  &ndash; </a> <a href='../master/v_item.php?id=<?php echo "generictocontract" ?>'><span><i class="icon-time"></i> Activate Generic Contract</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "removegenericgo" ?>'><span><i class="icon-time"></i> De-Activate Generic Contract</span> </a>
											</li>
										
									</ul>
								</li>
							
								<li>
									<span class="badge badge-important"><i class="icon-minus-sign"></i> Corporate Buyer</span>
									<ul>
											<li>
													<a href='../master/v_item.php?id=<?php echo "buyerrole" ?>'><span><i class="icon-time"></i> Add Buyer Role</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "gorder" ?>'><span><i class="icon-time"></i> Activate a Buyer Contract</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "mingordertransfer" ?>'><span><i class="icon-time"></i> Minimum Contract Value</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "maxgordertransfer" ?>'><span><i class="icon-time"></i> Maximum Contract value</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "confirmdelivery" ?>'><span><i class="icon-time"></i> Confirm Produce Delivery</span> </a> 
											</li>
										
									</ul>
								</li>
								<li>
									<span class="badge badge-ash"><i class="icon-minus-sign"></i> Agriculture Loan</span>
									<ul>
											<li>
													<a href='../master/v_item.php?id=<?php echo "loanerrole" ?>'><span><i class="icon-time"></i> Add Loaner Role</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "agloan" ?>'><span><i class="icon-time"></i> Activate a Loaner Contract</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "minagloantransfer" ?>'><span><i class="icon-time"></i> Minimum Loan Value</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "maxagloantransfer" ?>'><span><i class="icon-time"></i> Maximum Loan value</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "addloandisburseln" ?>'><span><i class="icon-time"></i> Disburse loan</span> </a> 
											</li>
										
									</ul>
								</li>

                                   <li>
									<span class="badge badge-success"><i class="icon-minus-sign"></i> General Purpose Mula Loan</span>
									<ul>
											<li>
													<a href='../master/v_item.php?id=<?php echo "loanerrole" ?>'><span><i class="icon-time"></i> Add Loaner Role</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "muloan" ?>'><span><i class="icon-time"></i> Activate a Mula Loaner Contract</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "minmuloantransfer" ?>'><span><i class="icon-time"></i> Minimum Mula Loan Value</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "maxmuloantransfer" ?>'><span><i class="icon-time"></i> Maximum Mula Loan value</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "addloandisbursemuln" ?>'><span><i class="icon-time"></i> Disburse Muloan</span> </a> 
											</li>
										
									</ul>
								</li>


								<li>
									<span class="badge badge-info"><i class="icon-minus-sign"></i> Cellulant Contract</span>
									<ul>
											<li>
													<a href='../master/v_item.php?id=<?php echo "cellulantcontract" ?>' ><span><i class="icon-time"></i> Add Cellulant Contract</span></a>  
												</li>
										
									</ul>
								</li>
								<li>
									<span class="badge badge-warning"><i class="icon-minus-sign"></i> Primary aggregation site operators (PASO)</span>
									<ul>
											<li>
													<a href='../master/v_item.php?id=<?php echo "offtakerrole" ?>'><span><i class="icon-time"></i> Add Offtaker Contract </span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "addofftakergo" ?>'><span><i class="icon-time"></i> Activate Offtaker Contract</span> &ndash;</a><a href='../master/v_item.php?id=<?php echo "removeofftakergo" ?>'><span><i class="icon-time"></i> De-activate/Remove Offtaker Contract</span> &ndash;</a><a href='../master/v_item.php?id=<?php echo "issuereceipt" ?>'><span><i class="icon-time"></i> Offtaker/Farmer Reciept Contract</span> </a> 
												</li>
										
									</ul>
								</li>
								
								<li>
										<span class="badge badge-warning"><i class="icon-minus-sign"></i> Produce Certifier</span>
										<ul>
											<li>
												<a href='../master/v_item.php?id=<?php echo "certifierrole" ?>'><span><i class="icon-time"></i> Add a Certifier</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "certifyproduce" ?>'><span><i class="icon-time"></i>Activate Contract/Certify</span> </a> 
											</li>
								</ul>
								</li>

								<li>
										<span class="badge badge-important"><i class="icon-minus-sign"></i> Farmer</span>
										<ul>
											<li>
												<a href='../master/v_item.php?id=<?php echo "farmerrole" ?>'><span><i class="icon-time"></i> Add Farmer Contract</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "redeemreceipt" ?>'><span><i class="icon-time"></i> Activate a Contract\Receipt</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "payloanln" ?>'><span><i class="icon-time"></i> Pay Loan </span>&ndash; </a> <a href='../master/v_item.php?id=<?php echo "spendloanln" ?>'><span><i class="icon-time"></i> Spend Loan </span></a> 
											</li>
									</ul>
									</li>
									<li>
										<span class="badge badge-success"><i class="icon-minus-sign"></i> Logistics partner</span>
										<ul>
											<li>
												<a href='../master/v_item.php?id=<?php echo "logisticsrole" ?>'><span><i class="icon-time"></i> Add Logistics Contact</span> &ndash; </a> <a href=""><span><i class="icon-time"></i> Activates Logistics Contract</span> </a> 
											</li>
									</ul>
									</li>
									<li>
										<span class="badge badge-dark"><i class="icon-minus-sign"></i> Supplier</span>
										<ul>
											<li>
												<a href='../master/v_item.php?id=<?php echo "dealerrole" ?>'><span><i class="icon-time"></i> Activate Supplier Role</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "adddealerexpitem" ?>'><span><i class="icon-time"></i> Add Dealer Expense</span>&ndash; </a> <a href='../master/v_item.php?id=<?php echo "dealerredeemloan" ?>'><span><i class="icon-time"></i> Redeem farmer Loan</span> </a> 
											</li>
									</ul>
									</li>
									<li>
										<span class="badge badge-info"><i class="icon-minus-sign"></i> Neighborhood Banker</span>
										<ul>
											<li>
												<a href=""><span><i class="icon-time"></i> Activate Banker Role</span> &ndash; </a> <a href=""><span><i class="icon-time"></i> Create a Contract</span> </a> 
											</li>
									</ul>
									</li>
									
									<li>
										<span class="badge badge-success"><i class="icon-minus-sign"></i> Financial service provider 	</span>
										<ul>
											<li>
												<a href=""><span><i class="icon-time"></i> Activate Financial service provider Role</span> &ndash; </a> <a href=""><span><i class="icon-time"></i> Create a Contract</span> </a> 
											</li>
									</ul>
									</li>
									
									<li>
										<span class="badge badge-warning"><i class="icon-minus-sign"></i> Insurance Company	</span>
										<ul>
											<li>
												<a href='../master/v_item.php?id=<?php echo "insurerrole" ?>'><span><i class="icon-time"></i> Create a Contract  </span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "insurertocontract" ?>'><span><i class="icon-time"></i> Activate Insurance provider Contract</span> </a> 
											</li>
									</ul>
									</li>
									
									<li>
										<span class="badge badge-important"><i class="icon-minus-sign"></i> Government</span>
										<ul>
											<li>
												<a href=""><span><i class="icon-time"></i> Activate Government Role</span> &ndash; </a> <a href=""><span><i class="icon-time"></i> Create a Contract</span> </a> 
											</li>
									</ul>
									</li>
									
									<li>
										<span class="badge badge-warning"><i class="icon-minus-sign"></i> Donor</span>
										<ul>
											<li>
												<a href=""><span><i class="icon-time"></i> Activate Donor Role</span> &ndash; </a> <a href=""><span><i class="icon-time"></i> Create a Contract</span> </a> 
											</li>
									</ul>
									</li>
									
									<li>
										<span class="badge badge-success"><i class="icon-minus-sign"></i> Development Partner</span>
										<ul>
											<li>
												<a href=""><span><i class="icon-time"></i> Activate Development Partner Role</span> &ndash; </a> <a href=""><span><i class="icon-time"></i> Create a Contract</span> </a> 
											</li>
									</ul>
									</li>
									
								
							  
							</ul>
						</li>





			        <li>
							<span><i class="icon-calendar"></i> <b><font color="#5f912f"> Smart contracts Administration</font></b></span>
							<ul>
								
								<li>
									<span class="badge badge-important"><i class="icon-minus-sign"></i> Buyer Contract Administration</span>
									<ul>
											<li>
													<a href='../master/v_item.php?id=<?php echo "approvego" ?>'><span><i class="icon-time"></i> Sign/Approve</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "revokego" ?>'><span><i class="icon-time"></i> Revoke</span> &ndash;</a> <a href='../master/v_item.php?id=<?php echo "expirego" ?>'><span><i class="icon-time"></i> Exipire</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "expirenrfgo" ?>'><span><i class="icon-time"></i> Expire and Refund </span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "suspendgo" ?>'><span><i class="icon-time"></i> Suspend</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "unsuspendgo" ?>'><span><i class="icon-time"></i> UnSuspend </span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "addfundgo" ?>'><span><i class="icon-time"></i> Re-Finance/Add-fund </span> </a>
											</li>
										
									</ul>
								</li>

								<li>
									<span class="badge badge-info"><i class="icon-minus-sign"></i> AgroLoan Contract Administration</span>
									<ul>
											<li>
													<a href='../master/v_item.php?id=<?php echo "approveln" ?>'><span><i class="icon-time"></i> Sign/Approve Loan</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "revokeln" ?>'><span><i class="icon-time"></i> Revoke Loan</span> &ndash;</a> <a href="expireln"><span><i class="icon-time"></i> Exipire a Loan</span> &ndash; </a> <a href="addloandisburse"><span><i class="icon-time"></i> Disburse Loan </span> &ndash; </a> <a href="suspendln"><span><i class="icon-time"></i> Suspend</span> &ndash; </a> <a href="unsuspendloan"><span><i class="icon-time"></i> UnSuspend </span> </a>
											</li>
										
									</ul>
								</li>

								<li>
									<span class="badge badge-red"><i class="icon-minus-sign"></i> Mula Loan Contract Administration</span>
									<ul>
											<li>
													<a href='../master/v_item.php?id=<?php echo "approvemuln" ?>'><span><i class="icon-time"></i> Sign/Approve Loan</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "revokemuln" ?>'><span><i class="icon-time"></i> Revoke Mula Loan</span> &ndash;</a> <a href="expiremuln"><span><i class="icon-time"></i> Exipire a Mula Loan</span> &ndash; </a> <a href="addmuloandisburse"><span><i class="icon-time"></i> Disburse Mula Loan </span> &ndash; </a> <a href="suspendmuln"><span><i class="icon-time"></i> Suspend</span> &ndash; </a> <a href="unsuspendmuloan"><span><i class="icon-time"></i> UnSuspend </span> </a>
											</li>
										
									</ul>
								</li>
																
							</ul>
						</li>






			        <li>
							<span><i class="icon-calendar"></i> <b><font color="#4286f4"> Locations, Commodties and Expenses</font></b></span>
							<ul>
								
								<li>
									<span class="badge badge-info"><i class="icon-minus-sign"></i> Locations</span>
									<ul>
											<li>
													<a href='../master/v_item.php?id=<?php echo "addlocation" ?>'><span><i class="icon-time"></i> Add New Commodity Location</span> &ndash; </a> 
											</li>
										
									</ul>
								</li>

								<li>
									<span class="badge badge-important"><i class="icon-minus-sign"></i> Commodities</span>
									<ul>
											<li>
													<a href='../master/v_item.php?id=<?php echo "addcommodity" ?>'><span><i class="icon-time"></i> Add Commodity</span>  </a> 
											</li>
										
									</ul>
								</li>

								<li>
									<span class="badge badge-important"><i class="icon-minus-sign"></i> Expenses</span>
									<ul>
											<li>
													<a href='../master/v_item.php?id=<?php echo "addexpenses" ?>'><span><i class="icon-time"></i> Add Expenses</span> &ndash; </a> 
											</li>
										
									</ul>
								</li>
																
							</ul>
						</li>
			



							
							<li>
								<span><i class="icon-calendar"></i> <b><font color="#eb42f4">Standard Settings</font></b></span>
								<ul>
										<li>
												<span class="badge badge-info"><i class="icon-minus-sign"></i> Mula Currency Settings</span>
												<ul>
														<li>
																<a href='../master/v_item.php?id=<?php echo "minmulatransfer" ?>'><span><i class="icon-time"></i> Minimum Mula Transfer</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "maxmulatransfer" ?>'><span><i class="icon-time"></i> Maximum Mula Transfer</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "mulatransferfeefx" ?>'><span><i class="icon-time"></i> Mula Transfer fee(fixed value)</span> &ndash; </a>  <a href='../master/v_item.php?id=<?php echo "mulatransferfeept" ?>'><span><i class="icon-time"></i> Mula Transfer fee(%age Val.)</span> &ndash; </a><a href='../master/v_item.php?id=<?php echo "automulaaccount" ?>'><span><i class="icon-time"></i> Allow Automatic Mula Accout Enrollment</span> &ndash; </a><a href='../master/v_item.php?id=<?php echo "disableautomulaaccount" ?>'><span><i class="icon-time"></i> Disallow Mula Accout Enrollment</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "manualmulaaccount" ?>'><span><i class="icon-time"></i> Manual make Account hold Mula</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "manualremovemulaaccount" ?>'><span><i class="icon-time"></i> Manual Remove Account to hold Mula</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "allowaccountbuymulanaira" ?>'><span><i class="icon-time"></i> Enable :Accounts buy Mula(with Naira)</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "disableaccountbuymulanaira" ?>'><span><i class="icon-time"></i> Disable :Account buy Mula(with Naira)</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "allowaccountbuymuladollar" ?>'><span><i class="icon-time"></i> Enable :Accounts buy Mula(with Dollar)</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "disableaccountbuymuladollar" ?>'><span><i class="icon-time"></i> Disable :Account buy Mula(with Dollar)</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "commaddrmula" ?>'><span><i class="icon-time"></i> Commission Account Mula</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "setcommpermula" ?>'><span><i class="icon-time"></i> Percentage Commission (Mula)</span> </a> 
														</li>
													
												</ul>
											</li>

											<li>
										<span class="badge badge-success"><i class="icon-minus-sign"></i> Mula(B) Currency Settings</span>
										<ul>
												<li>
														<a href='../master/v_item.php?id=<?php echo "setbuymulab" ?>'><span><i class="icon-time"></i> Set Mula(B) Minting Rate</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "setsellmulab" ?>'><span><i class="icon-time"></i> Set Mula(B) Liquidate Rate</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "mingordertransfer" ?>'><span><i class="icon-time"></i> Minimum Mula(B) Transfer</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "maxgordertransfer" ?>'><span><i class="icon-time"></i> Maximum Mula(B) Transfer</span> </a> 
												</li>
											
										</ul>
									</li>

									<li>
										<span class="badge badge-dark"><i class="icon-minus-sign"></i> Mula(C) Currency Settings</span>
										<ul>
												<li>
														<a href='../master/v_item.php?id=<?php echo "setbuymulac" ?>'><span><i class="icon-time"></i> Set Mula(C) Minting Rate</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "setsellmulac" ?>'><span><i class="icon-time"></i> Set Mula(C) Liquidate Rate</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "minagloantransfer" ?>'><span><i class="icon-time"></i> Minimum Mula(C) Transfer</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "maxagloantransfer" ?>'><span><i class="icon-time"></i> Maximum Mula(C) Transfer</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "commaddragloan" ?>'><span><i class="icon-time"></i> Commission Account Mula(C)</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "setcommpermulac" ?>'><span><i class="icon-time"></i> Percentage Commission (Mula(C))</span> </a> 
												</li>
											
										</ul>
									</li>


									<li>
										<span class="badge badge-important"><i class="icon-minus-sign"></i> Naira Currency Settings</span>
										<ul>
												<li>
														<a href='../master/v_item.php?id=<?php echo "minnairatransfer" ?>'><span><i class="icon-time"></i> Minimum Naira Transfer</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "maxnairatransfer" ?>'><span><i class="icon-time"></i> Maximum Naira Transfer</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "nairatransferfeefx" ?>'><span><i class="icon-time"></i> Naira Transfer fee(Fixed Value)</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "nairatransferfeept" ?>'><span><i class="icon-time"></i> Naira Transfer fee(%age Value Moved)</span> &ndash; </a><a href='../master/v_item.php?id=<?php echo "commaddrnaira" ?>'><span><i class="icon-time"></i> Commission Account Naira</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "setcommpernaira" ?>'><span><i class="icon-time"></i> Percentage Commission (Naira)</span> </a> 
												</li>
											
										</ul>
									</li>
									<li>
											<span class="badge badge-success"><i class="icon-minus-sign"></i> Dollar Account Settings</span>
											<ul>
													<li>
															<a href='../master/v_item.php?id=<?php echo "mindollartransfer" ?>'><span><i class="icon-time"></i> Minimum Dollar Transfer</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "maxdollartransfer" ?>'><span><i class="icon-time"></i> Maximum Dollar Transfer</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "dollartransferfeefx" ?>'><span><i class="icon-time"></i> Dollar Transfer fee(Fixed Value)</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "dollartransferfeept" ?>'><span><i class="icon-time"></i> Dollar Transfer fee(%age Value moved)</span> &ndash; </a><a href='../master/v_item.php?id=<?php echo "commaddrdollar" ?>'><span><i class="icon-time"></i> Commission Account Dollar</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "setcommperdollar" ?>'><span><i class="icon-time"></i> Percentage Commission (Dollar)</span> </a> 
													</li>
												
											</ul>
										</li>
									
											<li>
													<span class="badge badge-light"><i class="icon-minus-sign"></i> Commercial Settings</span>
													<ul>
															<li>
																	<a href=""><span><i class="icon-time"></i> Commission Account</span> &ndash; </a> <a href=""><span><i class="icon-time"></i> Commission Percentage</span> &ndash; </a> <a href=""><span><i class="icon-time"></i> Redemption Commission Percentage</span> &ndash; </a> <a href=""><span><i class="icon-time"></i> Percentage Commission Share of Transaction fee</span> </a> 
															</li>
														
													</ul>
												</li>
											
								  
								</ul>
							</li>







							<li>
									<span><i class="icon-calendar"></i> <b><font color="#234c3d">Transactions-UXP Settings</font></b></span>
									<ul>
										<li>
											<span class="badge badge-important"><i class="icon-minus-sign"></i> Funding</span>
											<ul>
													<li>
															<a href=""><span><i class="icon-time"></i> Fund Wallet</span> &ndash; </a> <a href=""><span><i class="icon-time"></i> Cash-out</span> </a> 
													</li>
												
											</ul>
										</li>
										
										<li>
												<span class="badge badge-dark"><i class="icon-minus-sign"></i> Transfers(P2P)</span>
												<ul>
													<li>
														<a href=""><span><i class="icon-time"></i> Mula Transfer</span> &ndash; </a> <a href=""><span><i class="icon-time"></i> Naira Transfer</span> &ndash; </a> <a href=""><span><i class="icon-time"></i> Dollar Transfer</span></a>
													</li>
													
												</ul>
											</li>
											<li>
													<span class="badge badge-info"><i class="icon-minus-sign"></i> Transfers(R2P)</span>
													<ul>
														<li>
															<a href='../master/v_item.php?id=<?php echo "r2pmula" ?>'><span><i class="icon-time"></i> From:Reserve Mula Transfer</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "r2pnaira" ?>'><span><i class="icon-time"></i> From:Reserve Naira Transfer</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "r2pdollar" ?>'><span><i class="icon-time"></i> From:Reserve Dollar Transfer</span></a>
														</li>
														
													</ul>
												</li>
												<li>
														<span class="badge badge-success"><i class="icon-minus-sign"></i> Transfers(P2R)</span>
														<ul>
															<li>
															<a href='../master/v_item.php?id=<?php echo "p2rmula" ?>'><span><i class="icon-time"></i> To:Reserve Mula Transfer</span> &ndash; </a> <a href='../master/v_item.php?id=<?php echo "p2rnaira" ?>'><span><i class="icon-time"></i> To:Reserve Naira Transfer</span> &ndash; </a> <a href=""><span><i class="icon-time"></i> To:Reserve Dollar Transfer</span></a>
															</li>
															
														</ul>
													</li>
													<li>
															<span class="badge badge-important"><i class="icon-minus-sign"></i> Other Transfers</span>
															<ul>
																<li>
																	<a href=""><span><i class="icon-time"></i> Expenses</span> &ndash; </a> <a href=""><span><i class="icon-time"></i> Receipt Redemption</span></a> 
																</li>
																
															</ul>
														</li>
										
									  
									</ul>
								</li>

							
				</ul>
				
			</div>
		</section>
	
	</div>
	<footer role="contentinfo" class="row-fluid visible-desktop">
		<div class="span4">
			All Rights Reserved <a href="http://stackexchange.com/legal#3SubscriberContent">Cellulant Nigeria Limited</a>.
		</div>
		<div class="span4">
		<noscript>
			This application provides the optimal experience when JavaScript is enabled.
		</noscript>
		</div>
		<div class="span4 pull-right">
			Version 1.0.0 
		</div>
	</footer>

</body>
</html>
