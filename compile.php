<?php
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$path = $_POST['path'];
		$comm = 'g++ C:/xampp/htdocs/cpp/'.$path.'.cpp -o C:/xampp/htdocs/cpp/'.$path.'.exe -std=c++11 2>&1';
		exec($comm,$out);
		echo implode("\n",$out);
		// echo $comm;
	}
?>