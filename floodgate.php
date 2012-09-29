<?php
$limit = 1000; // in ms

$key = "floodgate_time";

function passFloodGate($dontDie = false) {
	global $limit, $key;
	
	$current_request = microtime(true)*1000;

	if (apc_exists($key)) {
		$last_request = apc_fetch($key);	
		if (($current_request - $last_request) < $limit) {
			if (!dontDie) {
				echo "Rate exceeded.";
				die();
			} else {
				return false;
			}
		}
	}
	apc_store($key, $current_request);
	return true;
}

?>
