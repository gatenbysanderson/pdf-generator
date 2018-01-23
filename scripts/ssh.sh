#!/bin/bash

echo #{ssh_pub_key} >> /home/vagrant/.ssh/authorized_keys
echo #{ssh_pub_key} >> /root/.ssh/authorized_keys

tee -a ~/.ssh/config << END
Host github.com
  ForwardAgent yes
END
