#!/bin/bash

while [ 1 -eq 1 ] ; do

CFG="config.default"
if [ -f "config.cfg" ] ; then
	CFG="config.cfg"
fi

FORCE=`cat $CFG | grep VPN | grep force | cut -d"=" -f2 | sed 's/;//' | sed 's/ //'`

echo -n "`date`:"

if [ $FORCE == "true" ] ; then
	VPN=`ifconfig ppp0 | wc -l`
	# VPN deactivated
	if [ $VPN == "0" ] ; then 
		/usr/bin/transmission-remote -n 'transmission:transmission' -l | tail -n +2 | head -n -1 > tmps/jobs.tmp
		let NB_JOBS=`cat tmps/jobs.tmp | wc -l`
		JOBS=`cat tmps/jobs.tmp | grep -v " Stopped   " | awk '{print $1}'`

		if [ $NB_JOBS -gt 0 ] ; then
			#echo "$NB_JOBS jobs, stopping transmission"
			for J in $JOBS ; do
				echo "/usr/bin/transmission-remote -n 'transmission:transmission' -t $J -S"
				/usr/bin/transmission-remote -n 'transmission:transmission' -t $J -S 2>&1
			done
		else
			echo "No job to stop"
		fi
		
	else
		echo "VPN ON, do nothing"
	fi
fi
sleep 5

LOG="tmps/force_vpn.log"
let LINES=`wc -l $LOG | cut -d" " -f1`
if [ $LINES -gt 10000 ] ; then
	echo "trunc file" > $LOG
fi

done
