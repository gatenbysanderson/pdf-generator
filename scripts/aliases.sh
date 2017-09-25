#!/bin/bash

rm -f /home/ubuntu/.bash_aliases
touch /home/ubuntu/.bash_aliases

echo "alias tinker=\"/vagrant/vendor/bin/psysh\"" >> /home/ubuntu/.bash_aliases
