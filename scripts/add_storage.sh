#!/bin/bash

if [ $# -lt 1 ] ; then
	echo "Usage : $0 <mounting_point>"
	exit
fi

FILE="tmps/storages.cfg"

if [ -f $FILE ] ; then
	THERE=`cat $FILE | grep $1 | wc -l`
	if [ $THERE -eq 0 ] ; then
		echo $1 >> $FILE
	fi
else
	echo $1 >> $FILE
fi
