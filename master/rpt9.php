<?php

$iditem = 1;
$nameitem = 'Vegetable Oil';
$loci = "Gumel";
$unit= "kg";
$stock = 3900000000000000000;
$terms = 90;
$price = 4700000000000000000;
$fprice = 4000000000000000000;


$b_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjViNzdlYTljMTlmODA1MTIyYzdhMDVlZCIsImlhdCI6MTUzNTcwMTY4MCwiZXhwIjoxNTM1Nzg4MDgwfQ.haUFpDNm3rVdVad2_JJII28CkCi0obLQVbk4z9gqG3w";

 
		$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://www.agrikore.net/location/vw/{%22op%22:%22getlocindex%22,%20%22name%22:%22$loci%22}",
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
			
			$response = curl_exec($curl);
			$err = curl_error($curl);
			
			//curl_close($curl);
			
			if ($err) {
			  echo "cURL Error #:" . $err;
			} else {
			  echo $response;
			  $loci2 = str_replace('"'," ",$response);
			}
            echo "<br> Reciept :".$loci2."<br>";

			  
			  

			 //$curl = curl_init();

			 curl_setopt_array($curl, array(
			   CURLOPT_URL => "https://www.agrikore.net/commodity/unsafe/ad/{%22op%22:%22addcomm%22,%22admin%22:%220x2d2d8721fcacb58c7f5f2946bdcc487629da2d64%22,%22adminpwd%22:%22agrikore%22,%22name%22:%22$nameitem%22,%22unit%22:%22$unit%22,%22price%22:%22$price%22,%22wareprice%22:%22$stock%22,%22farmprice%22:%22$fprice%22,%22term%22:%22$terms%22,%20%22loc%22:%22$loci2%22}",
			   CURLOPT_RETURNTRANSFER => true,
			   CURLOPT_ENCODING => "",
			   CURLOPT_MAXREDIRS => 10,
			   CURLOPT_TIMEOUT => 30,
			   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			   CURLOPT_CUSTOMREQUEST => "POST",
			   CURLOPT_HTTPHEADER => array(
				 "Cache-Control: no-cache",
				 "x-access-token: $b_token"
			   ),
			 ));
			 
			 $response2 = curl_exec($curl);
			 $err = curl_error($curl);
			 
			 curl_close($curl);
			 
			 if ($err) {
			   echo "cURL Error #:" . $err;
			 } else {
			   //echo $response2;
				echo $receipt2 = str_replace('"',"",$response2);
			  }
			 