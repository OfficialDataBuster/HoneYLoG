<?php
if(isset($_GET['sess_destroy'])){
	if($_GET['sess_destroy'] == 'y'){
		session_start();
		session_destroy();
		header('Location: ./honeylog.php');
		exit;
	}
}

function signIn($user, $pass){
	$users = array(
		'root' => '$2y$10$7jMzA4Ju0Aiq1QjJ5y9rleLr.KvfDWWiN4EKaCyCybCLIzNMI/oMm', // remove this account to improve security (root:toor)
		'username' => 'password, hashed using password_hash("string", PASSWORD_BCRYPT)' // check this out.
	);
	if(array_key_exists($user, $users)){
		if(password_verify($pass, $users[$user])){
			session_start();
			$_SESSION['logged_in'] = true;
			header('Refresh: 1');
			exit;
		}else{
			die('Wrong username or password. Fuck outta here.');
		}
	}else{
		die('Wrong username or password. Fuck outta here.');
	}
}
function dateToFilename($date){
	$out = './logs/'.$date.'.log.txt';
	return $out;
}
function deleteLogs($date){
	$file = dateToFilename($date);
	if(file_exists($file)){
		unlink($file);
		$out = 'Successfully deleted Logs from '.$date;
	}else{
		$out = 'There are no logs from '.$date;
	}
	return $out;
}
function editLogs($date, $input){
	$file = dateToFilename($date);
	$input = $input."\r\n";
	if(file_exists($file)){
		deleteLogs($date);
		$fp = fopen($file, 'a');
		if(fwrite($fp, $input)){
			fclose($fp);
			$fp = fopen($file, 'r');
			$out = fread($fp, filesize($file));
		}else{
			$out = 'Couldn\'t edit Logs from '.$date;
		}
		fclose($fp);
	}else{
		$out = 'There are no logs from '.$date;
	}
	return $out;
}
function checkLogs($date){
	$file = dateToFilename($date);
	if(file_exists($file)){
		$fp = fopen($file, 'r');
		$out = fread($fp, filesize($file));
		fclose($fp);
	}else{
		$out = 'There are no logs from '.$date;
	}
	return $out;
}

session_start();
if($_SESSION['logged_in'] != true){
	if(isset($_POST['user'])&&isset($_POST['pass'])){
		signIn($_POST['user'], $_POST['pass']);
	}else{
		die('<form method="post">
	<label for="user">Username:</label> <input type="text" id="user" name="user"/><br />
	<label for="pass">Password:</label> <input type="password" id="pass" name="pass"/><br />
	<input type="submit" value="Sign In"/>
</form>');
	}
}

if(isset($_POST['act'])&&isset($_POST['date'])){
	if($_POST['act'] == 'check'){
		$output = checkLogs($_POST['date']);
		die('<!DOCTYPE html>
<html lang="en">
	<head>
		<title>HoneYLoG &mdash; Check Logs</title>
		<meta name="robots" content="noindex"/><!-- unnecessary, but Idc -->
		<meta name="googlebot" content="noindex"/><!-- unnecessary, but Idc -->
	</head>
	<body>
		<div style="position: absolute; top: 0; left: 10px;">
			<small><a href="honeylog.php">Go back to input</a> || <a href="honeylog.php?sess_destroy=y">Sign Out</a></small>
		</div>
		<center>
			<h1>HoneYLoG</h1>
			<small>&mdash; by Amp &mdash;</small>
			<p>Logs of '.$_POST['date'].'</p>
			<textarea style="width: 400px; height: 500px;" readonly>'.$output.'</textarea>
		</center>
	</body>
</html>');
	}elseif($_POST['act'] == 'edit'){
		if(isset($_POST['input'])){
			$output = editLogs($_POST['date'], $_POST['input']);
			die('<!DOCTYPE html>
<html lang="en">
	<head>
		<title>HoneYLoG &mdash; Edited Logs</title>
		<meta name="robots" content="noindex"/><!-- unnecessary, but Idc -->
		<meta name="googlebot" content="noindex"/><!-- unnecessary, but Idc -->
	</head>
	<body>
		<div style="position: absolute; top: 0; left: 10px;">
			<small><a href="honeylog.php">Go back to input</a> || <a href="honeylog.php?sess_destroy=y">Sign Out</a></small>
		</div>
		<center>
			<h1>HoneYLoG</h1>
			<small>&mdash; by Amp &mdash;</small>
			<p>Successfully edited logs of '.$_POST['date'].'</p>
			<textarea style="width: 400px; height: 500px;" readonly>'.$output.'</textarea>
		</center>
	</body>
</html>');
		}else{
			$contents = checkLogs($_POST['date']);
			die('<div style="position: absolute; top: 0; left: 10px;">
	<small><a href="honeylog.php">Go back to input</a> || <a href="honeylog.php?sess_destroy=y">Sign Out</a></small>
</div>
<div style="margin-top: 60px; margin-left: 100px;">Edit Logs of '.$_POST['date'].'</div>
<form method="post">
	<input type="hidden" name="act" value="'.$_POST['act'].'"/>
	<input type="hidden" name="date" value="'.$_POST['date'].'"/>
	<textarea id="input" style="width: 400px; height: 500px;" name="input">'.$contents.'</textarea>
	<input type="submit" value="save"/>
</form>');
		}
	}elseif($_POST['act'] == 'delete'){
		$output = deleteLogs($_POST['date']);
	}
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>HoneYLoG &mdash; Amp</title>
		<meta name="robots" content="noindex"/>
		<meta name="googlebot" content="noindex"/>
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
		<script>
			function insForm(act){
				if (act == 'check') {
					document.getElementById('insFormDIV').innerHTML = '<form style="margin-top: 10px; margin-bottom: 10px;" method="post"><input type="hidden" name="act" value="check"/><label for="date">Date of Logs: (dd-mm-yyyy)</label> <input type="date" id="date" name="date"/><br /><button onclick="insFormToday(' + act + ')">set to today</button><input type="submit" value="Check Logs"/></form>';
				} else if (act == 'edit') {
					document.getElementById('insFormDIV').innerHTML = '<form style="margin-top: 10px; margin-bottom: 10px;" method="post"><input type="hidden" name="act" value="edit"/><label for="date">Date of Logs: (dd-mm-yyyy)</label> <input type="date" id="date" name="date"/><br /><button onclick="insFormToday(' + act + ')">set to today</button><input type="submit" value="Edit Logs"/></form>';
				} else if (act == 'delete') {
					document.getElementById('insFormDIV').innerHTML = '<form style="margin-top: 10px; margin-bottom: 10px;" method="post"><input type="hidden" name="act" value="delete"/><label for="date">Date of Logs: (dd-mm-yyyy)</label> <input type="date" id="date" name="date"/><br /><button onclick="insFormToday(' + act + ')">set to today</button><input type="submit" value="Delete Logs"/></form>';
				} else {
					document.getElementById('insFormDIV').innerHTML = '<strong>Error:</strong> Invalid action passed. Refreshing in 3 seconds...<meta http-equiv="Refresh" content="3"/>';
				}
			}
			function insFormToday(act) {
				if (act == 'check') {
					document.getElementById('insFormDIV').innerHTML = '<form style="margin-top: 10px; margin-bottom: 10px;" method="post"><input type="hidden" name="act" value="check"/><label for="date">Date of Logs: (dd-mm-yyyy)</label> <input type="date" id="date" name="date" value="<?php echo date("Y-m-d"); ?>"/><br /><button onclick="insFormToday(' + act + ')">set to today</button><input type="submit" value="Check Logs"/></form>';
				} else if (act == 'edit') {
					document.getElementById('insFormDIV').innerHTML = '<form style="margin-top: 10px; margin-bottom: 10px;" method="post"><input type="hidden" name="act" value="edit"/><label for="date">Date of Logs: (dd-mm-yyyy)</label> <input type="date" id="date" name="date" value="<?php echo date("Y-m-d"); ?>"/><br /><button onclick="insFormToday(' + act + ')">set to today</button><input type="submit" value="Edit Logs"/></form>';
				} else if (act == 'delete') {
					document.getElementById('insFormDIV').innerHTML = '<form style="margin-top: 10px; margin-bottom: 10px;" method="post"><input type="hidden" name="act" value="delete"/><label for="date">Date of Logs: (dd-mm-yyyy)</label> <input type="date" id="date" name="date" value="<?php echo date("Y-m-d"); ?>"/><br /><button onclick="insFormToday(' + act + ')">set to today</button><input type="submit" value="Delete Logs"/></form>';
				} else {
					document.getElementById('insFormDIV').innerHTML = '<strong>Error:</strong> Invalid action passed. Refreshing in 3 seconds...<meta http-equiv="Refresh" content="3"/>';
				}
		</script>
	</head>
	<body>
<?php if(isset($output)){
	echo '		<center>
			<pre style="margin-top: 5px; width: 350px; background-color: rgb(0,255,0); border-radius: 4px; border: 1px solid; color: rgb(0,0,0);" noscroll>'.$output.'</pre>
		</center>';
} ?>
		<div style="position: absolute; top: 0; left: 10px;">
			<small><a href="honeylog.php">Refresh</a> || <a href="honeylog.php?sess_destroy=y">Sign Out</a></small>
		</div>
		<div style="text-align: center;">
			<h1>HoneYLoG</h1>
			<small>&mdash; by Amp &mdash;</small>
			<center>
				<fieldset style="width: 800px;">
					<p style="width: 50% margin: 0 auto;">What do you want to do?</p>
					<div style="width 50% margin: 0 auto; text-align: center;">
						<button onclick="insForm('check');">Check Logs</button><button onclick="insForm('edit');">Edit Logs</button><button onclick="insForm('delete');">Delete Logs</button>
					</div><br />
					<div id="insFormDIV" style="width: 50%; margin: 0 auto; border: 1px solid; text-align: center;"></div>
				</fieldset>
			</center>
		</div>
	</body>
</html>
