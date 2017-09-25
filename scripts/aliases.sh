#!/bin/bash

rm -f /root/.bash_aliases && rm -f /home/ubuntu/.bash_aliases
touch /root/.bash_aliases && touch /home/ubuntu/.bash_aliases

echo "alias tinker=\"/vagrant/vendor/bin/psysh\"" | tee -a /root/.bash_aliases /home/ubuntu/.bash_aliases
echo "alias phpunit=\"/vagrant/vendor/bin/phpunit\"" | tee -a /root/.bash_aliases /home/ubuntu/.bash_aliases
