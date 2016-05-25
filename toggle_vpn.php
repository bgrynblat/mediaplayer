<?php

	include('functions.php');

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
			$val = exec("ifconfig ppp0; echo $?;");
			if($val == "0")	//VPN is activated
				echo exec("sudo poff 2>&1");
			else {
				echo exec("sudo pon unifiedvpn.com 2>&1");
				$enable = true;
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

		echo exec("ifconfig $dev | tr \"\n\" \"|\"");

		//echo exec("sudo ip route add default dev $dev 2>&1");
		echo "\n";
		sleep(5);
		echo exec("sudo route add -net 0.0.0.0 dev $dev 2>&1");
	}
?>
