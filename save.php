<?php
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$path = $_POST['path'].'.cpp';
		$code = $_POST['code'];
		date_default_timezone_set('Asia/Kolkata');
		$t = date('d/m/Y h:i:s a', time());
		if(file_put_contents($path,$code)){
			echo 'Last saved at '.$t;
		} else {
			echo 'Error in Saving File.';
		}
	}
?>