#!/bin/bash

if [ $# -lt 1 ] ; then
	echo "Usage : $0 <torrent_url>"
	exit 2
fi

FILE=`echo $1 | rev | cut -d"/" -f1 | rev`
PREFIX="torrents/"
PATH="$PREFIX$FILE"

URL=`echo "$1" | /bin/sed -e 's/\[/\\\[/g' | /bin/sed -e 's/\]/\\\]/g'`

echo $URL
/usr/bin/curl "$URL" > $PATH
echo $PATH
