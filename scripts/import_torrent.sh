#!/bin/bash

if [ $# -lt 1 ] ; then
	echo "Usage : $0 <torrent_url>"
	exit 2
fi

FILE=`echo $1 | rev | cut -d"/" -f1 | rev`
PREFIX="torrents/"
PATH="$PREFIX$FILE"

echo $PATH

/usr/bin/wget -P $PREFIX $1
/usr/bin/transmission-remote -n 'transmission:transmission' -a $PATH
