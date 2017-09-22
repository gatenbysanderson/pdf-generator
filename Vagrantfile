# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
  config.vm.box = "debian/jessie64"

  config.vm.synced_folder ".", "/vagrant", type: "nfs", rsync__exclude: [".vagrant/", "Vagrantfile"]

  config.vm.network "private_network", ip: "192.168.33.99"
    config.vm.provision "shell", inline: <<-SHELL
    apt-get update
    apt-get upgrade --assume-yes
    apt-get install vim php5-common libapache2-mod-php5 apache2 --assume-yes
    systemctl restart apache2
    (echo -e "syntax on\nset ai" >> /root/.vimrc) && (cp /root/.vimrc /home/vagrant/.vimrc)

    SHELL
  end
