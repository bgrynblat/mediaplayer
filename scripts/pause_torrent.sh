#!/bin/bash

if [ $# -lt 1 ] ; then
	echo "Usage : $0 <torrent>"
	exit 2
fi

TORRENT=`/usr/bin/transmission-remote -n 'transmission:transmission' -l | grep $1`
ID=`echo $TORRENT | cut -d" " -f1`

/usr/bin/transmission-remote -n 'transmission:transmission' -S -t $ID
