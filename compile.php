<?php
	$cwd = getcwd();
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$path = $_POST['path'];
		$comm = "g++ $cwd/".$path.".cpp -o $cwd/".$path.".exe -std=c++11 2>&1";
		exec($comm,$out);
		echo implode("\n",$out);
		// echo $comm;
	}
?>