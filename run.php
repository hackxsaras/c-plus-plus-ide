<?php
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$path = $_POST['path'];
		$input = $_POST['input'];
		$descriptorspec = array(
		   0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
		   1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
		   2 => array("file", "C:/xampp/htdocs/cpp/contests/temp/error-output.txt", "w") // stderr is a file to write to
		);

		$process = proc_open('C:/xampp/htdocs/cpp/'.$path.'.exe', $descriptorspec, $pipes);
		
		if (is_resource($process)) {
			fwrite($pipes[0], $input);
			fclose($pipes[0]);
			$timeout = 5*1000000;
			$buffer='';
			while ($timeout > 0) {
				$start = microtime(true);
				$read  = array($pipes[1]);
				$other = array();
				stream_select($read, $other, $other, 0, $timeout);
				$status = proc_get_status($process);
				$buffer .= stream_get_contents($pipes[1]);
				if (!$status['running']) {
				  break;
				}
				$timeout -= (microtime(true) - $start) * 1000000;
			  }
			echo $buffer;
			$status = proc_get_status($process);
			if($status['running'] == true) { //process ran too long, kill it
				$ppid = $status['pid'];
				cout<<"pid"<<"\n";
				$pids = preg_split('/\s+/', `ps -o pid --no-heading --ppid $ppid`);
				foreach($pids as $pid) {
					if(is_numeric($pid)) {
						echo "Killing due to timeout id: $pid\n";
						posix_kill($pid, 9); //9 is the SIGKILL signal
					}
				}
				proc_close($process);
			}
			else{
				$return_value = proc_close($process);
				echo '<br><br><b>Return Code:'.$return_value.'</b>';
			}
		}
	}
?>