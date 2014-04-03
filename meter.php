<?php
$ip = file_get_contents('_ip.txt');

$file = file_get_contents('http://' . $ip . '/upCountDelta.txt');
$fileArr = explode("\n", $file);
$lineArr = preg_split('/\s+/', $fileArr[0]);

$counter = 0;
$counter = $lineArr[1];
$counter = $counter / 1000;

$meter = 0;
$meterFile = "meter.txt";
if (file_exists($meterFile) && is_readable($meterFile)) {
	$fh = fopen($meterFile, "r");
	while (!feof($fh)) {
		$meterArray = split("\|", trim(fgets($fh)));
		if (count($meterArray) == 3) {
			$meter = intval($meterArray[2]);
			$meterCount = intval($meterArray[1])/1000;
		}
	}
	fclose($fh);
}

$meterReading = number_format($meter + $counter - $meterCount, 3, '.', '');

$pPerKW = 0.14931;
$secsPerWatt = floatval($lineArr[2]);
if ($secsPerWatt > 0) {
	$kWh = round(60 * 60 * 0.001 / $secsPerWatt, 3);
	$cost = round($kWh * $pPerKW, 3);
	echo "$meterReading $cost $kWh $pPerKW //reading &pound;/h kWh tariff";
} else {
	echo $file;
}
?>