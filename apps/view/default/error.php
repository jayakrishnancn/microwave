<?php 
if(empty($prim_color))
$prim_color='#d43f3a';?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $h;?></title>
	<style type="text/css">

#container {
	border: 1px solid <?= $prim_color;?>;
	-webkit-box-shadow:0 0 15px <?= $prim_color;?> ;
	-moz-box-shadow:0 0 15px <?= $prim_color;?> ;
	-ms-box-shadow:0 0 15px <?= $prim_color;?> ;
	-o-box-shadow:0 0 15px <?= $prim_color;?> ;
	box-shadow:0 0 15px <?= $prim_color;?> ;
	border-radius: 0  0 5px 5px;
}

p {
	margin: 12px 15px 12px 15px;
	color: #666;
	font-size: 15px;
    line-height: 30px;

}
h1 {
	color: #fff;
	background-color: <?= $prim_color;?>;
	border-bottom: 1px solid #cccccc;
	font-size: 20px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
    line-height: 30px;
}
a,.pre{
	color: <?= $prim_color;?>;
	text-decoration: underline;
	text-align: right;
	float: right;
	padding: 5px 15px;
	display: inline-block;
	cursor: pointer;
}
#center{
	width: 80%;
	max-width: 500px;
	margin: 3% auto 0 auto;
	font-size: 11px;
	font-family: sans-serif;
	text-transform: capitalize;
}
</style>
</head>
<body>
	<div id="center">
		<div id="container">
			<h1><?php echo $h;?></h1>
			<p><?php echo $msg;?></p> 
		</div>
		<a href="<?php echo HTTPPATH;?>">home</a>
		<div class='pre' style="float:left" onclick="history.go(-1);">Back</div>
	</div>
</body>
</html>