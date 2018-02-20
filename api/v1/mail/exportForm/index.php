<?php
include '../util.php';

//Constants
$to = "larsbenedetto@gmail.com";
//$to = "viptraders2@gmail.com";
$subject = "Import Request";
$LBtoKG = 0.453592;
$KGtoLB = 2.20462;
$ExchangeRate = getCurrentExchangeRate();

//Do some conversions. This should be handled client side
//But server load is expected to be extremely light and its easier to do it here instead

$weightUnit = $_REQUEST["v_weightUnit"];
if($weightUnit == "LB"){
	$weightL = $_REQUEST["v_gvwrfValue"];
	$weightK = $weightL * $LBtoKG;
}else{
	$weightK = $_REQUEST["v_gvwrfValue"];
	$weightL = $weightK * $KGtoLB;
}

$currency = $_REQUEST["v_currency"];
if($currency == "USD"){
	$valueU = $_REQUEST["v_gvwrfValue"];
	$valueC = $valueU * $ExchangeRate;
}else{
	$valueC = $_REQUEST["v_gvwrfValue"];
	$valueU = $valueC / $ExchangeRate;
}

$html = "
<html>
<head>
	<title>VIP Traders Export Form</title>
	<style>
		th {
			text-align: left;
		}
		tr:nth-child(even) {
			background-color: #eee;
		}
		tr:nth-child(odd) {
			background-color:#fff;
		}
	</style>
</head>
<body>
<h1>Import Request</h1>
<h2>Customer Name: " . $_REQUEST["c_name"] . "</h2>
<table>
	<tr><th>US Port of Crossing</th>                          <th>" . $_REQUEST["v_poc"] . "</th></tr>
	<tr><th>Approximate Crossing Date</th>                    <th>" . $_REQUEST["v_acd"] . "</th></tr>
	<tr><th>Mode of Transport</th>                            <th>" . $_REQUEST["v_mot"] . "</th></tr>
	<tr><th>Carrier or Transporter Name</th>                  <th>" . $_REQUEST["v_ctn"] . "</th></tr>
	<tr><th>Importing and Exporting companies are related</th><th>" . $_REQUEST["v_rel"] . "</th></tr>
	<tr><th>Hazardous merchandise on shipment</th>            <th>" . $_REQUEST["v_haz"] . "</th></tr>
</table>
<h3>United States Seller (Exporter)</h3>
	<table>
		<tr><th>Company Name</th>   <th>" . $_REQUEST["us_con"] . "</th></tr>
		<tr><th>Address</th>        <th>" . $_REQUEST["us_add"] . "</th></tr>
		<tr><th>City</th>           <th>" . $_REQUEST["us_cit"] . "</th></tr>
		<tr><th>State</th>          <th>" . $_REQUEST["us_sta"] . "</th></tr>
		<tr><th>Zip Code</th>       <th>" . $_REQUEST["us_zip"] . "</th></tr>
		<tr><th>Contact Name</th>   <th>" . $_REQUEST["us_cont"] . "</th></tr>
		<tr><th>Phone Number</th>   <th>" . $_REQUEST["us_pho"] . "</th></tr>
		<tr><th>EIN/FIN Number</th> <th>" . $_REQUEST["us_ein"] . "</th></tr>
		<tr><th>Passport Number</th><th>" . $_REQUEST["us_pass"] . "</th></tr>
	</table>
<h3>Canadian Buyer (Importer)</h3>
	<table>
		<tr><th>Company Name</th><th>" . $_REQUEST["c_con"] . "</th></tr>
		<tr><th>Contact Name</th><th>" . $_REQUEST["c_cona"] . "</th></tr>
		<tr><th>Address</th>     <th>" . $_REQUEST["c_add"] . "</th></tr>
		<tr><th>City</th>        <th>" . $_REQUEST["c_cit"] . "</th></tr>
		<tr><th>Postal</th>      <th>" . $_REQUEST["c_pos"] . "</th></tr>
	</table>
<h3>Vehicle Information</h3>
	<table>
		<tr><th>VIN</th>                    <th>" . $_REQUEST["v_vin"] . "</th></tr>
		<tr><th>Year</th>                   <th>" . $_REQUEST["v_year"] . "</th></tr>
		<tr><th>Make</th>                   <th>" . $_REQUEST["v_make"] . "</th></tr>
		<tr><th>Model</th>                  <th>" . $_REQUEST["v_model"] . "</th></tr>
		<tr><th>Manufacturer</th>           <th>" . $_REQUEST["v_manufacturer"] . "</th></tr>
		<tr><th>Vehicle Type</th>           <th>" . $_REQUEST["v_type"] . "</th></tr>
		<tr><th>Gas Type</th>               <th>" . $_REQUEST["v_gastype"] . "</th></tr>
		<tr><th>Weight (LB)</th>            <th>" . $weightL . "</th></tr>
		<tr><th>Weight (KG)</th>            <th>" . $weightK . "</th></tr>
		<tr><th>Value (USD)</th>            <th>" . $valueU . "</th></tr>
		<tr><th>Value (CAD)</th>            <th>" . $valueC . "</th></tr>
		<tr><th>Has Air Conditioning</th>   <th>" . ($_REQUEST["v_air"] == "on" ? "yes" : "no") . "</th></tr>
	</table>

<h3>Notes</h3>
	<p>" . $_REQUEST["notes"] . "</p>

</body>
</html>";
//Headers
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: <'. $_REQUEST["c_email"] . '>' . "\r\n";
//Send!
mail($to, $subject, $html, $headers);
echo $html;