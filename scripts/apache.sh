#!/bin/bash

sed -i -e 's$DocumentRoot /var/www/html$DocumentRoot /vagrant/public$g' /etc/apache2/sites-available/000-default.conf
sed -i -e 's$<Directory /var/www/>$<Directory /vagrant/>$g' /etc/apache2/apache2.conf
sed -i '/<Directory \/vagrant\/>/!b;n;n;c\\tAllowOverride all' /etc/apache2/apache2.conf

a2enmod rewrite

systemctl restart apache2
