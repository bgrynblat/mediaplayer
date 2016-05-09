#!/bin/bash

echo "Enter app name (app will be available at http://localhost/<app_name>) : "
read APP_NAME

sudo apt-get -y install nginx php5-fpm
sudo apt-get -y install transmission-daemon

mkdir torrents && chmod 777 torrents
mkdir tmps && chmod 777 tmps
mkdir medias && chmod 777 medias
sudo chmod 777 scripts

sudo ln -s `pwd` /var/www/html/$APP_NAME

MEDIA_FOLDER=/var/lib/transmission-daemon/downloads/
ln -s $MEDIA_FOLDER medias/transmission-dl

sudo cp nginx.conf.default /etc/nginx/sites-available/default
sudo service nginx reload
