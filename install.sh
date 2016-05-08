#!/bin/bash



#sudo apt-get -y install nginx php-fpm
## Should be replaced with transmission-daemon
#sudo apt-get -y install transmission-cli

mkdir torrents && chmod 777 torrents
mkdir tmps && chmod 777 tmps

sudo ln -s . /var/www/html/media

MEDIA_FOLDER=/home/bgr/dl
ln -s $MEDIA_FOLDER medias
sudo chown 777 medias
