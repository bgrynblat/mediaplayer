#!/bin/bash

PREFIX="tmps"

/usr/bin/transmission-remote -n 'transmission:transmission' -l | sed -e's/  */ /g' | tr "\n" "|" | sed -e's/| */|/g'
