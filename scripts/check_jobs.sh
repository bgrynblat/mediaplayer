#!/bin/bash

PREFIX="tmps"

/usr/bin/transmission-remote -n 'transmission:transmission' -l | tr "\n" "|" | sed -e's/  /;/g' | sed -e 's/;;*/;/g' |  sed -e's/; */;/g' | sed -e's/|;*/|/g'
