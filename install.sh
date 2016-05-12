#!/bin/bash

echo "Enter app name (app will be available at http://localhost/<app_name>) : "
read APP_NAME

sudo apt-get -y install nginx php5-fpm
sudo apt-get -y install transmission-daemon

sudo service transmission-daemon stop

mkdir torrents && chmod 777 torrents
mkdir tmps && chmod 777 tmps
mkdir medias && chmod 777 medias
sudo chmod 777 scripts

sudo ln -s `pwd` /var/www/html/$APP_NAME

MEDIA_FOLDER=/var/lib/transmission-daemon/downloads/
ln -s $MEDIA_FOLDER medias/transmission-dl

sudo cp nginx.conf.default /etc/nginx/sites-available/default
sudo service nginx reload

CURRENT="`pwd`/medias"
sed -e "s|{dl_folder}|${CURRENT}|g" transmission-settings.json.default > transmission-settings.json
sudo cp transmission-settings.json /etc/transmission-daemon/settings.json

sudo service transmission-daemon start

SUDOER=`sudo -- sh -c 'cat /etc/sudoers | grep www-data | wc -l'`
if [ $SUDOER -eq 0 ] ; then
	sudo -- sh -c 'echo "www-data ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers'
fi
