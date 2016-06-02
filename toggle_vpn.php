<?php

	include('functions.php');

	if(isset($_GET["force"])) {
		$ret = executeCommand("ls tmps/forcevpn.yes ; echo $?");

		if($ret == "0") {
			executeCommand("sudo rm tmps/forcevpn.yes ; sudo pkill -9 force_vpn.sh");
		} else {
			executeCommand("sudo touch tmps/forcevpn.yes ; sudo scripts/force_vpn.sh > ".$_ENV["TMP_FOLDER"]."/force_vpn.log &");
		}
	} else {
	$dev = "";
	$enabled = false;

	switch ($_ENV["VPN"]["type"]) {
		case "openvpn":
			$dev = "tun0";
			$val = exec("sudo service openvpn status; echo $?");
			if($val == "0")
				echo exec("sudo pkill -9 openvpn");
			else {
				//echo exec("sudo service openvpn start");
				echo exec("sudo openvpn /etc/openvpn/Netherlands.ovpn > /tmp/vpn.log 2>&1 &");
				$enable = true;
			}
			break;

		case "pptp":
			$dev = "ppp0";
			$val = executeCommand("/sbin/ifconfig ppp0 | wc -l");
			if($val == "0")	 { //VPN is deactivated
				echo executeCommand("sudo pon unifiedvpn.com 2>&1");
				$enable = true;
			} else {
				echo executeCommand("sudo poff 2>&1");
			}
			break;
	}

        $vpn = checkVPNStatus();
        $attempts = 0;
        echo ($vpn == true ? "on" : "off");
        echo "\n";
                 
	if($enable) {
        	while($vpn == false && $attempts < 5) {
        		echo "wait\n";
        	        sleep(2);
        	        $vpn = checkVPNStatus();
        	        echo ($vpn == true ? "on" : "off");
        	        $attempt += 1;
        	}
        
		echo "attempts : $attempts \n";
		echo "sudo ip route add default dev $dev \n";

		echo executeCommand("/sbin/ifconfig $dev | tr \"\n\" \"|\"");

		//echo exec("sudo ip route add default dev $dev 2>&1");
		echo "\n";
		sleep(5);
		//echo exec("sudo route add -net 0.0.0.0 dev $dev 2>&1");
	}
	}
?>
