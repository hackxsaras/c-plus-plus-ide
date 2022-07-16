<?php
$cwd = getcwd();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$path = $_POST['path'];
	$input = $_POST['input'];
	$timeout = (isset($_POST["timeout"]))? $_POST['timeout']:1;
	$descriptorspec = array(
		0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
		1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
		2 => array("file", "$cwd/contests/temp/error-output.txt", "w") // stderr is a file to write to
	);

	$process = proc_open("$cwd/" . $path . '.exe', $descriptorspec, $pipes);
	if (is_resource($process)) {
		fwrite($pipes[0], $input);
		fclose($pipes[0]);
		
		sleep($timeout);
		
		$buffer = '';
		$read  = array($pipes[1]);
		$other = array();
		stream_select($read, $other, $other, $timeout);
		
		$status = proc_get_status($process);
		$exitCode = 0;
		if($status["running"]){
			$pid = $status['pid'];
			$output = array_filter(explode(" ", shell_exec("wmic process get parentprocessid,processid | find \"$pid\"")));  
			array_pop($output);  
			
			//Process Id is  
			$pid = end($output); 
			file_put_contents("$cwd/contests/temp/error-output.txt", "\n\n\nKilling process:$pid due to timeout($timeout s)", FILE_APPEND);
			exec("taskkill /PID $pid /F");
		}
		
		$buffer .= stream_get_contents($pipes[1]);
		// file_put_contents("$cwd/contests/temp/error-output.txt", $buffer);
		// system("notepad.exe $cwd/contests/temp/error-output.txt");
		echo $buffer;
		
		$exitCode = proc_close($process);

		$return_value = ($status["running"] ? $exitCode : $status["exitcode"] );
		echo file_get_contents("$cwd/contests/temp/error-output.txt");
		echo '<br><br><b>Return Code:' . $return_value . '</b>';
	}


	// if (is_resource($process)) {
	// 	fwrite($pipes[0], $input);
	// 	fclose($pipes[0]);
	// 	$timeout = 5 * 1000000;
	// 	$buffer = '';
	// 	system("notepad.exe $cwd/contests/temp/error-output.txt");
	// 	$start = microtime(true);
	// 	while (microtime(true) - $start < $timeout) {
	// 		$read  = array($pipes[1]);
	// 		$other = array();
	// 		stream_select($read, $other, $other, 0, $timeout);
	// 		$status = proc_get_status($process);
	// 		$buffer .= stream_get_contents($pipes[1]);
	// 		if (!$status['running']) {
	// 			break;
	// 		}
	// 		file_put_contents("$cwd/contests/temp/error-output.txt", (microtime(true) - $start));
	// 	}
	// 	system("notepad.exe $cwd/contests/temp/error-output.txt");
	// 	echo $buffer;
	// 	$status = proc_get_status($process);
	// 	if ($status['running'] == true) { //process ran too long, kill it
	// 		$ppid = $status['pid'];
	// 		echo "\nKilling process ".$ppid."\n";
	// 		$pids = preg_split('/\s+/', `ps -o pid --no-heading --ppid $ppid`);
	// 		foreach ($pids as $pid) {
	// 			if (is_numeric($pid)) {
	// 				echo "Killing due to timeout id: $pid\n";
	// 				posix_kill($pid, 9); //9 is the SIGKILL signal
	// 			}
	// 		}
	// 		proc_close($process);
	// 	} else {
	// 		$return_value = proc_close($process);
	// 		echo file_get_contents("$cwd/contests/temp/error-output.txt");
	// 		echo '<br><br><b>Return Code:' . $return_value . '</b>';
	// 	}
	// }
}
?>