<?php
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$path = $_POST['path'].'.cpp';
		$code = $_POST['code'];
		if(file_put_contents($path,$code)){
			echo 'Saved Successfully.';
		} else {
			echo 'Error in Saving File.';
		}
	}
?>