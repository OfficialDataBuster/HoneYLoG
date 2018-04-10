<?php
$cf = ''; // CloudFlare; 'yes' or 'no'
if($cf == 'y'){
	$ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
}elseif($cf == 'yes'){
	$ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
}else{
	$ip = $_SERVER['REMOTE_ADDR'];
}
$gentime = date("h:i:s, d M. Y");
$time = date("h:i:s");
$fn = date("Y-m-d").'.log.txt';

$fp = fopen('./logs/'.$fn, 'a');
fwrite($fp, $ip.' || '.$time."\r\n");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $ip; ?> Pwned by Lulz</title>
		<meta name="robots" content="noindex"/>
		<meta name="googlebot" content="noindex"/>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta http-equiv="refresh" content="5;URL=https://google.com/search?q=how+do+I+kill+myself"/>
		<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
		<style>.bottomleft{position: fixed; bottom: 10px; left: 5px;}</style>
	</head>
	<body>
		<div style="text-align: center;">
			<h1><?php echo '<a style="color: rgb(255,0,0);" href="https://whatismyipaddress.com/ip/'.$ip.'">'.$ip.'</a>'; ?></h1>
			<pre><small>You just walked right into a honeypot. Oh, come on It's not so bad, we only saved your IP Address. Now GTFO before we actually harm you.
xx LulzAmp</small></pre>
		</div>
		<div class="bottomleft">
			<small><strong>Generated on:</strong> <?php echo $gentime; ?></small>
		</div>
	</body>
</html>