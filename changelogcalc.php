<?php
	#linux
	$var_deviceid = $_POST['deviceid'];
	$var_telemetry = $_POST['telemetry'];
	$var_date1 = $_POST['date1'];
        $var_date2 = $_POST['date2'];
        $var_time1 = $_POST['time1'];
        $var_time2 = $_POST['time2'];
        $var_mode = $_POST['mode'];
        $var_format = $_POST['Export'];
        $var_interval = $_POST['interval'];

        $var_interval = $var_intercal * 60;
	$var_startdate = $var_date1.'T'.$var_time1;
        $var_endate = $var_date2.'T'.$var_time2;
	$var_arrtel = '';

	$i=0;
	$len = count($var_telemetry);
	foreach ($var_telemetry as $key) {
		if($i == $len - 1){
			$var_arrtel .= $key;
		}else{
			$var_arrtel .= $key.',';
		}
		$i++;
	}

        #removing space
	$var_arrtel = preg_replace('/\s/', '', $var_arrtel);
	#converting into unix epoch
        $startdate = (strtotime($var_startdate)*1000)-21600000;
	$endate = (strtotime($var_endate)*1000)-21600000;
        
	$command = escapeshellcmd('python3.6 tc.py --mode exportLog --entity_type DEVICE --entity_id '.$var_deviceid.' --keyList '.$var_arrtel.' --startTs '.$startdate.' --endTs '.$endate.' --interval '.$var_interval.' --isTelemetry 1 --limit 500 --agg '.$var_interval.' --format '.$var_format.'');
	#$output = shell_exec($command);
        $output = exec($command);
	#echo $command;

	#jangan lupa ganti dir nya buat download file (local sama yang di vm beda)
	#$file = '/var/www/html/ExportResult/DataLog_'.date("Y-m-d", substr($startdate, 0, 10)).'_sd_'.date("Y-m-d", substr($endate, 0, 10)).'.xlsx';
        $file = $output;
        echo $file;
	if(file_exists($file)){
		header('Content-Type: application/octet-stream');
		header("Content-Transfer-Encoding: Binary");
        	header("Content-disposition: attachment; filename=\"" . basename($file) . "\"");
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        	header('Pragma: public');
        	ob_clean();
        	flush(); 
		readfile($file);
		exit;
	}

?>
