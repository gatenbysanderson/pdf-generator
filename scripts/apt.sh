#!/bin/bash

apt-get update
apt-get upgrade --assume-yes
add-apt-repository ppa:ondrej/php
apt-get update

echo ttf-mscorefonts-installer msttcorefonts/accepted-mscorefonts-eula select true | sudo debconf-set-selections

apt-get install vim php7.1 php7.1-cli php7.1-common php7.1-curl php7.1-gd php7.1-json php7.1-mbstring php7.1-mysql php7.1-opcache php7.1-readline php7.1-xml php7.1-sqlite3 libapache2-mod-php7.1 sqlite3 apt-transport-https git apache2 libcairo2 libgif7 libgomp1 libpixman-1-0 ttf-mscorefonts-installer --assume-yes

if ! type "prince" > /dev/null 2>&1; then
  (cd /) && (wget -O prince.deb http://www.princexml.com/download/prince_11.3-1_ubuntu16.04_amd64.deb)
  (dpkg -i prince.deb) && (rm -f prince.deb)
fi;
