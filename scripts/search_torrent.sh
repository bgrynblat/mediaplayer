#!/bin/bash

if [ $# -lt 1 ] ; then
	echo "Usage : $0 <search>"
	exit 2
fi

PREFIX="tmps/"
PATH="$PREFIX$1"

curl=/usr/bin/curl
grep=/bin/grep
rm=/bin/rm
cat=/bin/cat

echo $PATH

$curl https://eztv.ag/search/$1 > $PATH.tmp
$cat $PATH.tmp | $grep torrent | $grep -v magnet: | $grep -v RSS > $PATH.links

$rm -vf $PATH.tmp
