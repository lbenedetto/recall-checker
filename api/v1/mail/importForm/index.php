<?php
include '../util.php';
//Constants
//$to = "larsbenedetto@gmail.com";
$to = "viptraders2@gmail.com";
$subject = "Import Request";
$MtoKM = 1.60934;
$KMtoM = 0.621371;
$LBtoKG = 0.453592;
$KGtoLB = 2.20462;
$ExchangeRate = getCurrentExchangeRate();

//Do some conversions. This should be handled client side
//But server load is expected to be extremely light and its easier to do it here instead

$mileageUnit = $_REQUEST["v_mileageType"];
if($mileageUnit == "Miles"){
	$mileageM = $_REQUEST["v_gvwrValue"];
	$mileageK = $mileageM * $MtoKM;
}else{
	$mileageK = $_REQUEST["v_gvwrValue"];
	$mileageM = $mileageK * $KMtoM;
}

$weightUnit = $_REQUEST["v_weightUnit"];
if($weightUnit == "LB"){
	$weightL = $_REQUEST["v_gvwrfValue"];
	$weightK = $weightL * $LBtoKG;
}else{
	$weightK = $_REQUEST["v_gvwrfValue"];
	$weightL = $weightK * $KGtoLB;
}

$gvwrUnit = $_REQUEST["v_gvwrUnit"];
if($gvwrUnit == "LB"){
	$gvwrL = $_REQUEST["v_gvwrValue"];
	$gvwrK = $gvwrL * $LBtoKG;
}else{
	$gvwrK = $_REQUEST["v_gvwrValue"];
	$gvwrL = $gvwrK * $KGtoLB;
}

$gvwrfUnit = $_REQUEST["v_gvwrfUnit"];
if($gvwrfUnit == "LB"){
	$gvwrfL = $_REQUEST["v_gvwrfValue"];
	$gvwrfK = $gvwrfL * $LBtoKG;
}else{
	$gvwrfK = $_REQUEST["v_gvwrfValue"];
	$gvwrfL = $gvwrfK * $KGtoLB;
}

$gvwrrUnit = $_REQUEST["v_gvwrrUnit"];
if($gvwrrUnit == "LB"){
	$gvwrrL = $_REQUEST["v_gvwrfValue"];
	$gvwrrK = $gvwrrL * $LBtoKG;
}else{
	$gvwrrK = $_REQUEST["v_gvwrfValue"];
	$gvwrrL = $gvwrrK * $KGtoLB;
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
	<title>VIP Traders Import Form</title>
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

<h3>Vehicle Information</h3>
	<table>
		<tr><th>VIN</th>                    <th>" . $_REQUEST["v_vin"] . "</th></tr>
		<tr><th>Year</th>                   <th>" . $_REQUEST["v_year"] . "</th></tr>
		<tr><th>Make</th>                   <th>" . $_REQUEST["v_make"] . "</th></tr>
		<tr><th>Model</th>                  <th>" . $_REQUEST["v_model"] . "</th></tr>
		<tr><th>Manufacturer</th>           <th>" . $_REQUEST["v_manufacturer"] . "</th></tr>
		<tr><th>Vehicle Type</th>           <th>" . $_REQUEST["v_type"] . "</th></tr>
		<tr><th>Mileage (Miles)</th>        <th>" . $mileageM . "</th></tr>
		<tr><th>Mileage (Kilometers)</th>   <th>" . $mileageK . "</th></tr>
		<tr><th>Build Date</th>             <th>" . $_REQUEST["v_buildDate"] . "</th></tr>
		<tr><th>Color</th>                  <th>" . $_REQUEST["v_color"] . "</th></tr>
		<tr><th>Weight (LB)</th>            <th>" . $weightL . "</th></tr>
		<tr><th>Weight (KG)</th>            <th>" . $weightK . "</th></tr>
		<tr><th>GVWR (LB)</th>              <th>" . $gvwrL . "</th></tr>
		<tr><th>GVWR Front (LB)</th>        <th>" . $gvwrfL . "</th></tr>
		<tr><th>GVWR Rear (LB)</th>         <th>" . $gvwrrL . "</th></tr>
		<tr><th>GVWR (KG)</th>              <th>" . $gvwrK . "</th></tr>
		<tr><th>GVWR Front (KG)</th>        <th>" . $gvwrfK . "</th></tr>
		<tr><th>GVWR Rear (KG)</th>         <th>" . $gvwrrK . "</th></tr>
		<tr><th>Engine Displacement</th>    <th>" . $_REQUEST["v_engineDisplacement"] . "</th></tr>
		<tr><th>Engine Size</th>            <th>" . $_REQUEST["v_engineSize"] . "</th></tr>
		<tr><th>Value (USD)</th>            <th>" . $valueU . "</th></tr>
		<tr><th>Value (CAD)</th>            <th>" . $valueC . "</th></tr>
		<tr><th>EPA Label</th>              <th>" . ($_REQUEST["v_epa"] == "on" ? "yes" : "no") . "</th></tr>
		<tr><th>Requested Title</th>        <th>" . ($_REQUEST["v_title"] == "on" ? "yes" : "no") . "</th></tr>
	</table>
<h3>Tire Information</h3>
	<table>
		<tr><th>Front Tire Size</th>            <th>" . $_REQUEST["t_fs"] . "</th></tr>
		<tr><th>Rear Tire Size</th>             <th>" . $_REQUEST["t_rs"] . "</th></tr>
		<tr><th>Front Rims</th>                 <th>" . $_REQUEST["t_fr"] . "</th></tr>
		<tr><th>Rear Rims</th>                  <th>" . $_REQUEST["t_rr"] . "</th></tr>
		<tr><th>Front Cold Tire Inflation</th>  <th>" . $_REQUEST["t_fci"] . "</th></tr>
		<tr><th>Rear Cold Tire Inflation</th>   <th>" . $_REQUEST["t_rci"] . "</th></tr>
	</table>
<h3>Optional Services</h3>
	<table>
		<tr><th>Windshield</th>     <th>" . ($_REQUEST["v_windshield"] == "on" ? "yes" : "no") . "</th></tr>
		<tr><th>Bedliner</th>       <th>" . ($_REQUEST["v_bedliner"] == "on" ? "yes" : "no") . "</th></tr>
		<tr><th>Bedliner Size</th>  <th>" . $_REQUEST["v_size"] . "</th></tr>
		<tr><th>Seat Repair</th>    <th>" . ($_REQUEST["v_seat"] == "on" ? "yes" : "no") . "</th></tr>
	</table>
<h3>Canadian Address</h3>
	<table>
	<tr><th>Address</th>    <th>" . $_REQUEST["c_address"] . "</th></tr>
	<tr><th>City</th>       <th>" . $_REQUEST["c_city"] . "</th></tr>
	<tr><th>Phone</th>      <th>" . $_REQUEST["c_phone"] . "</th></tr>
	</table>
<h3>United States Address</h3>
	<table>
	<tr><th>Address</th>    <th>" . $_REQUEST["u_address"] . "</th></tr>
	<tr><th>City</th>       <th>" . $_REQUEST["u_city"] . "</th></tr>
	<tr><th>Phone</th>      <th>" . $_REQUEST["u_phone"] . "</th></tr>
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