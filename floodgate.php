<?php
$limit = 1000; // in ms
$pers_enginge = "filesystem"; // Persistence engine: filesystem or apc

$apc_key = "floodgate_time";
$fs_filename = "/tmp/phpfloodgate.txt";

function passFloodGate($dontDie = false) {
	global $limit, $key;
	
	$current_request = microtime(true)*1000;

	if (_exists()) {
		$last_request = _get();	
		if (($current_request - $last_request) < $limit) {
			if (!$dontDie) {
				echo "Rate exceeded.";
				die();
			} else {
				return false;
			}
		}
	}
	_put($current_request);
	return true;
}

/********************************
 * Persistence abstraction
 ********************************/
 
function _exists() {
	global $pers_engine, $apc_key, $fs_filename;
	
	return $pers_engine == "apc"
		? apc_exists($apc_key)
		: file_exists($fs_filename);
}

function _get() {
	global $pers_engine, $apc_key, $fs_filename;
	
	return $pers_engine == "apc"
		? apc_fetch($apckey)
		: file_get_contents($fs_filename);
}

function _put($value) {
	global $pers_engine, $apc_key, $fs_filename;
	
	return $pers_engine == "apc"
		? apc_store($apc_key, $value)
		: file_put_contents($fs_filename, $value);
}
?>
