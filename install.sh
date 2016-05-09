#!/bin/bash

sudo apt-get -y install nginx php5-fpm
sudo apt-get -y install transmission-daemon

mkdir torrents && chmod 777 torrents
mkdir tmps && chmod 777 tmps

sudo ln -s `pwd` /var/www/html/media

MEDIA_FOLDER=/var/lib/transmission-daemon/downloads/
ln -s $MEDIA_FOLDER medias/transmission-dl


sudo chmod 777 medias

sudo chmod 777 scripts
