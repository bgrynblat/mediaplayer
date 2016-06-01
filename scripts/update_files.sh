#!/bin/bash

OUTPUT=tmps/files.last.test
TMP=tmps/files.tmp

BASE_FOLDER=medias

ls -RhlL $BASE_FOLDER > $TMP


CURRENT=""
STR="{\"updated\":\"`date`\", \"files\":["
FILES=0
while read LINE ; do
	#echo $LINE
	if [[ $LINE == $BASE_FOLDER* ]] ; then
		CURRENT=`echo $LINE | cut -d: -f1`
		#echo $CURRENT
	elif [[ $LINE == -r* ]] ; then
		FN=`echo $LINE | awk {'print $9'}`
		FPATH="$CURRENT/$FN"
		SIZE=`echo $LINE | awk {'print $5'}`
		#echo "FILE : $FN $FPATH ($SIZE)"
		STR=$STR"{\"url\":\"$FPATH\",\"path\":\"$FPATH\",\"filename\":\"$FN\",\"size\":\"$SIZE\"},"
		let FILES=$FILES+1
	fi
		
	
done < $TMP

if [ $FILES -gt 0 ] ; then
	STR="${STR::-1}"
fi

STR=$STR"]}"

echo $STR
