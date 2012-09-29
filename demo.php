<?php
require_once("floodgate.php");

if (passFloodGate(false)) {
	echo "Made it.";
} else {
	echo "Too many requests.";
}
?>
