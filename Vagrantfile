# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/xenial64"

  config.vm.provider "virtualbox" do |vb|
    vb.customize ["modifyvm", :id, "--uartmode1", "disconnected"]
  end

  config.vm.synced_folder ".", "/vagrant", type: "nfs", rsync__exclude: [".vagrant/", "Vagrantfile", "ubuntu-xenial-16.04-cloudimg-console.log"]

  config.vm.network "private_network", ip: "192.168.33.99"
    config.vm.provision "shell", inline: <<-SHELL
        apt-get update
        apt-get upgrade --assume-yes
        add-apt-repository ppa:ondrej/php
        apt-get update
        apt-get install vim php7.1 php7.1-cli php7.1-common php7.1-curl php7.1-gd php7.1-json php7.1-mbstring php7.1-mysql php7.1-opcache php7.1-readline php7.1-xml libapache2-mod-php7.1 apt-transport-https git apache2 --assume-yes
        sed -i -e 's$DocumentRoot /var/www/html$DocumentRoot /vagrant$g' /etc/apache2/sites-available/000-default.conf
        sed -i -e 's$<Directory /var/www/>$<Directory /vagrant/>$g' /etc/apache2/apache2.conf
        systemctl restart apache2
        (echo -e "syntax on\nset ai" >> /root/.vimrc) && (cp /root/.vimrc /home/ubuntu/.vimrc)
        cd / && curl -sS https://getcomposer.org/installer | php
        mv composer.phar /usr/local/bin/composer
    SHELL
  end
