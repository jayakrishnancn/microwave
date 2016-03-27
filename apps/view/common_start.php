<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?=$title?></title> 
	<link rel="stylesheet" href="<?= HTTPPATH.$config['css']?>bootstrap.min.css?v=1">
	<link rel="stylesheet" href="<?= HTTPPATH.$config['css']?>common.min.css?v=1">
	<link rel="stylesheet" href="<?= HTTPPATH.$config['apps-vendors-css']?>font-awesome/css/font-awesome.min.css?v=1">
</head>
<body id="js-test">
<div  id="no-js" class="no-js">
	<h1>Enable Javascript</h1>
	<p>This webpage requires Javascript .Please enable it to continue<a href="<?= HTTPPATH?>"><i class="fa fa-refresh"></i></a></p>	
</div>
<script>
	document.getElementById('no-js').style.display="none";
	document.getElementById('mw-container').style.display="block";
</script>
 <!-- no-js ends-->
<div id="mw-container" class="mw-container">
