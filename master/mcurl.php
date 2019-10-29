<?php
// Arrays
$ch=array();
$url=array();
$result=array();
// ************
$loci ="Lagos";
$loci2 = 32;
$nameitem ="cocoa";
$terms = 10;
$unit ="kg";
$price = 100;
$wprice = 100;
$fprice = 100;

$url['1'] = 'https://www.agrikore.net/location/vw/{"'."op".'":"'.'getlocindex",'.'"name'.'":"'.$loci.'"}';
$url['2'] = 'https://www.agrikore.net/commodity/unsafe/ad/{"'."op".'":"'.'addcomm",'.'"admin'.'":"'.'0x2d2d8721fcacb58c7f5f2946bdcc487629da2d64",'.'"adminpwd'.'":"'.'agrikore",'.'"name'.'":"'.$nameitem.'",'.'"unit'.'":"'.$unit.'",'.'"price'.'":"'.$price.'",'.'"wareprice'.'":"'.$wprice.'",'.'"farmprice'.'":"'.$fprice.'",'.'"term'.'":"'.$terms.'",'.'"loc'.'":"'.$loci2.'"}';

$ch['1'] = curl_init($url['1']);
curl_setopt($ch['1'], CURLOPT_HEADER, true);
curl_setopt($ch['1'], CURLOPT_NOBODY, true);
curl_setopt($ch['1'], CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch['1'], CURLOPT_TIMEOUT, 10);
curl_setopt($ch['1'], CURLOPT_CUSTOMREQUEST, "GET");

echo $result['1'] = curl_exec($ch['1']);
echo "<br>";
curl_close($ch['1']);

$ch['2'] = curl_init($url['2']);
curl_setopt($ch['2'], CURLOPT_HEADER, true);
curl_setopt($ch['2'], CURLOPT_NOBODY, true);
curl_setopt($ch['2'], CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch['2'], CURLOPT_TIMEOUT, 10);
curl_setopt($ch['2'], CURLOPT_HTTPHEADER,array("x-access-token: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjViNjA2YjA0ZTI4NDlhMTJkOGQ0ZTAzNyIsImlhdCI6MTUzNDM1MDk3NywiZXhwIjoxNTM0MzU0NTc3fQ.sxn3E8gMbwtaHKnxNuKisZHJllGStLdILsaYIdiUwng"));

echo $result['2'] = curl_exec($ch['2']);
curl_close($ch['2']);


echo "<br>";
//echo $result['2'];
?>