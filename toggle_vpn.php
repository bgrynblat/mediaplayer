<?php

	$val = exec("sudo service openvpn status; echo $?");
	if($val == "0")
		echo exec("sudo service openvpn stop");
	else
		echo exec("sudo service openvpn start");
		

?>
